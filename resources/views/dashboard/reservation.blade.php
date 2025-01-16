@extends('layouts.app')

@section('content')
    <main class="main-wrapper min-vh-100">
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <form id="reservation-form" method="POST"
                                                action="{{ route('reservations.store') }}" class="row g-3 needs-validation"
                                                novalidate>
                                                @csrf
                                                <input type="hidden" name="reservation_id" id="reservation_id">
                                                <div class="col-md-3">
                                                    <label for="c" class="form-label">Reservation
                                                        Date</label>
                                                    <input type="date" class="form-control" id="reservation_date"
                                                        name="reservation_date"
                                                        value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                                    <div class="invalid-feedback">
                                                        Please select a reservation date.
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="reservation_time" class="form-label">Time</label>
                                                    <input type="text" class="form-control time-picker"
                                                        name="reservation_time" id="reservation_time" required>
                                                    <div class="invalid-feedback">
                                                        Please enter a valid time.
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="no_of_day" class="form-label">No of Days Stay</label>
                                                    <input type="text" class="form-control" id="no_of_day"
                                                        name="no_of_day" oninput="calculateDepartureDate()" required>
                                                    <div class="invalid-feedback">
                                                        Please enter the number of days stay.
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="departure_date" class="form-label">Departure Date</label>
                                                    <input type="date" class="form-control" id="departure_date"
                                                        name="departure_date" required>
                                                    <div class="invalid-feedback">
                                                        Please select a departure date.
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-4">
                                                    <label for="total_pax_count" class="form-label">Total PAX Count</label>
                                                    <input type="text" class="form-control" name="total_pax_count"
                                                        id="total_pax_count" required>
                                                    <div class="invalid-feedback">
                                                        Please enter the total PAX count.
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="guest_type" class="form-label">Guest Type</label>
                                                    <select name="guest_type" id="guest_type" class="form-select" required>
                                                        <option value="">Select</option>
                                                        <option value="Mr.">Mr.</option>
                                                        <option value="Mrs.">Mrs.</option>
                                                        <option value="Miss.">Miss.</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select the guest type.
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="guest_name" class="form-label">Guest Name</label>
                                                    <input type="text" class="form-control" name="guest_name"
                                                        id="guest_name" required>
                                                    <div class="invalid-feedback">
                                                        Please enter the guest name.
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="contact_no" class="form-label">Contact No</label>
                                                    <input type="text" class="form-control" name="contact_no"
                                                        id="contact_no">
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        id="email">
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="guest_from_cat" class="form-label">Guest From</label>
                                                    <select name="guest_from_cat" id="guest_from_cat" class="form-select"
                                                        required>
                                                        <option value="">Select Guest From</option>
                                                        @foreach ($guestFromCategories as $category)
                                                            <option value="{{ $category->cat_name }}">
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select where the guest is from.
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="agent_code" class="form-label">Agent Code</label>
                                                    <input type="text" class="form-control" name="agent_code"
                                                        id="agent_code">
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="guest_country" class="form-label">Country</label>
                                                    <select class="form-select" name="guest_country" id="guest_country"
                                                        required onchange="updateCurrency()">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->country_name }}">
                                                                {{ $country->country_name }} - {{ $country->nationality }}
                                                                ({{ $country->spoken_language }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select the country.
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="room_type" class="form-label">Room Type</label>
                                                    <select name="room_type" id="room_type" class="form-select" required>
                                                        <option value="">Select Room Type</option>
                                                        @foreach ($roomTypes as $category)
                                                            <option value="{{ $category->cat_name }}">
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select the room type.
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="no_of_pax" class="form-label">No of Pax (Per Room)</label>
                                                    <select name="no_of_pax" id="no_of_pax" class="form-select" required>
                                                        <option value="">Select No of Pax</option>
                                                        @foreach ($noOfPaxCategories as $category)
                                                            <option value="{{ $category->cat_name }}">
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select the no of pax for per room.
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label for="meal_plan" class="form-label">Meal Plan</label>
                                                    <select name="meal_plan" id="meal_plan" class="form-select" required>
                                                        <option value="">Select Meal Plan</option>
                                                        @foreach ($mealPlans as $category)
                                                            <option value="{{ $category->cat_name }}">
                                                                {{ $category->cat_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select the meal plan.
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label for="rooms_need" class="form-label">Rooms Need</label>
                                                    <input type="text" class="form-control" name="rooms_need"
                                                        id="rooms_need" required>
                                                    <div class="invalid-feedback">
                                                        Please enter the how many rooms needed.
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="us" class="form-label">Rate : US $</label>
                                                    <input type="text" class="form-control" name="us"
                                                        id="us" required>
                                                    <div class="invalid-feedback">
                                                        Please enter the US $ price.
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-4">
                                                    <label for="rs" class="form-label">SL Rs.</label>
                                                    <input type="text" class="form-control" name="rs"
                                                        id="rs" required>
                                                    <div class="invalid-feedback">
                                                        Please enter the rs price.
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <label for="adults" class="form-label">Adults</label>
                                                    <input type="text" class="form-control" name="adults"
                                                        id="adults" required>
                                                    <div class="invalid-feedback">
                                                        Please enter the adults count.
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="children" class="form-label">Children</label>
                                                    <input type="text" class="form-control" name="children"
                                                        id="children">
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="infants" class="form-label">Infants</label>
                                                    <input type="text" class="form-control" name="infants"
                                                        id="infants">
                                                </div>
                                                <div class="col-md-9 mb-4">
                                                    <label for="description" class="form-label">Note</label>
                                                    <input type="text" class="form-control" name="description"
                                                        id="description">
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

                                    <div class="card mt-5">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Guest Name</th>
                                                            <th>Guest Country</th>
                                                            <th>Contact No</th>
                                                            <th>Email</th>
                                                            <th>Agent Code</th>
                                                            <th>Guest From</th>
                                                            <th>Room Type</th>
                                                            <th>Meal Plan</th>
                                                            <th>No of Pax</th>
                                                            <th>Total Pax</th>
                                                            <th>Rooms need</th>
                                                            <th>US</th>
                                                            <th>RS</th>
                                                            <th>Note</th>
                                                            <th>Adults</th>
                                                            <th>Children</th>
                                                            <th>Infants</th>
                                                            <th>Reservation Date</th>
                                                            <th>Departure Date</th>
                                                            <th>No of Days</th>
                                                            <th>Reservation Code</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reservations as $index => $reservation)
                                                            <tr data-reservation="{{ json_encode($reservation) }}"
                                                                data-id="{{ $reservation->id }}" class="reservation-row">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $reservation->guest_type }}
                                                                    {{ $reservation->guest_name }}</td>
                                                                <td>{{ $reservation->guest_country }}</td>
                                                                <td>{{ $reservation->contact_no }}</td>
                                                                <td>{{ $reservation->email }}</td>
                                                                <td>{{ $reservation->agent_code }}</td>
                                                                <td>{{ $reservation->guest_from_cat }}</td>
                                                                <td>{{ $reservation->room_type }}</td>
                                                                <td>{{ $reservation->meal_plan }}</td>
                                                                <td>{{ $reservation->no_of_pax }}</td>
                                                                <td>{{ $reservation->total_pax_count }}</td>
                                                                <td>{{ $reservation->rooms_need }}</td>
                                                                <td>{{ $reservation->us }}</td>
                                                                <td>{{ $reservation->rs }}</td>
                                                                <td>{{ $reservation->description }}</td>
                                                                <td>{{ $reservation->adults }}</td>
                                                                <td>{{ $reservation->children }}</td>
                                                                <td>{{ $reservation->infants }}</td>
                                                                <td>{{ $reservation->reservation_date->format('Y-m-d') }}
                                                                </td>
                                                                <td>{{ $reservation->departure_date->format('Y-m-d') }}
                                                                </td>
                                                                <td>{{ $reservation->no_of_day }}</td>
                                                                <td>{{ $reservation->reservation_code }}</td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-center gap-3 flex-wrap">
                                                                        <button type="button"
                                                                            class="btn btn-grd btn-grd-danger px-4 delete-btn"
                                                                            data-id="{{ $reservation->id }}">
                                                                            Delete
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
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

        $(document).ready(function() {
            $('.reservation-row').on('click', function() {
                const reservation = $(this).data('reservation');

                // Format dates properly
                const reservationDate = new Date(reservation.reservation_date).toISOString().split('T')[0];
                const departureDate = new Date(reservation.departure_date).toISOString().split('T')[0];
                const reservationTime = reservation.reservation_time.substring(11, 16); // Extract HH:mm

                // Populate form fields
                $('#reservation_id').val(reservation.id);
                $('#reservation_date').val(reservationDate);
                $('#reservation_time').val(reservationTime);
                $('#departure_date').val(departureDate);
                $('#no_of_day').val(reservation.no_of_day);
                $('#total_pax_count').val(reservation.total_pax_count);
                $('#guest_type').val(reservation.guest_type);
                $('#guest_name').val(reservation.guest_name);
                $('#contact_no').val(reservation.contact_no);
                $('#email').val(reservation.email);
                $('#guest_from_cat').val(reservation.guest_from_cat);
                $('#agent_code').val(reservation.agent_code);
                $('#guest_country').val(reservation.guest_country);
                $('#room_type').val(reservation.room_type);
                $('#no_of_pax').val(reservation.no_of_pax);
                $('#meal_plan').val(reservation.meal_plan);
                $('#rooms_need').val(reservation.rooms_need);
                $('#us').val(reservation.us);
                $('#rs').val(reservation.rs);
                $('#adults').val(reservation.adults);
                $('#children').val(reservation.children);
                $('#infants').val(reservation.infants);
                $('#description').val(reservation.description);

                // Show update button and hide submit button
                $('#submit').hide();
                $('#update').show();

                // Update form action for update
                $('#reservation-form').attr('action', `/reservations/${reservation.id}`);
                $('#reservation-form').append('<input type="hidden" name="_method" value="PUT">');
            });

            // Reset form handler
            $('button[type="reset"]').click(function() {
                $('#submit').show();
                $('#update').hide();
                $('#reservation-form').attr('action', '{{ route('reservations.store') }}');
                $('input[name="_method"]').remove();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-btn').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteId = this.getAttribute('data-id');

                    // Create the custom confirmation dialog
                    const confirmationDialog = document.createElement('div');
                    confirmationDialog.classList.add('confirmation-dialog');
                    confirmationDialog.innerHTML = `
                <div>
                    <img src="assets/images/wired-outline-1140-error.gif" alt="Warning Icon" class="warning-icon">
                    <p class="fs-3 text-black fw-bold">Are you sure ?</p>
                    <p class="fs-6" style="color: #6c757d;">You won't be able to revert this!</p>
                    <div class="button-container">
                        <button id="yesButton" class="btn btn-danger">Yes</button>
                        <button id="noButton" class="btn btn-secondary">No</button>
                    </div>
                </div>
            `;
                    document.body.appendChild(confirmationDialog);

                    // Handle Yes button click
                    document.getElementById('yesButton').addEventListener('click', function() {
                        // Create and submit form for deletion
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/reservations/${deleteId}`;

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        const tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = '_token';
                        tokenInput.value = '{{ csrf_token() }}';

                        form.appendChild(methodInput);
                        form.appendChild(tokenInput);
                        document.body.appendChild(form);
                        form.submit();
                    });

                    // Handle No button click
                    document.getElementById('noButton').addEventListener('click', function() {
                        document.body.removeChild(confirmationDialog);
                        toastr.error('Delete canceled');
                    });
                });
            });
        });
    </script>
@endsection
