<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Country;
use App\Models\Rate;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $currentDate = now()->format('Y-m-d');
        
        // Retrieve Rate data
        $rate = Rate::latest('id')->first();

        // Retrieve available room data
        $availableRooms = Room::where('status', 'Available')->get();
        $availableRoomsCount = $availableRooms->count();

        // Add new reservation logic
        $todayReservations = Reservation::whereDate('reservation_date', $currentDate)
            ->orderBy('reservation_time')
            ->get();
        $reservationCount = $todayReservations->count();

        $receivedRoomsCount = Room::where('status', 'Received')->count();
        
        $totalPaxCount = Registration::sum('no_of_pax');
        
        $pendingDepartures = Registration::whereDate('departure_date', date('Y-m-d'))->count();
        
        $currentRegistrations = Registration::where('status', 'Payee')
            ->orderByRaw('CASE WHEN departure_date = ? THEN 0 ELSE 1 END', [$currentDate])
            ->orderBy('departure_date')
            ->get()
            ->map(function ($registration) use ($currentDate) {
                $registration->isDepartingToday = $registration->departure_date->isToday();
                return $registration;
            });

        $pendingRegistrations = Registration::whereNull('status')
            ->orWhere('status', '')
            ->get();

        // Fetch checkouts from registration_history table
        $checkouts = DB::table('registration_history')
            ->whereDate('departure_date', $currentDate)
            ->orderBy('departure_time')
            ->get();
        $checkoutCount = $checkouts->count();

        // Get guests for dropdowns
        $guests = Reservation::select('guest_name as full_name')
            ->distinct()
            ->get();

        $regGuests = Registration::select('guest_type', 'guest_name as full_name')
            ->distinct()
            ->get();

        $regHisGuests = DB::table('registration_history')
            ->select('guest_type', 'guest_name as full_name')
            ->distinct()
            ->get();

        // Get meal plans
        $mealPlans = Category::where('cat_code', 'MP')
            ->select('cat_name')
            ->get();

        // Get guest from categories
        $guestFroms = Category::where('cat_code', 'GF')
            ->select('cat_name')
            ->get();

        // Get countries
        $countries = Country::select('country_name')
            ->get();

        $expenseCategories = Category::where('cat_code', 'EX')
            ->select('id', 'cat_name')
            ->get();

        $mealCounts = $this->getMealCounts();

        return view('dashboard.dashboard', compact(
            'rate',
            'availableRooms',
            'availableRoomsCount', 
            'todayReservations',
            'reservationCount',
            'receivedRoomsCount',
            'totalPaxCount',
            'pendingDepartures',
            'currentRegistrations',
            'pendingRegistrations',
            'checkouts',
            'checkoutCount',
            'guests',
            'regGuests', 
            'regHisGuests',
            'mealPlans',
            'guestFroms',
            'countries',
            'expenseCategories',
            'mealCounts'
        ));
    }

    public function getReservationReport(Request $request)
    {
        $query = Reservation::query();

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('reservation_date', [$request->from_date, $request->to_date]);
        }

        if ($request->guest) {
            $query->where('guest_name', $request->guest);
        }

        if ($request->meal_plan) {
            $query->where('meal_plan', $request->meal_plan);
        }

        if ($request->guest_from_cat) {
            $query->where('guest_from_cat', $request->guest_from_cat);
        }

        if ($request->country) {
            $query->where('guest_country', $request->country);
        }

        $reservations = $query->get();

        return response()->json([
            'success' => true,
            'reservations' => $reservations
        ]);
    }

    public function getRegistrationReport(Request $request)
    {
        $query = Registration::query();

        if ($request->re_guest) {
            $query->where('guest_name', $request->re_guest);
        }

        if ($request->re_meal_plan) {
            $query->where('meal_plan', $request->re_meal_plan);
        }

        if ($request->re_guest_from_cat) { 
            $query->where('guest_from_cat', $request->re_guest_from_cat); 
        }

        if ($request->re_country) {
            $query->where('guest_country', $request->re_country);
        }

        $registrations = $query->get();

        return response()->json([
            'success' => true,
            'registrations' => $registrations
        ]);
    }

    public function getRegistrationHistoryReport(Request $request)
    {
        $query = DB::table('registration_history');

        if ($request->reg_from_date && $request->reg_to_date) {
            $query->whereBetween('reservation_date', [$request->reg_from_date, $request->reg_to_date]);
        }

        if ($request->reg_guest) {
            $query->where('guest_name', $request->reg_guest);
        }

        if ($request->reg_meal_plan) {
            $query->where('meal_plan', $request->reg_meal_plan);
        }

        if ($request->reg_guest_from_cat) {
            $query->where('guest_from_cat', $request->reg_guest_from_cat);
        }

        if ($request->reg_country) {
            $query->where('guest_country', $request->reg_country);
        }

        $registration_history = $query->get();

        return response()->json([
            'success' => true,
            'registration_history' => $registration_history
        ]);
    }

    public function getSummaryReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:meal_plan,guest_country,guest_from_cat',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date'
        ]);

        $query = DB::table('registration_history')
            ->whereBetween('reservation_date', [$request->from_date, $request->to_date]);

        $summary = match($request->report_type) {
            'meal_plan' => $query->select('meal_plan as name', DB::raw('count(*) as count'))
                ->whereNotNull('meal_plan')
                ->groupBy('meal_plan'),
                
            'guest_country' => $query->select('guest_country as name', DB::raw('count(*) as count'))
                ->whereNotNull('guest_country')
                ->groupBy('guest_country'),
                
            'guest_from_cat' => $query->select('guest_from_cat as name', DB::raw('count(*) as count'))
                ->whereNotNull('guest_from_cat')
                ->groupBy('guest_from_cat')
        };

        $results = $summary->get();
        $totalCount = $results->sum('count');

        return response()->json([
            'success' => true,
            'summary' => $results,
            'totalCount' => $totalCount,
            'reportType' => $request->report_type
        ]);
    }

    public function getDayEndReport(Request $request)
    {
        try {
            $currentDate = $request->date ?? now()->format('Y-m-d');

            // Fetch income transactions
            $incomes = Transaction::whereDate('date', $currentDate)
                ->where('status', 'Income')
                ->select('bill_no', 'ex_cat', 'amount', 'handle_by', 'description', 'status', 'date')
                ->get();

            // Fetch expense transactions
            $expenses = Transaction::whereDate('date', $currentDate)
                ->where('status', 'Expenses') 
                ->select('bill_no', 'ex_cat', 'amount', 'handle_by', 'description', 'status', 'date')
                ->get();

            return response()->json([
                'success' => true,
                'incomes' => $incomes,
                'expenses' => $expenses,
                'date' => $currentDate
            ]);
        } catch (\Exception $e) {
            // \Log::error('Day End Report Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getTransactionReport(Request $request)
    {
        $request->validate([
            'trans_from_date' => 'required|date',
            'trans_to_date' => 'required|date|after_or_equal:trans_from_date',
            'expenses' => 'nullable|string'
        ]);

        $query = Transaction::whereBetween('date', [
            $request->trans_from_date,
            $request->trans_to_date
        ]);

        if ($request->expenses) {
            $expenseData = $query->where('status', 'Expenses')
                ->where('ex_cat', $request->expenses)
                ->get();

            if ($expenseData->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data for selected expenses'
                ]);
            }

            $expenses = $expenseData;
            $incomes = Transaction::whereBetween('date', [
                $request->trans_from_date,
                $request->trans_to_date
            ])->where('status', 'Income')->get();
        } else {
            $incomes = $query->where('status', 'Income')->get();
            $expenses = Transaction::whereBetween('date', [
                $request->trans_from_date,
                $request->trans_to_date
            ])->where('status', 'Expenses')->get();
        }

        return response()->json([
            'success' => true,
            'incomes' => $incomes,
            'expenses' => $expenses
        ]);
    }
    
    private function getMealCounts()
    {
        $currentDate = now()->format('Y-m-d');
        $tomorrowDate = now()->addDay()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');
        $checkInTime = '14:00:00';
        $checkOutTime = '12:00:00';

        // Get Reserved Meals
        $reservedMeals = Reservation::where('reservation_date', $currentDate)
            ->where('status', 'Reservation')
            ->where('reservation_time', '>=', $checkInTime)
            ->selectRaw('
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB", "BB") THEN total_pax_count 
                    ELSE 0 
                END) as breakfast_count,
                SUM(CASE 
                    WHEN meal_plan = "FB" THEN total_pax_count 
                    ELSE 0 
                END) as lunch_count,
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB") THEN total_pax_count 
                    ELSE 0 
                END) as dinner_count
            ')
            ->first();

        // Get Reserved Meals for Tomorrow
        $reservedTomorrowMeals = Reservation::where('reservation_date', $tomorrowDate)
            ->where('status', 'Reservation')
            ->where('reservation_time', '>=', $checkInTime)
            ->selectRaw('
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB", "BB") THEN total_pax_count 
                    ELSE 0 
                END) as breakfast_count,
                SUM(CASE 
                    WHEN meal_plan = "FB" THEN total_pax_count 
                    ELSE 0 
                END) as lunch_count,
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB") THEN total_pax_count 
                    ELSE 0 
                END) as dinner_count
            ')
            ->first();

        // Get Registered Meals with check-in/out time conditions
        $registeredMeals = Registration::where('status', 'Payee')
            ->where(function($query) use ($currentDate, $currentTime, $checkInTime, $checkOutTime) {
                $query->where(function($q) use ($currentDate, $checkInTime) {
                    // For check-ins today
                    $q->whereDate('reservation_date', $currentDate)
                    ->whereTime('reservation_time', '>=', $checkInTime);
                })->orWhere(function($q) use ($currentDate, $checkOutTime) {
                    // For check-outs today
                    $q->whereDate('departure_date', $currentDate)
                    ->whereTime('departure_time', '<=', $checkOutTime);
                })->orWhere(function($q) use ($currentDate) {
                    // For stays spanning current date
                    $q->whereDate('reservation_date', '<', $currentDate)
                    ->whereDate('departure_date', '>', $currentDate);
                });
            })
            ->selectRaw('
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB", "BB") THEN total_pax_count 
                    ELSE 0 
                END) as breakfast_count,
                SUM(CASE 
                    WHEN meal_plan = "FB" THEN total_pax_count 
                    ELSE 0 
                END) as lunch_count,
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB") THEN total_pax_count 
                    ELSE 0 
                END) as dinner_count
            ')
            ->first();

        // Get Registered Meals for Tomorrow with check-in/out time conditions
        $registeredTomorrowMeals = Registration::where('status', 'Payee')
            ->where(function($query) use ($tomorrowDate, $checkInTime, $checkOutTime) {
                $query->where(function($q) use ($tomorrowDate, $checkInTime) {
                    // For check-ins tomorrow
                    $q->whereDate('reservation_date', $tomorrowDate)
                    ->whereTime('reservation_time', '>=', $checkInTime);
                })->orWhere(function($q) use ($tomorrowDate, $checkOutTime) {
                    // For check-outs tomorrow
                    $q->whereDate('departure_date', $tomorrowDate)
                    ->whereTime('departure_time', '<=', $checkOutTime);
                })->orWhere(function($q) use ($tomorrowDate) {
                    // For stays spanning tomorrow
                    $q->whereDate('reservation_date', '<', $tomorrowDate)
                    ->whereDate('departure_date', '>', $tomorrowDate);
                });
            })
            ->selectRaw('
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB", "BB") THEN total_pax_count 
                    ELSE 0 
                END) as breakfast_count,
                SUM(CASE 
                    WHEN meal_plan = "FB" THEN total_pax_count 
                    ELSE 0 
                END) as lunch_count,
                SUM(CASE 
                    WHEN meal_plan IN ("FB", "HB") THEN total_pax_count 
                    ELSE 0 
                END) as dinner_count
            ')
            ->first();

        return [
            'today' => [
                'reserved' => $reservedMeals,
                'registered' => $registeredMeals
            ],
            'tomorrow' => [
                'reserved' => $reservedTomorrowMeals,
                'registered' => $registeredTomorrowMeals
            ]
        ];
    }

    public function checkout($hash)
    {
        return redirect()->route('checkout.show', ['hash' => $hash]);
    }

    public function printRegistration()
    {
        return view('print.blank-registration', [
            'logo' => asset('assets/images/logo.png'),
            'telephone' => '0777 305 613 / 057 222 0375'
        ]);
    }

    public function checkAvailableRooms(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Get all rooms that are not booked for the selected date range
        $availableRooms = Room::whereDoesntHave('registration', function($query) use ($startDate, $endDate) {
            $query->where(function($q) use ($startDate, $endDate) {
                // Check if any existing booking overlaps with selected date range
                $q->where(function($inner) use ($startDate, $endDate) {
                    $inner->whereDate('reservation_date', '<=', $endDate)
                        ->whereDate('departure_date', '>=', $startDate);
                });
            });
        })
        ->where('status', 'Available')
        ->get();

        return response()->json([
            'success' => true,
            'availableRooms' => $availableRooms
        ]);
    }
}