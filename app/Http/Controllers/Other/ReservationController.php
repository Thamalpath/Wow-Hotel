<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Reservation;
use App\Models\Category;
use App\Models\Country;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::whereDate('reservation_date', now()->toDateString())
            ->orderBy('id', 'desc')
            ->paginate(10);
        $countries = Country::select('country_name', 'nationality', 'spoken_language')->get();
        $guestFromCategories = Category::where('cat_code', 'GF')->get();
        $roomTypes = Category::where('cat_code', 'RT')->get();
        $noOfPaxCategories = Category::where('cat_code', 'RC')->get();
        $mealPlans = Category::where('cat_code', 'MP')->get();

        return view('dashboard.reservation', compact(
            'reservations',
            'countries',
            'guestFromCategories',
            'roomTypes',
            'noOfPaxCategories',
            'mealPlans'
        ));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_type' => 'required|string|max:50',
            'guest_name' => 'required|string|max:100',
            'guest_country' => 'required|string|max:100',
            'contact_no' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:100',
            'agent_code' => 'nullable|string|max:50',
            'guest_from_cat' => 'required|string|max:50',
            'room_type' => 'required|string|max:50',
            'meal_plan' => 'required|string|max:50',
            'no_of_pax' => 'required|string',
            'total_pax_count' => 'required|string',
            'rooms_need' => 'required|string',
            'us' => 'required|numeric',
            'rs' => 'required|numeric',
            'description' => 'nullable|string',
            'adults' => 'required|string',
            'children' => 'nullable|string',
            'infants' => 'nullable|string',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'departure_date' => 'required|date|after:reservation_date',
            'no_of_day' => 'required|string'
        ]);

        $now = now();
        $timeStr = $now->format('Hi');
        $dateStr = $now->format('ymd');
        $nameStr = Str::upper(Str::substr($validated['guest_name'], 0, 3));
        $validated['reservation_code'] = $timeStr . $dateStr . $nameStr;
        
        try {
            Reservation::create($validated);

            return redirect()->back()->with('toastr', [
                'type' => 'success',
                'message' => 'Reservation created successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Error creating reservation: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'guest_type' => 'required|string|max:50',
            'guest_name' => 'required|string|max:100',
            'guest_country' => 'required|string|max:100',
            'contact_no' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:100',
            'agent_code' => 'nullable|string|max:50',
            'guest_from_cat' => 'required|string|max:50',
            'room_type' => 'required|string|max:50',
            'meal_plan' => 'required|string|max:50',
            'no_of_pax' => 'required|string',
            'total_pax_count' => 'required|string',
            'rooms_need' => 'required|string',
            'us' => 'required|numeric',
            'rs' => 'required|numeric',
            'description' => 'nullable|string',
            'adults' => 'required|string',
            'children' => 'nullable|string',
            'infants' => 'nullable|string',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'departure_date' => 'required|date|after:reservation_date',
            'no_of_day' => 'required|string'
        ]);

        try {
            $reservation->update($validated);
            return redirect()->back()->with('toastr', [
                'type' => 'success',
                'message' => 'Reservation updated successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('toastr', [
                'type' => 'error',
                'message' => 'Error updating reservation: ' . $e->getMessage()
            ])->withInput();
        }
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        
        return redirect()->route('reservations.index')->with('toastr', [
            'type' => 'success',
            'message' => 'Reservation deleted successfully!'
        ]);
    }
}
