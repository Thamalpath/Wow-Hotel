<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Registration;
use App\Models\Reservation;
use App\Models\Category;
use App\Models\Country;
use App\Models\Room;
use App\Models\Rate;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $currentDate = now()->format('Y-m-d');

        $data = [
            'registrations' => Registration::with(['room', 'reservation'])->get(),
            'reservations' => Reservation::whereDate('reservation_date', $currentDate)->get(),
            'availableRooms' => Room::where('status', 'Available')->get(),
            'usRate' => Rate::first()->us_rate ?? 0,
            'guestFromCategories' => Category::where('cat_code', 'GF')->get(),
            'roomTypes' => Category::where('cat_code', 'RT')->get(),
            'noOfPaxCategories' => Category::where('cat_code', 'RC')->get(),
            'mealPlans' => Category::where('cat_code', 'MP')->get(),
            'countries' => Country::select('country_name', 'nationality', 'spoken_language')->get()
        ];

        return view('dashboard.registration', $data);
    }

    public function fetchReservation(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);
        
        return redirect()->route('registration.index')->with([
            'reservation_data' => [
                'id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'reservation_date' => date('Y-m-d', strtotime($reservation->reservation_date)),
                'reservation_time' => date('H:i', strtotime($reservation->reservation_time)),
                'no_of_day' => $reservation->no_of_day,
                'departure_date' => date('Y-m-d', strtotime($reservation->departure_date)),
                'total_pax_count' => $reservation->total_pax_count,
                'guest_type' => $reservation->guest_type,
                'guest_name' => $reservation->guest_name,
                'contact_no' => $reservation->contact_no,
                'email' => $reservation->email,
                'guest_country' => $reservation->guest_country,
                'guest_from_cat' => $reservation->guest_from_cat,
                'room_type' => $reservation->room_type,
                'no_of_pax' => $reservation->no_of_pax,
                'meal_plan' => $reservation->meal_plan,
                'rooms_need' => $reservation->rooms_need,
                'us' => $reservation->us,
                'rs' => $reservation->rs,
                'adults' => $reservation->adults,
                'children' => $reservation->children,
                'infants' => $reservation->infants,
                'description' => $reservation->description
            ]
        ]);
    }

    public function getRegistration($id)
    {
        $registration = Registration::findOrFail($id);
        
        return response()->json([
            'id' => $registration->id,
            'reservation_code' => $registration->reservation_code,
            'allocated_room_no' => $registration->allocated_room_no,
            'reservation_date' => $registration->reservation_date->format('Y-m-d'),
            'reservation_time' => $registration->reservation_time->format('H:i'),
            'no_of_day' => $registration->no_of_day,
            'departure_date' => $registration->departure_date->format('Y-m-d'),
            'departure_time' => $registration->departure_time->format('H:i'),
            'total_pax_count' => $registration->total_pax_count,
            'guest_type' => $registration->guest_type,
            'guest_name' => $registration->guest_name,
            'contact_no' => $registration->contact_no,
            'email' => $registration->email,
            'id_pass' => $registration->id_pass,
            'expire_date' => $registration->expire_date? $registration->expire_date->format('Y-m-d') : null,
            'address' => $registration->address,
            'guest_country' => $registration->guest_country,
            'guest_from_cat' => $registration->guest_from_cat,
            'room_type' => $registration->room_type,
            'no_of_pax' => $registration->no_of_pax,
            'meal_plan' => $registration->meal_plan,
            'profession' => $registration->profession,
            'rooms_need' => $registration->rooms_need,
            'currency' => $registration->currency,
            'us' => $registration->us,
            'rs' => $registration->rs,
            'adults' => $registration->adults,
            'children' => $registration->children,
            'infants' => $registration->infants,
            'description' => $registration->description,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_code' => 'required|string|exists:reservations,reservation_code',
            'guest_type' => 'required|string',
            'guest_name' => 'required|string',
            'guest_country' => 'required|string',
            'contact_no' => 'nullable|string',
            'email' => 'nullable|email',
            'id_pass' => 'nullable|string',
            'expire_date' => 'nullable|date',
            'address' => 'nullable|string',
            'guest_from_cat' => 'required|string',
            'room_type' => 'required|string',
            'meal_plan' => 'required|string',
            'no_of_pax' => 'required|string',
            'total_pax_count' => 'required|integer',
            'rooms_need' => 'required|integer',
            'us' => 'required|numeric',
            'rs' => 'required|numeric',
            'currency' => 'required|string',
            'description' => 'nullable|string',
            'adults' => 'nullable|integer',
            'children' => 'nullable|integer',
            'infants' => 'nullable|integer',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'departure_date' => 'required|date',
            'departure_time' => 'nullable',
            'no_of_day' => 'required|integer',
            'reservation_code' => 'required|string',
            'profession' => 'nullable|string',
            'allocated_room_no' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
    
            for ($i = 0; $i < $validated['rooms_need']; $i++) {
                $registration = new Registration();
                $registration->fill($validated);
                $registration->rooms_need = 1;
    
                // Set status and key_room based on conditions
                if ($validated['allocated_room_no']) {
                    if ($validated['rooms_need'] == 1 || ($validated['rooms_need'] > 1 && $i == 0)) {
                        $registration->status = 'Payee';
                        $registration->key_room = $validated['allocated_room_no'];
                    } else {
                        $registration->status = null;
                        $registration->key_room = null;
                    }
                }
    
                $registration->save();
            }
    
            // Update reservation status
            if ($validated['reservation_code']) {
                Reservation::where('reservation_code', $validated['reservation_code'])
                    ->update(['status' => 'Registered']);
            }
    
            // Update room status
            if ($validated['allocated_room_no']) {
                Room::where('room_no', $validated['allocated_room_no'])
                    ->update(['status' => 'Received']);
            }
    
            DB::commit();
    
            return redirect()->back()->with('toastr', [
                'type' => 'success',
                'message' => 'Registration created successfully'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Registration Error: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'guest_type' => 'required|string',
            'guest_name' => 'required|string',
            'guest_country' => 'required|string',
            'contact_no' => 'nullable|string',
            'email' => 'nullable|email',
            'id_pass' => 'nullable|string',
            'expire_date' => 'nullable|date',
            'address' => 'nullable|string',
            'guest_from_cat' => 'required|string',
            'room_type' => 'required|string',
            'meal_plan' => 'required|string',
            'no_of_pax' => 'required|string',
            'total_pax_count' => 'required|integer',
            'rooms_need' => 'required|integer',
            'us' => 'required|numeric',
            'rs' => 'required|numeric',
            'currency' => 'required|string',
            'description' => 'nullable|string',
            'adults' => 'nullable|integer',
            'children' => 'nullable|integer',
            'infants' => 'nullable|integer',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'departure_date' => 'required|date',
            'departure_time' => 'nullable',
            'no_of_day' => 'required|integer',
            'reservation_code' => 'required|string',
            'profession' => 'nullable|string',
            'allocated_room_no' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Check if multiple registrations exist with same guest_name and reservation_code
            $registrationCount = Registration::where('guest_name', $validated['guest_name'])
                ->where('reservation_code', $validated['reservation_code'])
                ->count();

            if ($registrationCount > 1) {
                // Update all registrations with same guest_name and reservation_code
                Registration::where('guest_name', $validated['guest_name'])
                    ->where('reservation_code', $validated['reservation_code'])
                    ->update([
                        'guest_type' => $validated['guest_type'],
                        'guest_country' => $validated['guest_country'],
                        'contact_no' => $validated['contact_no'],
                        'email' => $validated['email'],
                        'id_pass' => $validated['id_pass'],
                        'expire_date' => $validated['expire_date'],
                        'address' => $validated['address'],
                        'guest_from_cat' => $validated['guest_from_cat'],
                        'room_type' => $validated['room_type'],
                        'meal_plan' => $validated['meal_plan'],
                        'no_of_pax' => $validated['no_of_pax'],
                        'total_pax_count' => $validated['total_pax_count'],
                        'rooms_need' => $validated['rooms_need'],
                        'us' => $validated['us'],
                        'rs' => $validated['rs'],
                        'currency' => $validated['currency'],
                        'description' => $validated['description'],
                        'adults' => $validated['adults'],
                        'children' => $validated['children'],
                        'infants' => $validated['infants'],
                        'reservation_date' => $validated['reservation_date'],
                        'reservation_time' => $validated['reservation_time'],
                        'departure_date' => $validated['departure_date'],
                        'departure_time' => $validated['departure_time'],
                        'no_of_day' => $validated['no_of_day'],
                        'profession' => $validated['profession']
                    ]);
            } else {
                // Update single registration
                $registration->update($validated);
            }

            // Handle room allocation
            if ($validated['allocated_room_no']) {
                // Get previous room number to update its status
                $previousRoomNo = $registration->allocated_room_no;

                // Get all registrations with same reservation_code
                $registrations = Registration::where('reservation_code', $validated['reservation_code'])
                    ->orderBy('id')
                    ->get();

                $currentIndex = $registrations->search(function($item) use($registration) {
                    return $item->id === $registration->id;
                });

                if ($currentIndex !== false) {
                    if ($currentIndex === 0) {
                        // First registration
                        $keyRoom = $validated['allocated_room_no'];
                        $status = 'Payee';
                    } else {
                        // Subsequent registrations
                        $keyRoom = $registrations[0]->allocated_room_no;
                        $status = null;
                    }

                    $registration->update([
                        'allocated_room_no' => $validated['allocated_room_no'],
                        'key_room' => $keyRoom,
                        'status' => $status
                    ]);

                    // Update previous room status to Available if exists
                    if ($previousRoomNo) {
                        Room::where('room_no', $previousRoomNo)
                            ->update(['status' => 'Available']);
                    }

                    // Update new room status
                    Room::where('room_no', $validated['allocated_room_no'])
                        ->update(['status' => 'Received']);
                }
            }

            DB::commit();

            return redirect()->route('registration.index')
                ->with('toastr', [
                    'type' => 'success',
                    'message' => 'Registration updated successfully'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('toastr', [
                    'type' => 'error',
                    'message' => 'Update Error: ' . $e->getMessage()
                ])
                ->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $registration = Registration::findOrFail($id);
            $reservationCode = $request->reservation_code;
            $keyRoom = $request->key_room;

            // Get all registrations with same reservation_code and key_room
            $registrationsToDelete = Registration::where('reservation_code', $reservationCode)
                ->where('key_room', $keyRoom)
                ->get();

            // Update room status for all allocated rooms
            $roomNumbers = $registrationsToDelete->pluck('allocated_room_no')->unique()->filter();
            if ($roomNumbers->count() > 0) {
                Room::whereIn('room_no', $roomNumbers)->update(['status' => 'Available']);
            }

            // Update reservation status back to 'Reservation'
            Reservation::where('reservation_code', $reservationCode)
                ->update(['status' => 'Reservation']);

            // Delete all related registrations
            Registration::where('reservation_code', $reservationCode)
                ->where('key_room', $keyRoom)
                ->delete();

            DB::commit();

            return redirect()->route('registration.index')->with('toastr', [
                'type' => 'success',
                'message' => 'Registration deleted successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Delete Error: ' . $e->getMessage()
            ]);
        }
    }

    public function uploadImage(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'registration_id' => 'required|exists:registration,id',
                'reservation_code' => 'required',
                'guest_name' => 'required'
            ]);

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->guest_name) . '.' . $image->extension();
            $image->storeAs('public/guests', $imageName);

            // Find all registrations with same guest name and reservation code
            $registrations = Registration::where('guest_name', $request->guest_name)
                ->where('reservation_code', $request->reservation_code)
                ->get();

            if ($registrations->count() > 1) {
                // Update first registration only
                $registrations->first()->update(['image' => $imageName]);
            } else {
                // Update single registration
                Registration::findOrFail($request->registration_id)
                    ->update(['image' => $imageName]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Image upload failed: ' . $e->getMessage()
            ]);
        }
    }

    public function printRegistration(Request $request)
    {
        $registration = Registration::with('room')->findOrFail($request->registration_id);
        
        $rooms = Registration::where('reservation_code', $registration->reservation_code)
                            ->where('key_room', $registration->key_room)
                            ->pluck('allocated_room_no')
                            ->filter()
                            ->unique()
                            ->values();

        return view('print.print-registration', [
            'registration' => $registration,
            'rooms' => $rooms
        ]);
    }
}