@extends('layouts.app')

@section('content')
    <main class="main-wrapper min-vh-100">
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                <div class="col-9 col-xl-9">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <form id="registration-form"
                                                method="POST"action="{{ route('registration.store') }}"
                                                class="row g-3 needs-validation" novalidate>
                                                @csrf
                                                <input type="hidden" name="reservation_id" id="reservation_id">
                                                <input type="hidden" name="registration_id" id="registration_id">
                                                <input type="hidden" name="reservation_code" id="reservation_code"
                                                    value="{{ session('reservation_data.reservation_code') ?? '' }}">

                                                <h5 class="mb-1">Allocate a room</h5>
                                                <div class="col-md-4 mb-2">
                                                    <select name="allocated_room_no" id="allocated_room_no"
                                                        class="form-select">
                                                        <option value="">Select Room</option>
                                                        @foreach ($availableRooms as $room)
                                                            <option value="{{ $room->room_no }}">
                                                                {{ $room->room_no }} || {{ $room->room_type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <hr class="mb-4">

                                                <div class="col-md-2">
                                                    <label for="reservation_date" class="form-label">Reservation
                                                        Date</label>
                                                    <input type="date" class="form-control" id="reservation_date"
                                                        name="reservation_date"
                                                        value="{{ session('reservation_data.reservation_date') ?? date('Y-m-d') }}"
                                                        required>
                                                    <div class="invalid-feedback">Please select a reservation date.</div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="reservation_time" class="form-label">Time</label>
                                                    <input type="text" class="form-control" name="reservation_time"
                                                        id="reservation_time"
                                                        value="{{ session('reservation_data.reservation_time') ?? old('reservation_time') }}"
                                                        required>
                                                    <div class="invalid-feedback">Please enter a valid time.</div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="no_of_day" class="form-label">No of Days Stay</label>
                                                    <input type="text" class="form-control" id="no_of_day"
                                                        name="no_of_day"
                                                        value="{{ session('reservation_data.no_of_day') ?? old('no_of_day') }}"
                                                        oninput="calculateDepartureDate()" required>
                                                    <div class="invalid-feedback">Please enter the number of days stay.
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="departure_date" class="form-label">Departure Date</label>
                                                    <input type="date" class="form-control" id="departure_date"
                                                        name="departure_date"
                                                        value="{{ session('reservation_data.departure_date') ?? date('Y-m-d') }}"
                                                        required>
                                                    <div class="invalid-feedback">Please select a departure date.</div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="departure_time" class="form-label text-warning">Departure
                                                        Time</label>
                                                    <input type="text" class="form-control time-picker"
                                                        name="departure_time" id="departure_time" required>
                                                    <div class="invalid-feedback">Please select a departure time.</div>
                                                </div>

                                                <div class="col-md-2 mb-4">
                                                    <label for="total_pax_count" class="form-label">Total PAX Count</label>
                                                    <input type="text" class="form-control" name="total_pax_count"
                                                        id="total_pax_count"
                                                        value="{{ session('reservation_data.total_pax_count') ?? old('total_pax_count') }}"
                                                        required>
                                                    <div class="invalid-feedback">Please enter the total PAX count.</div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="guest_type" class="form-label">Guest Type</label>
                                                    <select name="guest_type" id="guest_type" class="form-select" required>
                                                        <option value="">Select</option>
                                                        <option value="Mr."
                                                            {{ session('reservation_data.guest_type') == 'Mr.' ? 'selected' : '' }}>
                                                            Mr.</option>
                                                        <option value="Mrs."
                                                            {{ session('reservation_data.guest_type') == 'Mrs.' ? 'selected' : '' }}>
                                                            Mrs.</option>
                                                        <option value="Miss."
                                                            {{ session('reservation_data.guest_type') == 'Miss.' ? 'selected' : '' }}>
                                                            Miss.</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select the guest type.</div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="guest_name" class="form-label">Guest Name</label>
                                                    <input type="text" class="form-control" id="guest_name"
                                                        name="guest_name"
                                                        value="{{ session('reservation_data.guest_name') ?? old('guest_name') }}"
                                                        required>
                                                    <div class="invalid-feedback">
                                                        Please enter the guest name.
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="contact_no" class="form-label">Contact No</label>
                                                    <input type="text" class="form-control" name="contact_no"
                                                        value="{{ session('reservation_data.contact_no') ?? old('contact_no') }}"
                                                        id="contact_no">
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        id="email"
                                                        value="{{ session('reservation_data.email') ?? old('email') }}">
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="id_pass" class="form-label text-warning">ID /
                                                        Passport</label>
                                                    <input type="text" class="form-control" name="id_pass"
                                                        id="id_pass">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="expire_date" class="form-label text-warning">Expire
                                                        Date</label>
                                                    <input type="date" class="form-control" id="expire_date"
                                                        name="expire_date">
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label for="address" class="form-label text-warning">Address</label>
                                                    <input type="text" class="form-control" name="address"
                                                        id="address">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="guest_country" class="form-label">Country</label>
                                                    <select class="form-select" name="guest_country" id="guest_country"
                                                        required>
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->country_name }}"
                                                                {{ session('reservation_data.guest_country') == $country->country_name ? 'selected' : '' }}>
                                                                {{ $country->country_name }} - {{ $country->nationality }}
                                                                ({{ $country->spoken_language }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select the country.</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="guest_from_cat" class="form-label">Guest From</label>
                                                    <select name="guest_from_cat" id="guest_from_cat" class="form-select"
                                                        required>
                                                        <option value="">Select Guest From</option>
                                                        @foreach ($guestFromCategories as $category)
                                                            <option value="{{ $category->cat_name }}"
                                                                {{ session('reservation_data.guest_from_cat') == $category->cat_name ? 'selected' : '' }}>
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select where the guest is from.
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="room_type" class="form-label">Room Type</label>
                                                    <select name="room_type" id="room_type" class="form-select" required>
                                                        <option value="">Select Room Type</option>
                                                        @foreach ($roomTypes as $category)
                                                            <option value="{{ $category->cat_name }}"
                                                                {{ session('reservation_data.room_type') == $category->cat_name ? 'selected' : '' }}>
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select the room type.</div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="no_of_pax" class="form-label">No of Pax (Per Room)</label>
                                                    <select name="no_of_pax" id="no_of_pax" class="form-select" required>
                                                        <option value="">Select No of Pax</option>
                                                        @foreach ($noOfPaxCategories as $category)
                                                            <option value="{{ $category->cat_name }}"
                                                                {{ session('reservation_data.no_of_pax') == $category->cat_name ? 'selected' : '' }}>
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select the no of pax for per room.
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="meal_plan" class="form-label">Meal Plan</label>
                                                    <select name="meal_plan" id="meal_plan" class="form-select" required>
                                                        <option value="">Select Meal Plan</option>
                                                        @foreach ($mealPlans as $category)
                                                            <option value="{{ $category->cat_name }}"
                                                                {{ session('reservation_data.meal_plan') == $category->cat_name ? 'selected' : '' }}>
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Please select the meal plan.</div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="profession"
                                                        class="form-label text-warning">Profession</label>
                                                    <input type="text" class="form-control" name="profession"
                                                        id="profession">
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="rooms_need" class="form-label">Rooms Need</label>
                                                    <input type="text" class="form-control" name="rooms_need"
                                                        id="rooms_need"
                                                        value="{{ session('reservation_data.rooms_need') ?? old('rooms_need') }}"
                                                        required>
                                                    <div class="invalid-feedback">
                                                        Please enter the how many rooms needed.
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="currency" class="form-label text-warning">Currency</label>
                                                    <select name="currency" id="currency" class="form-select" required>
                                                        <option value="">Select Currency</option>
                                                        <option value="Rs">Rs</option>
                                                        <option value="$">$</option>
                                                    </select>
                                                    <div class="invalid-feedback">Please select the currency type.</div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="us" class="form-label">Rate : US $</label>
                                                    <input type="text" class="form-control" name="us"
                                                        id="us"
                                                        value="{{ session('reservation_data.us') ?? old('us') }}" required
                                                        data-rate="{{ $usRate }}">
                                                    <div class="invalid-feedback">Please enter the US $ price.</div>
                                                </div>

                                                <div class="col-md-3 mb-4">
                                                    <label for="rs" class="form-label">SL Rs.</label>
                                                    <input type="text" class="form-control" name="rs"
                                                        id="rs"
                                                        value="{{ session('reservation_data.rs') ?? old('rs') }}"
                                                        required>
                                                    <div class="invalid-feedback">Please enter the rs price.</div>
                                                </div>

                                                <div class="col-md-1">
                                                    <label for="adults" class="form-label">Adults</label>
                                                    <input type="text" class="form-control" name="adults"
                                                        id="adults"value="{{ session('reservation_data.adults') ?? old('adults') }}">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="children" class="form-label">Children</label>
                                                    <input type="text" class="form-control" name="children"
                                                        id="children"
                                                        value="{{ session('reservation_data.children') ?? old('children') }}">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="infants" class="form-label">Infants</label>
                                                    <input type="text" class="form-control" name="infants"
                                                        id="infants"
                                                        value="{{ session('reservation_data.infants') ?? old('infants') }}">
                                                </div>
                                                <div class="col-md-9 mb-4">
                                                    <label for="description" class="form-label">Note</label>
                                                    <input type="text" class="form-control" name="description"
                                                        id="description"
                                                        value="{{ session('reservation_data.description') ?? old('description') }}">
                                                </div>

                                                <div class="col-md-12 mt-5">
                                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                        <button type="submit" id="submit"
                                                            class="btn btn-grd btn-grd-info px-5 fw-bold"
                                                            style="display: block;">Submit</button>
                                                        <button type="submit" id="update"
                                                            class="btn btn-grd btn-grd-warning px-5 py-2 fw-bold"
                                                            style="display: none;">Update</button>
                                                        <button type="reset"
                                                            class="btn btn-grd btn-grd-royal px-5 fw-bold">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 col-xl-3">
                                    <h5 class="mb-2">Pick Reservation</h5>
                                    <h6 class="mb-3 text-warning fw-bold">USD Rate : <span
                                            class="text-white">{{ $usRate }}</span></h6>
                                    <table id="reservation" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Guest Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($reservations as $index => $reservation)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td
                                                        class="{{ $reservation->status === 'Registered' ? 'text-warning' : '' }}">
                                                        <form action="{{ route('registration.fetch-reservation') }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="reservation_id"
                                                                value="{{ $reservation->id }}">
                                                            <span onclick="this.closest('form').submit()"
                                                                style="cursor: pointer">
                                                                {{ $reservation->guest_type . '  ' . $reservation->guest_name }}
                                                            </span>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty <tr>
                                                    <td colspan="2">No reservations found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-12 col-xl-12 mt-3">
                                    <div class="col-md-12 mt-5">
                                        <div class="d-flex justify-content-start gap-3 flex-wrap">
                                            <button type="button" id="print"
                                                class="btn btn-grd btn-grd-primary px-5 fw-bold">Print</button>
                                            <button type="button" id="upload"
                                                class="btn btn-grd btn-grd-success px-5 fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#FullScreenModal">Image Upload</button>
                                        </div>
                                    </div>
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Guest Name</th>
                                                            <th>Allocated Room No</th>
                                                            <th>Key Room</th>
                                                            <th>Status</th>
                                                            <th>Image</th>
                                                            <th>Guest Country</th>
                                                            <th>Contact No</th>
                                                            <th>Email</th>
                                                            <th>ID / Passport</th>
                                                            <th>Address</th>
                                                            <th>Guest From</th>
                                                            <th>Room Type</th>
                                                            <th>Meal Plan</th>
                                                            <th>No of Pax</th>
                                                            <th>Total Pax</th>
                                                            <th>Profession</th>
                                                            <th>Rooms need</th>
                                                            <th>US</th>
                                                            <th>RS</th>
                                                            <th>Note</th>
                                                            <th>Adults</th>
                                                            <th>Children</th>
                                                            <th>Infants</th>
                                                            <th>Reservation</th>
                                                            <th>Departure</th>
                                                            <th>No of Days</th>
                                                            <th>Reservation Code</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    @php
                                                        $groupedRegistrations = $registrations->groupBy(function (
                                                            $registration,
                                                        ) {
                                                            return $registration->reservation_code .
                                                                '_' .
                                                                $registration->key_room;
                                                        });
                                                    @endphp

                                                    <tbody>
                                                        @forelse ($groupedRegistrations as $group)
                                                            @foreach ($group as $index => $registration)
                                                                <tr data-registration-id="{{ $registration->id }}"
                                                                    class="registration-row" style="cursor: pointer;">
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $registration->guest_type }}
                                                                        {{ $registration->guest_name }}</td>
                                                                    <td
                                                                        class="{{ !empty($registration->allocated_room_no) ? 'text-warning fw-bold' : '' }}">
                                                                        {{ $registration->allocated_room_no ?? '' }}</td>
                                                                    <td>{{ $registration->key_room }}</td>
                                                                    <td>{{ $registration->status }}</td>
                                                                    <td>
                                                                        @if (
                                                                            $registration->image &&
                                                                                ($index === 0 ||
                                                                                    !$registrations->where('guest_name', $registration->guest_name)->where('reservation_code', $registration->reservation_code)->where('id', '<', $registration->id)->count()))
                                                                            <div class="image-hover-container">
                                                                                <img src="{{ asset('storage/guests/' . $registration->image) }}"
                                                                                    alt="Guest Image"
                                                                                    class="thumbnail-image"
                                                                                    onmouseover="showHoverPreview(this)"
                                                                                    onmouseout="hideHoverPreview()">
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $registration->guest_country }}</td>
                                                                    <td>{{ $registration->contact_no }}</td>
                                                                    <td>{{ $registration->email }}</td>
                                                                    <td>{{ $registration->id_pass }}</td>
                                                                    <td>{{ $registration->address }}</td>
                                                                    <td>{{ $registration->guest_from_cat }}</td>
                                                                    <td>{{ $registration->room_type }}</td>
                                                                    <td>{{ $registration->meal_plan }}</td>
                                                                    <td>{{ $registration->no_of_pax }}</td>
                                                                    <td>{{ $registration->total_pax_count }}</td>
                                                                    <td>{{ $registration->profession }}</td>
                                                                    <td>{{ $registration->rooms_need }}</td>
                                                                    <td>{{ $registration->us }}</td>
                                                                    <td>{{ $registration->rs }}</td>
                                                                    <td>{{ $registration->description }}</td>
                                                                    <td>{{ $registration->adults }}</td>
                                                                    <td>{{ $registration->children }}</td>
                                                                    <td>{{ $registration->infants }}</td>
                                                                    <td>{{ $registration->reservation_date->format('Y-m-d') }}
                                                                        <br>
                                                                        {{ $registration->reservation_time->format('H:i') }}
                                                                    </td>
                                                                    <td>{{ $registration->departure_date->format('Y-m-d') }}
                                                                        <br>
                                                                        {{ $registration->departure_time->format('H:i') }}
                                                                    </td>
                                                                    <td>{{ $registration->no_of_day }}</td>
                                                                    <td>{{ $registration->reservation_code }}</td>
                                                                    @if ($index === 0)
                                                                        <td
                                                                            @if ($group->count() > 1) rowspan="{{ $group->count() }}" style="vertical-align: middle;" @endif>
                                                                            <div
                                                                                class="d-flex justify-content-center gap-3 flex-wrap">
                                                                                <button type="button"
                                                                                    class="btn btn-grd btn-grd-danger px-4 delete-btn"
                                                                                    data-id="{{ $registration->id }}"
                                                                                    data-reservation-code="{{ $registration->reservation_code }}"
                                                                                    data-key-room="{{ $registration->key_room }}">
                                                                                    Delete
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        @empty
                                                            <tr>
                                                                <td colspan="29" class="text-center">No registrations
                                                                    found</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end row-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="card-body">
                    <div class="modal fade" id="FullScreenModal">
                        <div class="modal-dialog modal-fullscreen">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0 py-2 bg-grd-primary">
                                    <h5 class="modal-title text-uppercase fw-bold fs-2">Image Upload</h5>
                                    <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                        <i class="material-icons-outlined">close</i>
                                    </a>
                                </div>
                                <div class="modal-body mt-5">
                                    <div class="row">
                                        <div class="col-xl-9 mx-auto mt-5">
                                            <div class="card m-5">
                                                <div class="card-body">
                                                    <form>
                                                        <input id="image-uploadify" type="file" accept="image/*"
                                                            multiple>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end row-->
                                </div>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-grd-danger rounded-0"
                                        data-bs-dismiss="modal">Delete</button>
                                    <button type="button" id="save" class="btn btn-grd-info rounded-0">Save
                                        changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--end main wrapper-->
