@extends('layouts.app')

@section('content')
    <!--start main wrapper-->
    <main class="main-wrapper min-vh-100">
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4 text-center">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row row-cols-auto">
                                                <div class="col">
                                                    <a href="{{ route('reservations.index') }}" type="button"
                                                        class="btn btn-grd btn-grd-deep-blue px-5 fw-bold"
                                                        style="min-width: 200px;">Reservation</a>
                                                </div>
                                                <div class="col">
                                                    <a href="{{ route('registration.index') }}" type="button"
                                                        class="btn btn-grd btn-grd-deep-blue px-5 fw-bold"
                                                        style="min-width: 200px;">Registration</a>
                                                </div>
                                                <div class="col">
                                                    <a href="{{ route('billing.index') }}" type="button"
                                                        class="btn btn-grd btn-grd-deep-blue px-5 fw-bold"
                                                        style="min-width: 200px;">Billing</a>
                                                </div>
                                                <div class="col">
                                                    <h4 class="mb-0 text-warning fw-bold">Date : <span
                                                            class="text-white">{{ now()->format('Y-m-d') }}</span> </h4>
                                                </div>
                                                <div class="col">
                                                    <h4 class="mb-0 text-warning fw-bold">USD Rate : <span
                                                            class="text-white">{{ number_format($rate->us_rate, 2) }}</span>
                                                    </h4>
                                                </div>
                                            </div>

                                            <div class="row row-cols-auto mt-4">
                                                <div class="col">
                                                    <a href="{{ route('transactions.index') }}" type="button"
                                                        class="btn btn-grd btn-grd-deep-blue px-4 fw-bold"
                                                        style="min-width: 200px;">Day Transaction</a>
                                                </div>
                                                <div class="col">
                                                    <a href="{{ route('dashboard.print-registration') }}" target="_blank"
                                                        class="btn btn-grd btn-grd-deep-blue px-4 fw-bold"
                                                        style="min-width: 200px;">
                                                        Print Registration
                                                    </a>

                                                </div>
                                            </div>

                                            <div class="row row-cols-md g-5 mt-2">
                                                <div class="col-md-3">
                                                    <h5 class="modal-title text-warning fw-bold text-start mb-3">Checkout
                                                        Count: <span class="text-white">{{ $checkoutCount }}</span></h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Guest Name</th>
                                                                    <th>Room No</th>
                                                                    <th>Arrival</th>
                                                                    <th>Departure</th>
                                                                    <th>Contact</th>
                                                                    <th>Status</th>
                                                                    <th>Country</th>
                                                                    <th>Room Type</th>
                                                                    <th>Meal Type</th>
                                                                    <th>Room Count</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($checkouts as $index => $checkout)
                                                                    <tr>
                                                                        <td style="color: #FF0000;">{{ $index + 1 }}</td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ $checkout->guest_type }}
                                                                            {{ $checkout->guest_name }}</td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ $checkout->allocated_room_no }}</td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ date('Y-m-d', strtotime($checkout->reservation_date)) }}
                                                                            <br>
                                                                            {{ date('H:i', strtotime($checkout->reservation_time)) }}
                                                                        </td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ date('Y-m-d', strtotime($checkout->departure_date)) }}
                                                                            <br>
                                                                            {{ date('H:i', strtotime($checkout->departure_time)) }}
                                                                        </td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ $checkout->contact_no }}</td>
                                                                        <td style="color: #FF0000;">{{ $checkout->status }}
                                                                        </td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ $checkout->guest_country }}</td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ $checkout->room_type }}</td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ $checkout->meal_plan }}</td>
                                                                        <td style="color: #FF0000;">
                                                                            {{ $checkout->rooms_need }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="11">No
                                                                            checkouts found for today.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <h5 class="modal-title text-warning fw-bold text-start mb-3">Rooms
                                                        Available : <span
                                                            class="text-white">{{ $availableRoomsCount }}</span></h5>
                                                    <div class="table-responsive"
                                                        style="max-height: 200px; overflow-y: auto;">
                                                        <table class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Room</th>
                                                                    <th>Room Type</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($availableRooms as $index => $room)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $room->room_no }}</td>
                                                                        <td>{{ $room->room_type }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <h5 class="modal-title text-warning fw-bold text-start mt-4 mb-3">
                                                        Reservations : <span
                                                            class="text-white">{{ $reservationCount }}</span>
                                                    </h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Reserved In</th>
                                                                    <th>Name</th>
                                                                    <th>Time</th>
                                                                    <th>Reserved Out</th>
                                                                    <th>Contact</th>
                                                                    <th>Country</th>
                                                                    <th>Room Type</th>
                                                                    <th>Meal Type</th>
                                                                    <th>Special Note</th>
                                                                    <th>Room Count</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($todayReservations as $index => $reservation)
                                                                    <tr>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $index + 1 }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ date('Y-m-d', strtotime($reservation->reservation_date)) }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $reservation->guest_type }}
                                                                            {{ $reservation->guest_name }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ date('H:i', strtotime($reservation->reservation_time)) }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ date('Y-m-d', strtotime($reservation->departure_date)) }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $reservation->contact_no }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $reservation->guest_country }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $reservation->room_type }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $reservation->meal_plan }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $reservation->description }}
                                                                        </td>
                                                                        <td class="fw-bold"
                                                                            style="color: {{ $reservation->status === 'Reservation' ? '#03AED2' : ($reservation->status === 'Registered' ? '#6EC207' : '') }}">
                                                                            {{ $reservation->rooms_need }}
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="11">No reservations found for today.
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <h5 class="modal-title text-warning fw-bold text-start mb-3">
                                                        In House: <span class="text-white">{{ $receivedRoomsCount }}</span>
                                                        <span class="ms-4">Total Pax: <span
                                                                class="text-white">{{ $totalPaxCount }}</span></span>
                                                    </h5>

                                                    <h5 class="modal-title text-warning fw-bold text-start mb-3">
                                                        Pending Departure: <span
                                                            class="text-white">{{ $pendingDepartures }}</span>
                                                    </h5>

                                                    <div class="table-responsive"
                                                        style="max-height: 300px; overflow-y: auto;">
                                                        <table id="table1" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Room</th>
                                                                    <th>Name</th>
                                                                    <th>Key Room</th>
                                                                    <th>Arrival</th>
                                                                    <th>Departure</th>
                                                                    <th>Time</th>
                                                                    <th>Contact</th>
                                                                    <th>Status</th>
                                                                    <th>Country</th>
                                                                    <th>Room Type</th>
                                                                    <th>Meal Type</th>
                                                                    <th>Special Note</th>
                                                                    <th>Room Count</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($currentRegistrations as $index => $registration)
                                                                    <tr onclick="window.location.href='{{ route('checkout.show', ['hash' => encrypt($registration->id)]) }}'"
                                                                        class="fw-bold"
                                                                        style="cursor: pointer; {{ $registration->isDepartingToday ? 'color: white; background-color: #800000;' : '' }}">
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $registration->allocated_room_no }}</td>
                                                                        <td>{{ $registration->guest_type }}
                                                                            {{ $registration->guest_name }}</td>
                                                                        <td>{{ $registration->key_room }}</td>
                                                                        <td>{{ $registration->reservation_date->format('Y-m-d') }}
                                                                        </td>
                                                                        <td>{{ $registration->departure_date->format('Y-m-d') }}
                                                                        </td>
                                                                        <td>{{ $registration->departure_time->format('H:i') }}
                                                                        </td>
                                                                        <td>{{ $registration->contact_no }}</td>
                                                                        <td>{{ $registration->status }}</td>
                                                                        <td>{{ $registration->guest_country }}</td>
                                                                        <td>{{ $registration->room_type }}</td>
                                                                        <td>{{ $registration->meal_plan }}</td>
                                                                        <td>{{ $registration->description }}</td>
                                                                        <td>{{ $registration->rooms_need }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="14">No registrations found.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="table-responsive mt-4"
                                                        style="max-height: 300px; overflow-y: auto;">
                                                        <table id="table2" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Room</th>
                                                                    <th>Name</th>
                                                                    <th>Key Room</th>
                                                                    <th>Arrival</th>
                                                                    <th>Departure</th>
                                                                    <th>Time</th>
                                                                    <th>Contact</th>
                                                                    <th>Status</th>
                                                                    <th>Country</th>
                                                                    <th>Room Type</th>
                                                                    <th>Meal Type</th>
                                                                    <th>Special Note</th>
                                                                    <th>Room Count</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($pendingRegistrations as $index => $registration)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $registration->allocated_room_no }}</td>
                                                                        <td>{{ $registration->guest_type }}
                                                                            {{ $registration->guest_name }}</td>
                                                                        <td>{{ $registration->key_room }}</td>
                                                                        <td>{{ $registration->reservation_date->format('Y-m-d') }}
                                                                        </td>
                                                                        <td>{{ $registration->departure_date->format('Y-m-d') }}
                                                                        </td>
                                                                        <td>{{ $registration->departure_time->format('H:i') }}
                                                                        </td>
                                                                        <td>{{ $registration->contact_no }}</td>
                                                                        <td>{{ $registration->status }}</td>
                                                                        <td>{{ $registration->guest_country }}</td>
                                                                        <td>{{ $registration->room_type }}</td>
                                                                        <td>{{ $registration->meal_plan }}</td>
                                                                        <td>{{ $registration->description }}</td>
                                                                        <td>{{ $registration->rooms_need }}</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="14">No registrations found.</td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4 text-center">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row row-cols-md g-5">
                                                <div class="col-md-6">
                                                    <div class="mb-3 d-flex justify-content-center align-items-center">
                                                        <div id="calendar-inline"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <div id="calendar-inline"></div>
                                                    </div>
                                                    <h5 class="text-warning fw-bold mb-3" id="selectedDateRange"></h5>
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered"
                                                            id="availableRoomsTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Room</th>
                                                                    <th>Room Type</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- Will be populated dynamically -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4 text-center">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row row-cols-md g-5">
                                                <div class="col-md-6">
                                                    <div class="table-responsive">
                                                        <h6 class="text-start">Today</h6>
                                                        <table id="today" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Guest Mode</th>
                                                                    <th>Breakfast</th>
                                                                    <th>Lunch</th>
                                                                    <th>Dinner</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Registered</td>
                                                                    <td>{{ $mealCounts['today']['registered']->breakfast_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['today']['registered']->lunch_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['today']['registered']->dinner_count ?? 0 }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reservation</td>
                                                                    <td>{{ $mealCounts['today']['reserved']->breakfast_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['today']['reserved']->lunch_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['today']['reserved']->dinner_count ?? 0 }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="table-responsive">
                                                        <h6 class="text-start">Tomorrow</h6>
                                                        <table id="tomorrow" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Guest Mode</th>
                                                                    <th>Breakfast</th>
                                                                    <th>Lunch</th>
                                                                    <th>Dinner</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Registered</td>
                                                                    <td>{{ $mealCounts['tomorrow']['registered']->breakfast_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['tomorrow']['registered']->lunch_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['tomorrow']['registered']->dinner_count ?? 0 }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reservation</td>
                                                                    <td>{{ $mealCounts['tomorrow']['reserved']->breakfast_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['tomorrow']['reserved']->lunch_count ?? 0 }}
                                                                    </td>
                                                                    <td>{{ $mealCounts['tomorrow']['reserved']->dinner_count ?? 0 }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Area -->
                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4 text-center">
                        <div class="card-body position-relative">
                            <div class="row">
                                <div class="col-12 col-xl-12 mt-1 mb-1">
                                    <div class="d-flex justify-content-center gap-4 flex-wrap">
                                        <button type="button" id="reservation"
                                            class="btn btn-grd btn-grd-deep-blue px-4 fw-bold" data-bs-toggle="modal"
                                            data-bs-target="#ReservationBasicModal">Reservation Report</button>

                                        <button type="button" id="registration"
                                            class="btn btn-grd btn-grd-deep-blue px-4 fw-bold">Registration Report</button>

                                        <button type="button" id="registrationHistory"
                                            class="btn btn-grd btn-grd-deep-blue px-4 fw-bold">Registration History
                                            Report</button>

                                        <button type="button" id="summary"
                                            class="btn btn-grd btn-grd-deep-blue px-4 fw-bold">Summary Report</button>

                                        <button type="button" id="dayEnd"
                                            class="btn btn-grd btn-grd-deep-blue px-4 fw-bold">Day End Report</button>

                                        <button type="button" id="transaction"
                                            class="btn btn-grd btn-grd-deep-blue px-4 fw-bold">Transactions Report</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Reservation Modal -->
    <div class="col-12 col-xl-6">
        <div class="card-body">
            <div class="modal fade" id="ReservationBasicModal">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 py-2 bg-grd-primary">
                            <h5 class="modal-title fw-bold fs-2">Reservation Report</h5>
                            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                <i class="material-icons-outlined">close</i>
                            </a>
                        </div>
                        <div class="modal-body mt-4 mb-5">
                            <form id="reservationReportForm" method="POST">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="from_date" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date"
                                            value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to_date" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date"
                                            value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="guest" class="form-label">Guest Name</label>
                                        <select class="form-select" name="guest" id="guest">
                                            <option value="">Select Guest</option>
                                            @foreach ($guests as $guest)
                                                <option value="{{ $guest->full_name }}">{{ $guest->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="meal_plan" class="form-label">Meal Plan</label>
                                        <select class="form-select" name="meal_plan" id="meal_plan">
                                            <option value="">Select Meal Plan</option>
                                            @foreach ($mealPlans as $meal)
                                                <option value="{{ $meal->cat_name }}">{{ $meal->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="guest_from" class="form-label">Guest From</label>
                                        <select class="form-select" name="guest_from_cat" id="guest_from_cat">
                                            <option value="">Select Guest From</option>
                                            @foreach ($guestFroms as $from)
                                                <option value="{{ $from->cat_name }}">{{ $from->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="country" class="form-label">Guest Country</label>
                                        <select class="form-select" name="country" id="country">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->country_name }}">
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="button" id="showReport"
                                        class="btn btn-grd btn-grd-info px-5 fw-bold">Show Report</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div class="col-12 col-xl-6">
        <div class="card-body">
            <div class="modal fade" id="RegistrationBasicModal">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 py-2 bg-grd-primary">
                            <h5 class="modal-title fw-bold fs-2">Registration Report</h5>
                            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                <i class="material-icons-outlined">close</i>
                            </a>
                        </div>
                        <div class="modal-body mt-4 mb-5">
                            <form id="registrationReportForm" method="POST">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="re_guest" class="form-label">Guest Name</label>
                                        <select class="form-select" name="re_guest" id="re_guest">
                                            <option value="">Select Guest</option>
                                            @foreach ($regGuests as $guest)
                                                <option value="{{ $guest->full_name }}">{{ $guest->guest_type }}
                                                    {{ $guest->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="re_meal_plan" class="form-label">Meal Plan</label>
                                        <select class="form-select" name="re_meal_plan" id="re_meal_plan">
                                            <option value="">Select Meal Plan</option>
                                            @foreach ($mealPlans as $meal)
                                                <option value="{{ $meal->cat_name }}">{{ $meal->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="re_guest_from_cat" class="form-label">Guest From</label>
                                        <select class="form-select" name="re_guest_from_cat" id="re_guest_from_cat">
                                            <option value="">Select Guest From</option>
                                            @foreach ($guestFroms as $from)
                                                <option value="{{ $from->cat_name }}">{{ $from->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="re_country" class="form-label">Guest Country</label>
                                        <select class="form-select" name="re_country" id="re_country">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->country_name }}">
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="button" id="showRegistrationReport"
                                        class="btn btn-grd btn-grd-info px-5 fw-bold">Show Report</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration History Modal -->
    <div class="col-12 col-xl-6">
        <div class="card-body">
            <div class="modal fade" id="RegistrationHistoryBasicModal">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 py-2 bg-grd-primary">
                            <h5 class="modal-title fw-bold fs-2">Registration History Report</h5>
                            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                <i class="material-icons-outlined">close</i>
                            </a>
                        </div>
                        <div class="modal-body mt-4 mb-5">
                            <form id="registrationHistoryReportForm" method="POST">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="reg_from_date" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="reg_from_date"
                                            name="reg_from_date" value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="reg_to_date" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="reg_to_date" name="reg_to_date"
                                            value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="reg_guest" class="form-label">Guest Name</label>
                                        <select class="form-select" name="reg_guest" id="reg_guest">
                                            <option value="">Select Guest</option>
                                            @foreach ($regHisGuests as $guest)
                                                <option value="{{ $guest->full_name }}">{{ $guest->guest_type }}
                                                    {{ $guest->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="reg_meal_plan" class="form-label">Meal Plan</label>
                                        <select class="form-select" name="reg_meal_plan" id="reg_meal_plan">
                                            <option value="">Select Meal Plan</option>
                                            @foreach ($mealPlans as $meal)
                                                <option value="{{ $meal->cat_name }}">{{ $meal->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="reg_guest_from_cat" class="form-label">Guest From</label>
                                        <select class="form-select" name="reg_guest_from_cat" id="reg_guest_from_cat">
                                            <option value="">Select Guest From</option>
                                            @foreach ($guestFroms as $from)
                                                <option value="{{ $from->cat_name }}">{{ $from->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="reg_country" class="form-label">Guest Country</label>
                                        <select class="form-select" name="reg_country" id="reg_country">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->country_name }}">
                                                    {{ $country->country_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="button" id="showRegistrationHistoryReport"
                                        class="btn btn-grd btn-grd-info px-5 fw-bold">Show Report</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Modal -->
    <div class="col-12 col-xl-6">
        <div class="card-body">
            <div class="modal fade" id="SummaryBasicModal">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 py-2 bg-grd-primary">
                            <h5 class="modal-title fw-bold fs-2">Summary Report</h5>
                            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                <i class="material-icons-outlined">close</i>
                            </a>
                        </div>
                        <div class="modal-body mt-4 mb-5">
                            <form id="summaryReportForm" method="POST">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="summary_from_date" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="summary_from_date"
                                            name="summary_from_date" value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="summary_to_date" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="summary_to_date"
                                            name="summary_to_date" value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="report_type" class="form-label">Report Type</label>
                                    <select class="form-select" id="report_type" name="report_type" required>
                                        <option value="">Select Report Type</option>
                                        <option value="meal_plan">Meal Type</option>
                                        <option value="guest_country">Country</option>
                                        <option value="guest_from_cat">Job Agents</option>
                                    </select>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="button" id="showSummaryReport"
                                        class="btn btn-grd btn-grd-info px-5 fw-bold">Show Report</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div class="col-12 col-xl-6">
        <div class="card-body">
            <div class="modal fade" id="TransactionBasicModal">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 py-2 bg-grd-primary">
                            <h5 class="modal-title fw-bold fs-2">Transaction Report</h5>
                            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                <i class="material-icons-outlined">close</i>
                            </a>
                        </div>
                        <div class="modal-body mt-4 mb-5">
                            <form id="TransactionReportForm" method="POST">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="from_date" class="form-label">From Date</label>
                                        <input type="date" class="form-control" id="trans_from_date"
                                            name="trans_from_date" value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to_date" class="form-label">To Date</label>
                                        <input type="date" class="form-control" id="trans_to_date"
                                            name="trans_to_date" value="{{ now()->format('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="expenses" class="form-label">Expenses</label>
                                        <select class="form-select" id="expenses" name="expenses">
                                            <option value="">All Expenses</option>
                                            @foreach ($expenseCategories as $expense)
                                                <option value="{{ $expense->cat_name }}">
                                                    {{ $expense->cat_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="button" id="showTransactionReport"
                                        class="btn btn-grd btn-grd-info px-5 fw-bold">Show Report</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secret Password Modal -->
    <div class="modal fade" id="secretModal" tabindex="-1" aria-labelledby="secretModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 py-2 bg-grd-deep-blue">
                    <h5 class="modal-title fw-bold">Enter Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mt-3 mb-3">
                    <input type="password" id="secretPassword" class="form-control" placeholder="Password">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-grd-deep-blue px-4 fw-bold text-white"
                        onclick="checkPassword()">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function updateAvailableRoomsTable(rooms, dateRange) {
            const tableBody = document.querySelector('#availableRoomsTable tbody');
            const dateDisplay = document.querySelector('#selectedDateRange');

            dateDisplay.textContent = `Selected Date(s): ${dateRange}`;

            tableBody.innerHTML = rooms.length ? rooms.map((room, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${room.room_no}</td>
                    <td>${room.room_type}</td>
                </tr>
            `).join('') : '<tr><td colspan="3">No rooms available for selected dates</td></tr>';
        }
    </script>

    <script>
        const HARDCODED_PASSWORD = "{{ config('app.report_password', 'buddy123') }}";
        let pendingAction = null;

        document.addEventListener('DOMContentLoaded', function() {
            const modalTriggers = {
                'registration': '#RegistrationBasicModal',
                'registrationHistory': '#RegistrationHistoryBasicModal',
                'summary': '#SummaryBasicModal',
                'transaction': '#TransactionBasicModal',
                'dayEnd': 'handleDayEndReport'
            };

            // Add separate event listener for dayEnd button
            document.getElementById('dayEnd').addEventListener('click', function(e) {
                e.preventDefault();
                pendingAction = 'dayEnd';
                $('#secretModal').modal('show');
            });

            // Set up click handlers for all report buttons
            Object.keys(modalTriggers).forEach(action => {
                document.getElementById(action)?.addEventListener('click', function(e) {
                    e.preventDefault();
                    pendingAction = action;
                    $('#secretModal').modal('show');
                });
            });

            window.checkPassword = function() {
                const enteredPassword = document.getElementById('secretPassword').value;

                if (enteredPassword === HARDCODED_PASSWORD) {
                    $('#secretModal').modal('hide');
                    document.getElementById('secretPassword').value = '';

                    if (pendingAction === 'dayEnd') {
                        handleDayEndReport();
                    } else {
                        const targetModal = modalTriggers[pendingAction];
                        if (targetModal) {
                            $(targetModal).modal('show');
                        }
                    }
                    pendingAction = null;
                } else {
                    toastr.error('Invalid password');
                    document.getElementById('secretPassword').value = '';
                }
            };

            function handleDayEndReport() {
                const currentDate = new Date().toISOString().split('T')[0];

                const loadingToast = toastr.info('Generating day-end report...', '', {
                    timeOut: 0,
                    extendedTimeOut: 0
                });

                fetch('{{ route('dashboard.day-end-report') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            date: currentDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        toastr.clear(loadingToast);

                        if (data.success) {
                            generateDayEndPrintWindow(data, currentDate);
                        } else {
                            toastr.warning('No transactions found for today');
                        }
                    })
                    .catch(error => {
                        toastr.clear(loadingToast);
                        console.error('Error:', error);
                        toastr.error('Failed to generate day-end report');
                    });
            }

            function generateDayEndPrintWindow(data, currentDate) {
                let totalIncome = 0;
                let totalExpense = 0;

                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <title>Day End Report - ${currentDate}</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>
                                body { font-family: Arial, sans-serif; }
                                .container { max-width: 100%; margin-top: 20px; }
                                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                                table, th, td { border: 1px solid black; }
                                th, td { padding: 10px; text-align: left; }
                                .total-row { font-weight: bold; }
                                .full-width-line { border-top: 1px solid black; margin: 4px 0; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <h1 class="text-center mb-5">Day End Report - ${currentDate}</h1>
                                
                                <h3 class="mb-3">Income/Expenses Transactions</h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Description</th>
                                            <th>Handle By</th>
                                            <th>Income</th>
                                            <th>Expenses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.incomes.map(income => {
                                            totalIncome += parseFloat(income.amount);
                                            return `
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td>${income.bill_no || '-'}</td>
                                                                                                                                                                                            <td>${income.description || '-'}</td>
                                                                                                                                                                                            <td>${income.handle_by || '-'}</td>
                                                                                                                                                                                            <td class="text-end">${parseFloat(income.amount).toFixed(2)}</td>
                                                                                                                                                                                            <td></td>
                                                                                                                                                                                        </tr>`;
                                        }).join('')}
                                        
                                        ${data.expenses.map(expense => {
                                            totalExpense += parseFloat(expense.amount);
                                            return `
                                                                                                                                                                                        <tr>
                                                                                                                                                                                            <td>${expense.bill_no || '-'}</td>
                                                                                                                                                                                            <td>${expense.description} - ${expense.ex_cat}</td>
                                                                                                                                                                                            <td>${expense.handle_by || '-'}</td>
                                                                                                                                                                                            <td></td>
                                                                                                                                                                                            <td class="text-end">${parseFloat(expense.amount).toFixed(2)}</td>
                                                                                                                                                                                        </tr>`;
                                        }).join('')}
                                        
                                        <tr class="total-row">
                                            <td colspan="3" class="text-end">Total:</td>
                                            <td class="text-end">${totalIncome.toFixed(2)}</td>
                                            <td class="text-end">${totalExpense.toFixed(2)}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 ms-3">Balance</h5>
                                    <h5 class="mb-0 me-5">${(totalIncome - totalExpense).toFixed(2)}</h5>
                                </div>
                                <div class="full-width-line"></div>
                                <div class="full-width-line"></div>
                            </div>
                        </body>
                    </html>`;

                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.print();

                printWindow.onafterprint = function() {
                    printWindow.close();
                    window.close();
                };
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reservation report handler
            document.getElementById('showReport').addEventListener('click', function(e) {
                e.preventDefault();

                const formData = {
                    from_date: document.getElementById('from_date').value,
                    to_date: document.getElementById('to_date').value,
                    guest: document.getElementById('guest').value,
                    meal_plan: document.getElementById('meal_plan').value,
                    guest_from_cat: document.getElementById('guest_from_cat').value,
                    country: document.getElementById('country').value
                };

                // Validation checks
                if (!formData.from_date && !formData.to_date && !formData.guest &&
                    !formData.meal_plan && !formData.guest_from_cat && !formData.country) {
                    toastr.error('Please select at least one filter criteria');
                    return;
                }

                if ((formData.from_date && !formData.to_date) || (!formData.from_date && formData
                        .to_date)) {
                    toastr.error('Please select both From Date and To Date');
                    return;
                }

                if (formData.from_date && formData.to_date && formData.from_date > formData.to_date) {
                    toastr.error('From Date cannot be later than To Date');
                    return;
                }

                // Show loading indicator
                const loadingToast = toastr.info('Fetching reservation data...', '', {
                    timeOut: 0,
                    extendedTimeOut: 0
                });

                fetch('{{ route('dashboard.reservation-report') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Dismiss loading indicator
                        toastr.clear(loadingToast);

                        if (data.reservations && data.reservations.length > 0) {
                            generatePrintWindow(data.reservations, formData);
                        } else {
                            toastr.error('No reservations found for the selected criteria');
                        }
                    })
                    .catch(error => {
                        // Dismiss loading indicator
                        toastr.clear(loadingToast);
                        console.error('Error:', error);
                        toastr.error('Failed to fetch reservation data. Please try again.');
                    });
            });

            function generatePrintWindow(reservations, formData) {
                const filterCriteria = [];
                if (formData.from_date) filterCriteria.push(
                    `Date Range: <span class="fw-normal">${formData.from_date} to ${formData.to_date}</span>`);
                if (formData.guest) filterCriteria.push(`Guest: <span class="fw-normal">${formData.guest}</span>`);
                if (formData.meal_plan) filterCriteria.push(
                    `Meal Plan: <span class="fw-normal">${formData.meal_plan}</span>`);
                if (formData.guest_from_cat) filterCriteria.push(
                    `Guest From: <span class="fw-normal">${formData.guest_from_cat}</span>`);
                if (formData.country) filterCriteria.push(
                    `Country: <span class="fw-normal">${formData.country}</span>`);

                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Reservation Report</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { font-family: Arial, sans-serif; }
                            .container { max-width: 100%; margin-top: 70px; box-sizing: border-box; }
                            table { width: 100%; border-collapse: collapse; }
                            table, th, td { border: 1px solid black; }
                            th, td { padding: 10px; text-align: left; }
                            h4 { margin-top: 20px; }
                            .filter-criteria { margin-bottom: 20px; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h1 class="text-center fw-bold mt-3 mb-5">Reservation Report</h1>
                            <div class="filter-criteria">
                                ${filterCriteria.map(criteria => `<h4 class="fw-bold">${criteria}</h4>`).join('')}
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Guest Name</th>
                                        <th>Contact No</th>
                                        <th>Room Type</th>
                                        <th>Meal Plan</th>
                                        <th>Country</th>
                                        <th>Tour Agent</th>
                                        <th>Reservation Date</th>
                                        <th>Departure Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${reservations.map((reservation, index) => `
                                                                                                                                                                                                                                                                                                                                                                                                                        <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${index + 1}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${reservation.guest_type} ${reservation.guest_name}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${reservation.contact_no ?? ''}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${reservation.room_type}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${reservation.meal_plan}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${reservation.guest_country}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${reservation.guest_from_cat ?? ''}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${new Date(reservation.reservation_date).toLocaleDateString()}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            <td>${new Date(reservation.departure_date).toLocaleDateString()}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                    `).join('')}
                                </tbody>
                            </table>
                            <p class="fw-bold mt-3 mb-5">Total Records: ${reservations.length}</p>
                        </div>
                    </body>
                    </html>`;

                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.print();

                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            }

            // Registration report handler
            document.getElementById('showRegistrationReport').addEventListener('click', function(e) {
                e.preventDefault();

                const formData = {
                    re_guest: document.getElementById('re_guest').value,
                    re_meal_plan: document.getElementById('re_meal_plan').value,
                    re_guest_from_cat: document.getElementById('re_guest_from_cat').value,
                    re_country: document.getElementById('re_country').value
                };

                // Validation check
                if (!formData.re_guest && !formData.re_meal_plan &&
                    !formData.re_guest_from_cat && !formData.re_country) {
                    toastr.error('Please select at least one filter criteria');
                    return;
                }

                // Show loading indicator
                const loadingToast = toastr.info('Fetching registration data...', '', {
                    timeOut: 0,
                    extendedTimeOut: 0
                });

                fetch('{{ route('dashboard.registration-report') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        toastr.clear(loadingToast);

                        if (data.registrations && data.registrations.length > 0) {
                            generateRegistrationPrintWindow(data.registrations, formData);
                        } else {
                            toastr.error('No registrations found for the selected criteria');
                        }
                    })
                    .catch(error => {
                        toastr.clear(loadingToast);
                        console.error('Error:', error);
                        toastr.error('Failed to fetch registration data');
                    });
            });

            function generateRegistrationPrintWindow(registrations, filters) {
                const filterCriteria = [];
                if (filters.re_guest) filterCriteria.push(
                    `Guest: <span class="fw-normal">${registrations.find(r => r.guest_name === filters.re_guest)?.guest_type} ${filters.re_guest}</span><br>`
                );
                if (filters.re_meal_plan) filterCriteria.push(
                    `Meal Plan: <span class="fw-normal">${filters.re_meal_plan}</span><br>`);
                if (filters.re_guest_from_cat) filterCriteria.push(
                    `Guest From: <span class="fw-normal">${filters.re_guest_from_cat}</span><br>`);
                if (filters.re_country) filterCriteria.push(
                    `Country: <span class="fw-normal">${filters.re_country}</span><br>`);

                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Registration Report</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { font-family: Arial, sans-serif; }
                            .container { max-width: 100%; margin-top: 70px; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
                            .filter-criteria { margin-bottom: 20px; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h1 class="text-center fw-bold mt-3 mb-5">Registration Report</h1>
                            <div class="filter-criteria">
                                ${filterCriteria.map(criteria => `<h4 class="fw-bold">${criteria}</h4>`).join('')}
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Guest Name</th>
                                        <th>Contact No</th>
                                        <th>Room No</th>
                                        <th>Room Type</th>
                                        <th>Meal Plan</th>
                                        <th>Country</th>
                                        <th>Tour Agent</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${registrations.map((reg, index) => `
                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                        <td>${index + 1}</td>
                                                                                                                                                                                                                                                                        <td>${reg.guest_type} ${reg.guest_name}</td>
                                                                                                                                                                                                                                                                        <td>${reg.contact_no ?? ''}</td>
                                                                                                                                                                                                                                                                        <td>${reg.allocated_room_no}</td>
                                                                                                                                                                                                                                                                        <td>${reg.room_type}</td>
                                                                                                                                                                                                                                                                        <td>${reg.meal_plan}</td>
                                                                                                                                                                                                                                                                        <td>${reg.guest_country}</td>
                                                                                                                                                                                                                                                                        <td>${reg.guest_from_cat ?? ''}</td>
                                                                                                                                                                                                                                                                        <td>${new Date(reg.reservation_date).toLocaleDateString()}</td>
                                                                                                                                                                                                                                                                        <td>${new Date(reg.departure_date).toLocaleDateString()}</td>
                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                `).join('')}
                                </tbody>
                            </table>
                            <p class="fw-bold mt-3 mb-5">Total Records: ${registrations.length}</p>
                        </div>
                    </body>
                    </html>`;

                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.print();

                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            }

            // Registration history report handler
            document.getElementById('showRegistrationHistoryReport').addEventListener('click', function(e) {
                e.preventDefault();

                const formData = {
                    reg_from_date: document.getElementById('reg_from_date').value,
                    reg_to_date: document.getElementById('reg_to_date').value,
                    reg_guest: document.getElementById('reg_guest').value,
                    reg_meal_plan: document.getElementById('reg_meal_plan').value,
                    reg_guest_from_cat: document.getElementById('reg_guest_from_cat').value,
                    reg_country: document.getElementById('reg_country').value
                };

                // Validation checks
                if (!formData.reg_from_date && !formData.reg_to_date && !formData.reg_guest &&
                    !formData.reg_meal_plan && !formData.reg_guest_from_cat && !formData.reg_country) {
                    toastr.error('Please select at least one filter criteria');
                    return;
                }

                if ((formData.reg_from_date && !formData.reg_to_date) || (!formData.reg_from_date &&
                        formData.reg_to_date)) {
                    toastr.error('Please select both From Date and To Date');
                    return;
                }

                if (formData.reg_from_date && formData.reg_to_date && formData.reg_from_date > formData
                    .reg_to_date) {
                    toastr.error('From Date cannot be later than To Date');
                    return;
                }

                const loadingToast = toastr.info('Fetching registration history...', '', {
                    timeOut: 0,
                    extendedTimeOut: 0
                });

                fetch('{{ route('dashboard.registration-history-report') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        toastr.clear(loadingToast);

                        if (data.registration_history && data.registration_history.length > 0) {
                            generateRegistrationHistoryPrintWindow(data.registration_history, formData);
                        } else {
                            toastr.error('No registration history found for the selected criteria');
                        }
                    })
                    .catch(error => {
                        toastr.clear(loadingToast);
                        console.error('Error:', error);
                        toastr.error('Failed to fetch registration history data');
                    });
            });

            function generateRegistrationHistoryPrintWindow(registrations, filters) {
                const filterCriteria = [];
                if (filters.reg_from_date) filterCriteria.push(
                    `Date Range: <span class="fw-normal">${filters.reg_from_date} to ${filters.reg_to_date}</span>`
                );
                if (filters.reg_guest) filterCriteria.push(
                    `Guest: <span class="fw-normal">${filters.reg_guest}</span>`);
                if (filters.reg_meal_plan) filterCriteria.push(
                    `Meal Plan: <span class="fw-normal">${filters.reg_meal_plan}</span>`);
                if (filters.reg_guest_from_cat) filterCriteria.push(
                    `Guest From: <span class="fw-normal">${filters.reg_guest_from_cat}</span>`);
                if (filters.reg_country) filterCriteria.push(
                    `Country: <span class="fw-normal">${filters.reg_country}</span>`);

                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Registration History Report</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            body { font-family: Arial, sans-serif; }
                            .container { max-width: 100%; margin-top: 70px; }
                            table { width: 100%; border-collapse: collapse; }
                            th, td { padding: 10px; text-align: left; border: 1px solid #ddd; }
                            .filter-criteria { margin-bottom: 20px; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h1 class="text-center fw-bold mt-3 mb-5">Registration History Report</h1>
                            <div class="filter-criteria">
                                ${filterCriteria.map(criteria => `<h4 class="fw-bold">${criteria}</h4>`).join('')}
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Guest Name</th>
                                        <th>Contact No</th>
                                        <th>Room No</th>
                                        <th>Room Type</th>
                                        <th>Meal Plan</th>
                                        <th>Country</th>
                                        <th>Tour Agent</th>
                                        <th>Check In</th>
                                        <th>Check Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${registrations.map((reg, index) => `
                                                                                                                                                                                                                                                                        <tr>
                                                                                                                                                                                                                                                                            <td>${index + 1}</td>
                                                                                                                                                                                                                                                                            <td>${reg.guest_type} ${reg.guest_name}</td>
                                                                                                                                                                                                                                                                            <td>${reg.contact_no ?? ''}</td>
                                                                                                                                                                                                                                                                            <td>${reg.allocated_room_no}</td>
                                                                                                                                                                                                                                                                            <td>${reg.room_type}</td>
                                                                                                                                                                                                                                                                            <td>${reg.meal_plan}</td>
                                                                                                                                                                                                                                                                            <td>${reg.guest_country}</td>
                                                                                                                                                                                                                                                                            <td>${reg.guest_from_cat ?? ''}</td>
                                                                                                                                                                                                                                                                            <td>${reg.reservation_date}</td>
                                                                                                                                                                                                                                                                            <td>${reg.departure_date}</td>
                                                                                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                                                                                    `).join('')}
                                </tbody>
                            </table>
                            <p class="fw-bold mt-3 mb-5">Total Records: ${registrations.length}</p>
                        </div>
                    </body>
                    </html>`;

                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.print();

                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            }

            // Summary report handler
            document.getElementById('showSummaryReport').addEventListener('click', function() {
                const formData = {
                    report_type: document.getElementById('report_type').value,
                    from_date: document.getElementById('summary_from_date').value,
                    to_date: document.getElementById('summary_to_date').value
                };

                if (!formData.report_type || !formData.from_date || !formData.to_date) {
                    toastr.error('Please select a report type and date range');
                    return;
                }

                fetch('{{ route('dashboard.summary-report') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.summary.length > 0) {
                            generateSummaryPrintWindow(data, formData);
                        } else {
                            toastr.error('No data found for selected criteria');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('Failed to generate report');
                    });
            });

            function generateSummaryPrintWindow(data, filters) {
                const reportTypeLabels = {
                    'meal_plan': 'Meal Type',
                    'guest_country': 'Country',
                    'guest_from_cat': 'Job Agent'
                };

                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <title>${reportTypeLabels[data.reportType]} Summary Report</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>
                                body { font-family: Arial, sans-serif; }
                                .container { max-width: 100%; margin-top: 70px; box-sizing: border-box; }
                                table { width: 100%; border-collapse: collapse; }
                                table, th, td { border: 1px solid black; }
                                th, td { padding: 10px; text-align: left; }
                                h4 { margin-top: 20px; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <h1 class="text-center fw-bold mt-3 mb-5">${reportTypeLabels[data.reportType]} Summary Report</h1>
                                <h4 class="fw-bold mt-3 mb-3">From: <span style="font-weight: normal;">${filters.from_date}</span> To: <span style="font-weight: normal;">${filters.to_date}</span></h4>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>${reportTypeLabels[data.reportType]}</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.summary.map((item, index) => `
                                                                                                                                                                                                                                        <tr>
                                                                                                                                                                                                                                            <td>${index + 1}</td>
                                                                                                                                                                                                                                            <td>${item.name || 'N/A'}</td>
                                                                                                                                                                                                                                            <td>${item.count}</td>
                                                                                                                                                                                                                                        </tr>
                                                                                                                                                                                                                                    `).join('')}
                                    </tbody>
                                </table>
                                <p class="fw-bold mt-3 mb-5">Total Count: <span style="font-weight: normal;">${data.totalCount}</span></p>
                            </div>
                        </body>
                    </html>`;

                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.print();

                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            }

            document.getElementById('showTransactionReport').addEventListener('click', function(e) {
                e.preventDefault();

                const expenses = document.getElementById('expenses').value;
                const fromDate = document.getElementById('trans_from_date').value;
                const toDate = document.getElementById('trans_to_date').value;

                if (!fromDate || !toDate) {
                    toastr.error('Please select a date range');
                    return;
                }

                fetch('{{ route('dashboard.transaction-report') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            expenses: expenses,
                            trans_from_date: fromDate,
                            trans_to_date: toDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === "No data for selected expenses") {
                            toastr.error(data.message);
                            return;
                        }

                        if (data.success && (data.incomes.length > 0 || data.expenses.length > 0)) {
                            generateTransactionPrintWindow(data, fromDate, toDate, expenses);
                        } else {
                            toastr.error('No transactions found for the selected criteria');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while fetching transaction data');
                    });
            });

            function generateTransactionPrintWindow(data, fromDate, toDate, selectedExpense) {
                let totalIncome = 0;
                let totalExpense = 0;

                const printWindow = window.open('', '_blank');
                const printContent = `
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <title>Transaction Report</title>
                            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
                            <style>
                                body { font-family: Arial, sans-serif; }
                                .container { max-width: 100%; margin-top: 70px; }
                                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                                table, th, td { border: 1px solid black; }
                                th, td { padding: 10px; text-align: left; }
                                .total-row { font-weight: bold; }
                                .full-width-line { border-top: 1px solid black; margin: 4px 0; }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <h1 class="text-center fw-bold mt-3 mb-5">Transaction Report</h1>
                                <h4 class="fw-bold mt-3 mb-3">
                                    From: <span style="font-weight: normal;">${fromDate}</span> 
                                    To: <span style="font-weight: normal;">${toDate}</span>
                                    ${selectedExpense ? `<br>Expenses: <span style="font-weight: normal;">${selectedExpense}</span>` : ''}
                                </h4>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Handle By</th>
                                            <th>Income</th>
                                            <th>Expenses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.incomes.map(income => {
                                            totalIncome += parseFloat(income.amount);
                                            return `
                                                                                                                    <tr>
                                                                                                                        <td>${income.bill_no || '-'}</td>
                                                                                                                        <td>${income.date ? new Date(income.date).toISOString().split('T')[0] : '-'}</td>
                                                                                                                        <td>${income.description || '-'}</td>
                                                                                                                        <td>${income.handle_by || '-'}</td>
                                                                                                                        <td class="text-end">${parseFloat(income.amount).toFixed(2)}</td>
                                                                                                                        <td></td>
                                                                                                                    </tr>`;
                                        }).join('')}
                                        
                                        ${data.expenses.map(expense => {
                                            totalExpense += parseFloat(expense.amount);
                                            return `
                                                                                                                    <tr>
                                                                                                                        <td>${expense.bill_no || '-'}</td>
                                                                                                                        <td>${expense.date ? new Date(expense.date).toISOString().split('T')[0] : '-'}</td>
                                                                                                                        <td>${expense.description} ${expense.ex_cat ? `- ${expense.ex_cat}` : ''}</td>
                                                                                                                        <td>${expense.handle_by || '-'}</td>
                                                                                                                        <td></td>
                                                                                                                        <td class="text-end">${parseFloat(expense.amount).toFixed(2)}</td>
                                                                                                                    </tr>`;
                                        }).join('')}
                                        
                                        <tr class="total-row">
                                            <td colspan="4" class="text-end">Total:</td>
                                            <td class="text-end">${totalIncome.toFixed(2)}</td>
                                            <td class="text-end">${totalExpense.toFixed(2)}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 ms-3">Balance</h5>
                                    <h5 class="mb-0 me-5">${(totalIncome - totalExpense).toFixed(2)}</h5>
                                </div>
                                <div class="full-width-line"></div>
                                <div class="full-width-line"></div>
                            </div>
                        </body>
                    </html>`;

                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.print();

                printWindow.onafterprint = function() {
                    printWindow.close();
                };
            }
        });
    </script>
@endsection
