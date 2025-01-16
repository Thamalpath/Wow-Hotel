<?php

namespace App\Http\Controllers\Other;

use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\BillDetailsMail;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\BillingItem;
use App\Models\Rate;

class CheckoutController extends Controller
{
    public function show($hash)
    {
        try {
            $id = decrypt($hash);
            $registration = Registration::findOrFail($id);
            
            $otherCharges = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->whereIn('item_cat', ['R', 'O'])
                ->get();

            $advancePayments = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->where('item_cat', 'AP')
                ->get();

            $total = $registration->rs + $otherCharges->sum('bill_total');
            $totalAdvance = $advancePayments->sum('bill_total');
            $finalBill = $total + $totalAdvance;
            
            $usRate = Rate::first()->us_rate; 
            $usDollarAmount = $finalBill / $usRate;
            
            return view('dashboard.checkout', compact(
                'registration', 
                'otherCharges', 
                'hash', 
                'advancePayments',
                'total',
                'totalAdvance',
                'finalBill',
                'usDollarAmount'
            ));
        } catch (DecryptException $e) {
            return redirect()->route('dashboard');
        }
    }

    public function advancePayment(Request $request, $hash)
    {
        try {
            $id = decrypt($hash);
            $registration = Registration::findOrFail($id);
            
            $validated = $request->validate([
                'advance_date' => 'required|date',
                'payment_mode' => 'required|string',
                'paid_details' => 'required|string',
                'paid_amount' => 'required|numeric|min:0'
            ]);

            $itemName = "Paid - " . $validated['payment_mode'];

            BillingItem::create([
                'item_code' => 'ADV',
                'item_name' => $itemName,
                'price' => $validated['paid_amount'],
                'allocated_room_no' => $registration->allocated_room_no,
                'bill_date' => $validated['advance_date'],
                'bill_total' => -$validated['paid_amount'],
                'bill_no' => uniqid('ADV'),
                'guest_name' => $registration->guest_name,
                'reservation_date' => $registration->reservation_date,
                'item_cat' => 'AP',
                'reservation_code' => $registration->reservation_code,
                'key_room' => $registration->key_room,
                'qty' => 1
            ]);

            return redirect()->route('checkout.show', $hash)
                ->with('toastr', [
                    'type' => 'success',
                    'message' => 'Advance payment added successfully!'
                ]);
                        
            } catch (DecryptException $e) {
                return redirect()->route('checkout.show', $hash)
                    ->with('toastr', [
                        'type' => 'error',
                        'message' => 'Invalid request: ' . $e->getMessage()
                    ]);
            }
    }

    public function printSummary($hash)
    {
        try {
            $id = decrypt($hash);
            $registration = Registration::findOrFail($id);
            
            $otherCharges = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->whereIn('item_cat', ['R', 'O'])
                ->get();

            $advancePayments = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->where('item_cat', 'AP')
                ->get();

            $total = $registration->rs + $otherCharges->sum('bill_total');
            $totalAdvance = $advancePayments->sum('bill_total');
            $finalBill = $total + $totalAdvance;

            return view('print.bill-summary', compact(
                'registration',
                'otherCharges',
                'advancePayments',
                'total',
                'totalAdvance',
                'finalBill'
            ));
        } catch (DecryptException $e) {
            return redirect()->route('checkout.show');
        }
    }

    public function printDetails($hash)
    {
        try {
            $id = decrypt($hash);
            $registration = Registration::findOrFail($id);
            
            $billingItems = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->whereIn('item_cat', ['R', 'O'])
                ->get();

            $advancePayments = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->where('item_cat', 'AP')
                ->get();

            $total = $registration->rs + $billingItems->sum('bill_total');
            $totalAdvance = $advancePayments->sum('bill_total');
            $finalBill = $total + $totalAdvance;

            return view('print.bill-details', compact(
                'registration',
                'billingItems',
                'advancePayments',
                'total',
                'totalAdvance',
                'finalBill'
            ));
        } catch (DecryptException $e) {
            return redirect()->route('checkout.show');
        }
    }