@endsection

@section('scripts')
    <script>
        let previewElement = null;

        function showHoverPreview(element) {
            const preview = document.createElement('img');
            preview.src = element.src;
            preview.className = 'hover-preview';
            document.body.appendChild(preview);
            setTimeout(() => preview.style.display = 'block', 50);
            previewElement = preview;
        }

        function hideHoverPreview() {
            if (previewElement) {
                previewElement.remove();
                previewElement = null;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#reservation').DataTable({
                "searching": true,
                "paging": false,
                "info": false,
                "lengthChange": false,
                "ordering": false,
                "dom": '<"top"f>rt<"bottom"p><"clear">'
            });
        });

        function calculateDepartureDate() {
            const reservationDate = document.getElementById('reservation_date').value;
            const noOfDays = parseInt(document.getElementById('no_of_day').value);

            if (!isNaN(noOfDays) && reservationDate) {
                const date = new Date(reservationDate);
                date.setDate(date.getDate() + noOfDays);

                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');

                document.getElementById('departure_date').value = `${year}-${month}-${day}`;
            }
        }

        // Get current rate from backend
        let currentRate = {!! json_encode(App\Models\Rate::latest('id')->first()) !!};

        document.getElementById('us').addEventListener('input', function() {
            let usValue = parseFloat(this.value);
            if (this.value === '') {
                document.getElementById('rs').value = '';
            } else if (!isNaN(usValue)) {
                let rsValue = usValue * currentRate.us_rate;
                document.getElementById('rs').value = rsValue.toFixed(2);
            }
        });

        document.getElementById('rs').addEventListener('input', function() {
            let rsValue = parseFloat(this.value);
            if (this.value === '') {
                document.getElementById('us').value = '';
            } else if (!isNaN(rsValue)) {
                let usValue = rsValue / currentRate.us_rate;
                document.getElementById('us').value = usValue.toFixed(2);
            }
        });

        $('.registration-row').click(function() {
            const registrationId = $(this).data('registration-id');

            // Reset form and remove any existing method field
            $('#registration-form')[0].reset();
            $('input[name="_method"]').remove();

            $.get(`/registration/${registrationId}`, function(data) {
                // Populate form fields
                $('#registration_id').val(data.id);
                $('#reservation_code').val(data.reservation_code);
                $('#reservation_date').val(data.reservation_date);
                $('#departure_date').val(data.departure_date);
                $('#reservation_time').val(data.reservation_time);
                $('#departure_time').val(data.departure_time);
                $('#no_of_day').val(data.no_of_day);
                $('#total_pax_count').val(data.total_pax_count);
                $('#guest_type').val(data.guest_type);
                $('#guest_name').val(data.guest_name);
                $('#contact_no').val(data.contact_no);
                $('#email').val(data.email);
                $('#id_pass').val(data.id_pass);
                $('#expire_date').val(data.expire_date);
                $('#address').val(data.address);
                $('#guest_country').val(data.guest_country);
                $('#guest_from_cat').val(data.guest_from_cat);
                $('#room_type').val(data.room_type);
                $('#no_of_pax').val(data.no_of_pax);
                $('#meal_plan').val(data.meal_plan);
                $('#profession').val(data.profession);
                $('#rooms_need').val(data.rooms_need);
                $('#currency').val(data.currency);
                $('#us').val(data.us);
                $('#rs').val(data.rs);
                $('#adults').val(data.adults);
                $('#children').val(data.children);
                $('#infants').val(data.infants);
                $('#description').val(data.description);

                // Handle room selection
                if (data.allocated_room_no) {
                    // If the allocated room isn't in the dropdown, add it
                    if (!$('#allocated_room_no option[value="' + data.allocated_room_no + '"]').length) {
                        $('#allocated_room_no').append(new Option(
                            data.allocated_room_no + ' || ' + data.room_type,
                            data.allocated_room_no
                        ));
                    }
                    $('#allocated_room_no').val(data.allocated_room_no);
                }

                // Update form for PUT request
                const form = $('#registration-form');
                form.attr('action', `/registration/${data.id}/update`);
                form.append('<input type="hidden" name="_method" value="PUT">');

                // Show update button and hide submit button
                $('#submit').hide();
                $('#update').show();
            });
        });

        // Reset form handler
        $('button[type="reset"]').click(function() {
            $('#submit').show();
            $('#update').hide();
            $('#registration-form').attr('action', '{{ route('registration.store') }}');
            $('input[name="_method"]').remove();
        });

        $(document).ready(function() {
            let selectedRegistrationId = null;
            let selectedReservationCode = null;
            let selectedGuestName = null;

            // Update registration row click handler
            $('.registration-row').click(function() {
                selectedRegistrationId = $(this).data('registration-id');
                selectedReservationCode = $(this).find('td:last')
                    .text(); // Assuming reservation code is in last column
                selectedGuestName = $(this).find('td:eq(1)').text()
                    .trim(); // Assuming guest name is in second column
            });

            // Handle save button click in modal
            $('#save').click(function() {
                const imageInput = $('#image-uploadify')[0].files[0];
                if (!imageInput) {
                    toastr.error('Please select an image first');
                    return;
                }

                if (!selectedRegistrationId) {
                    toastr.error('Please select a registration first');
                    return;
                }

                const formData = new FormData();
                formData.append('image', imageInput);
                formData.append('registration_id', selectedRegistrationId);
                formData.append('reservation_code', selectedReservationCode);
                formData.append('guest_name', selectedGuestName);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('registration.upload-image') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#FullScreenModal').modal('hide');
                            location.reload(); // Refresh to show updated image
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Upload failed: ' + xhr.responseText);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#example tbody').on('click', 'tr', function() {
                // Remove selected class from all rows and add to clicked row
                $('#example tbody tr').removeClass('selected');
                $(this).addClass('selected');
            });

            $('#print').on('click', function() {
                const selectedRow = $('#example tbody tr.selected');
                const registrationId = selectedRow.data('registration-id');

                if (registrationId) {
                    // Create a form and submit it to open in new window
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('registration.print') }}';
                    form.target = '_blank';

                    // Add CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    // Add registration ID
                    const registrationInput = document.createElement('input');
                    registrationInput.type = 'hidden';
                    registrationInput.name = 'registration_id';
                    registrationInput.value = registrationId;

                    form.appendChild(csrfToken);
                    form.appendChild(registrationInput);
                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                } else {
                    toastr.error('Please select a registration to print');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteId = this.getAttribute('data-id');
                    const reservationCode = this.getAttribute('data-reservation-code');
                    const keyRoom = this.getAttribute('data-key-room');

                    const confirmationDialog = document.createElement('div');
                    confirmationDialog.classList.add('confirmation-dialog');
                    confirmationDialog.innerHTML = `
            <div>
                <img src="assets/images/wired-outline-1140-error.gif" alt="Warning Icon" class="warning-icon">
                <p class="fs-3 text-black fw-bold">Are you sure?</p>
                <p class="fs-6" style="color: #6c757d;">You won't be able to revert this!</p>
                <div class="button-container">
                    <button id="yesButton" class="btn btn-danger">Yes</button>
                    <button id="noButton" class="btn btn-secondary">No</button>
                </div>
            </div>
        `;
                    document.body.appendChild(confirmationDialog);

                    document.getElementById('yesButton').addEventListener('click', function() {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/registration/${deleteId}`;

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        const tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = '_token';
                        tokenInput.value = '{{ csrf_token() }}';

                        const reservationCodeInput = document.createElement('input');
                        reservationCodeInput.type = 'hidden';
                        reservationCodeInput.name = 'reservation_code';
                        reservationCodeInput.value = reservationCode;

                        const keyRoomInput = document.createElement('input');
                        keyRoomInput.type = 'hidden';
                        keyRoomInput.name = 'key_room';
                        keyRoomInput.value = keyRoom;

                        form.appendChild(methodInput);
                        form.appendChild(tokenInput);
                        form.appendChild(reservationCodeInput);
                        form.appendChild(keyRoomInput);
                        document.body.appendChild(form);
                        form.submit();
                    });

                    document.getElementById('noButton').addEventListener('click', function() {
                        document.body.removeChild(confirmationDialog);
                        toastr.error('Delete canceled');
                    });
                });
            });
        });
    </script>
@endsection
