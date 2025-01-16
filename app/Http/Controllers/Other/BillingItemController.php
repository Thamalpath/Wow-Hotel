<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\BillingItem;
use App\Models\Room;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class BillingItemController extends Controller
{
    public function index()
    {
        $rooms = Room::with('registration')
            ->where('status', 'Received')
            ->whereHas('registration', function($query) {
                $query->whereColumn('key_room', 'rooms.room_no');
            })
            ->get();
                
        $items = Item::where('item_cat', 'R')->get();
            
        return view('dashboard.billing', compact('rooms', 'items'));
    }

    public function otherBillingIndex()
    {
        $rooms = Room::with('registration')
            ->where('status', 'Received')
            ->whereHas('registration', function($query) {
                $query->whereColumn('key_room', 'rooms.room_no');
            })
            ->get();
                
        $items = Item::where('item_cat', 'O')->get();
            
        return view('dashboard.other-billing', compact('rooms', 'items'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'allocated_room_no' => 'required|string',
                'guest_name' => 'required|string',
                'bill_date' => 'required|date',
                'bill_no' => 'required|integer',
                'bill_items' => 'required|array'
            ]);

            DB::beginTransaction();

            if ($request->allocated_room_no === 'Other Billing') {
                foreach ($request->bill_items as $item) {
                    BillingItem::create([
                        'item_code' => $item['itemCode'],
                        'item_name' => $item['itemName'],
                        'price' => $item['price'],
                        'allocated_room_no' => $request->allocated_room_no,
                        'bill_date' => $request->bill_date,
                        'qty' => $item['qty'],
                        'bill_total' => $item['total'],
                        'bill_no' => $request->bill_no,
                        'guest_name' => $request->guest_name,
                        'item_cat' => $item['itemCat'],
                        'reservation_date' => now(),
                        'reservation_code' => 'OB-' . $request->bill_no,
                        'key_room' => 'OTHER'
                    ]);
                }
            } else {
                $registration = Registration::where('allocated_room_no', $request->allocated_room_no)
                    ->where('key_room', $request->allocated_room_no)
                    ->first();

                foreach ($request->bill_items as $item) {
                    BillingItem::create([
                        'item_code' => $item['itemCode'],
                        'item_name' => $item['itemName'],
                        'price' => $item['price'],
                        'allocated_room_no' => $request->allocated_room_no,
                        'bill_date' => $request->bill_date,
                        'qty' => $item['qty'],
                        'bill_total' => $item['total'],
                        'bill_no' => $request->bill_no,
                        'guest_name' => $request->guest_name,
                        'item_cat' => $item['itemCat'],
                        'reservation_date' => $registration->reservation_date,
                        'reservation_code' => $registration->reservation_code,
                        'key_room' => $registration->key_room
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getLatestBillings()
    {
        $billings = BillingItem::select('allocated_room_no', 'guest_name', 'bill_date', 'bill_no', 'key_room')
            ->where('item_cat', 'R')
            ->whereDate('bill_date', now())
            ->distinct()
            ->orderBy('bill_date', 'desc')
            ->get();

        return response()->json($billings);
    }

    public function getLatestOtherBillings()
    {
        $billings = BillingItem::select('allocated_room_no', 'guest_name', 'bill_date', 'bill_no', 'key_room')
            ->where('item_cat', 'O')
            ->distinct()
            ->orderBy('bill_date', 'desc')
            ->get();

        return response()->json($billings);
    }

    public function destroyAll($billNo)
    {
        try {
            $billingItems = BillingItem::where('bill_no', $billNo)->get();
            
            if ($billingItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No billing items found'
                ], 404);
            }

            $reservationCode = $billingItems->first()->reservation_code;
            
            BillingItem::where('bill_no', $billNo)
                ->where('reservation_code', $reservationCode)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Billing items deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting billing items: ' . $e->getMessage()
            ], 500);
        }
    }
}