    public function sendBillEmail($hash)
    {
        try {
            $id = decrypt($hash);
            $registration = Registration::findOrFail($id);
            
            $otherCharges = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->whereIn('item_cat', ['R', 'O'])
                ->get();

            $advancePayments = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->where('item_cat', 'AP')
                ->get();

            $total = $registration->rs + $otherCharges->sum('bill_total');
            $finalBill = $total + $advancePayments->sum('bill_total');

            Mail::to($registration->email)->send(new BillDetailsMail(
                $registration,
                $otherCharges,
                $advancePayments,
                $finalBill
            ));

            return response()->json([
                'type' => 'success',
                'message' => 'Bill details sent successfully!'
            ]);

        } catch (DecryptException $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Invalid request: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'message' => 'Failed to send email: ' . $e->getMessage()
            ]);
        }
    }

    public function process(Request $request, $hash)
    {
        try {
            DB::beginTransaction();
            
            $id = decrypt($hash);
            $registration = Registration::findOrFail($id);

            // Move all registrations with same reservation code to history
            $relatedRegistrations = Registration::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->get();

            foreach($relatedRegistrations as $reg) {
                DB::table('registration_history')->insert([
                    'guest_type' => $reg->guest_type,
                    'guest_name' => $reg->guest_name,
                    'guest_country' => $reg->guest_country,
                    'contact_no' => $reg->contact_no,
                    'email' => $reg->email,
                    'id_pass' => $reg->id_pass,
                    'expire_date' => $reg->expire_date,
                    'address' => $reg->address,
                    'guest_from_cat' => $reg->guest_from_cat,
                    'room_type' => $reg->room_type,
                    'meal_plan' => $reg->meal_plan,
                    'no_of_pax' => $reg->no_of_pax,
                    'total_pax_count' => $reg->total_pax_count,
                    'rooms_need' => $reg->rooms_need,
                    'us' => $reg->us,
                    'rs' => $reg->rs,
                    'currency' => $reg->currency,
                    'description' => $reg->description,
                    'adults' => $reg->adults,
                    'children' => $reg->children,
                    'infants' => $reg->infants,
                    'reservation_date' => $reg->reservation_date->format('Y-m-d'),
                    'reservation_time' => $reg->reservation_time->format('H:i'),
                    'departure_date' => $reg->departure_date->format('Y-m-d'), 
                    'departure_time' => $reg->departure_time->format('H:i'),
                    'no_of_day' => $reg->no_of_day,
                    'reservation_code' => $reg->reservation_code,
                    'profession' => $reg->profession,
                    'allocated_room_no' => $reg->allocated_room_no,
                    'key_room' => $reg->key_room,
                    'status' => $reg->status,
                    'image' => $reg->image,
                    'cash_pay' => $request->cash_pay,
                    'tour_pay' => $request->tour_pay, 
                    'card_pay' => $request->card_pay,
                    'card_no' => $request->card_no ? substr($request->card_no, 0, 16) : null,
                    'bank' => $request->bank,
                    'card_type' => $request->card_type,
                ]);

                // Update room status for each registration
                $reg->room()->update(['status' => 'Available']);
            }
            
            // Move all billing items to history
            $billingItems = BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->get();
                
            foreach($billingItems as $item) {
                $billingData = $item->toArray();
                unset($billingData['created_at'], $billingData['updated_at']);
                
                $billingData['bill_date'] = date('Y-m-d', strtotime($billingData['bill_date']));
                $billingData['reservation_date'] = date('Y-m-d', strtotime($billingData['reservation_date']));
                
                DB::table('billing_history')->insert($billingData);
            }

            // Delete original records
            BillingItem::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->delete();
                
            Registration::where('reservation_code', $registration->reservation_code)
                ->where('key_room', $registration->key_room)
                ->delete();

            DB::commit();

            return response()->json([
                'type' => 'success',
                'message' => 'Checkout completed successfully!'
            ]);

        } catch (DecryptException $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error', 
                'message' => 'Invalid request: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'type' => 'error',
                'message' => 'Checkout failed: ' . $e->getMessage()
            ]);
        }
    }
}
