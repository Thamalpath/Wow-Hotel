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
                                            <form method="POST" action="{{ route('checkout.process', $registration->id) }}"
                                                class="row g-3 needs-validation">
                                                @csrf
                                                <div class="col-md-4">
                                                    <h5 class="fw-bold">Room No:
                                                        <span class="text-warning" style="font-weight: normal;">
                                                            {{ $registration->allocated_room_no }}
                                                        </span>
                                                    </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5 class="fw-bold">Guest:
                                                        <span class="text-warning" style="font-weight: normal;">
                                                            {{ $registration->guest_type }} {{ $registration->guest_name }}
                                                        </span>
                                                    </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <h5 class="fw-bold">Country:
                                                        <span class="text-warning" style="font-weight: normal;">
                                                            {{ $registration->guest_country }}
                                                        </span>
                                                    </h5>
                                                </div>
                                                <hr>

                                                <div class="col-md-8">
                                                    <div class="row mb-5">
                                                        <div class="col-md-3">
                                                            <h6 class="fw-bold">Arrival:
                                                                <span class="text-warning" style="font-weight: normal;">
                                                                    {{ $registration->reservation_date->format('Y-m-d') }}
                                                                </span>
                                                            </h6>
                                                            <h6 class="mt-3 fw-bold">Departure:
                                                                <span class="text-warning" style="font-weight: normal;">
                                                                    {{ $registration->departure_date->format('Y-m-d') }}
                                                                </span>
                                                            </h6>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <h6 class="fw-bold">Meals:
                                                                <span class="text-warning" style="font-weight: normal;">
                                                                    {{ $registration->meal_plan }}
                                                                </span>
                                                            </h6>
                                                            <h6 class="mt-3 fw-bold">Room Type:
                                                                <span class="text-warning" style="font-weight: normal;">
                                                                    {{ $registration->room_type }}
                                                                </span>
                                                            </h6>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <h6 class="fw-bold">Guest:
                                                                <span class="text-warning" style="font-weight: normal;">
                                                                    {{ $registration->total_pax_count }}
                                                                </span>
                                                            </h6>
                                                            <h6 class="mt-3 fw-bold">Contact:
                                                                <span class="text-warning" style="font-weight: normal;">
                                                                    {{ $registration->contact_no }}
                                                                </span>
                                                            </h6>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <h6 class="fw-bold">T. Agent:
                                                                <span class="text-warning" style="font-weight: normal;">
                                                                    {{ $registration->guest_from_cat }}
                                                                </span>
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    <h4 class="text-warning mb-3 fw-bold">Details of other charges
                                                    </h4>
                                                    <table class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Room No</th>
                                                                <th>Description</th>
                                                                <th>Qty</th>
                                                                <th>Price</th>
                                                                <th>Total</th>
                                                                <th>Bill Date</th>
                                                                <th>Bill No</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($otherCharges as $index => $charge)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $charge->allocated_room_no }}</td>
                                                                    <td>{{ $charge->item_name }}</td>
                                                                    <td>{{ $charge->qty }}</td>
                                                                    <td>{{ number_format($charge->price, 2) }}</td>
                                                                    <td>{{ number_format($charge->bill_total, 2) }}</td>
                                                                    <td>{{ $charge->bill_date->format('Y-m-d') }}</td>
                                                                    <td>{{ $charge->bill_no }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="text-center">No charges found
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                    <div class="card mt-5">
                                                        <div class="card-body row p-4">
                                                            <div class="col-md-4">
                                                                <label for="cash_pay" class="form-label">Cash Pay</label>
                                                                <input type="text" class="form-control" name="cash_pay"
                                                                    id="cash_pay">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="tour_pay" class="form-label">Tour Operator
                                                                    Pay</label>
                                                                <input type="text" class="form-control" name="tour_pay"
                                                                    id="tour_pay">
                                                            </div>
                                                            <div class="col-md-4  mb-4">
                                                                <label for="card_pay" class="form-label">Card Pay</label>
                                                                <input type="text" class="form-control" name="card_pay"
                                                                    id="card_pay">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label for="card_no" class="form-label">Card No</label>
                                                                <input type="text" class="form-control" name="card_no"
                                                                    id="card_no">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="bank" class="form-label">Bank</label>
                                                                <input type="text" class="form-control" name="bank"
                                                                    id="bank">
                                                            </div>
                                                            <div class="col-md-4 mb-4">
                                                                <label for="card_type" class="form-label">Card Type</label>
                                                                <input type="text" class="form-control" name="card_type"
                                                                    id="card_type">
                                                            </div>

                                                            <div class="col-md-4">
                                                                <label for="cheque_date" class="form-label">Cheque
                                                                    Date</label>
                                                                <input type="date" class="form-control"
                                                                    id="cheque_date" name="cheque_date"
                                                                    value="{{ date('Y-m-d') }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h5 class="fw-bold mt-5 text-warning" id="total">Total
                                                                    Pay: <span class="text-white">0.00</span></h5>
                                                            </div>

                                                            <div class="col-md-4 mt-4">
                                                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                                    <button type="button" onclick="processCheckout()"
                                                                        class="btn btn-grd btn-grd-danger px-5 fw-bold"
                                                                        {{ !$registration->departure_date->isToday() ? 'disabled' : '' }}>
                                                                        Check Out
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 mt-5">
                                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                                    <button type="button" id="advancePay"
                                                                        class="btn btn-grd btn-grd-info px-3 fw-bold"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#BasicModal">Advance
                                                                        Payment</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-5">
                                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                                    <a href="{{ route('checkout.print-summary', $hash) }}"
                                                                        target="_blank"
                                                                        class="btn btn-grd btn-grd-primary px-3 fw-bold">
                                                                        Final Bill - Summary
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-5">
                                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                                    <a href="{{ route('checkout.print-details', $hash) }}"
                                                                        target="_blank"
                                                                        class="btn btn-grd btn-grd-primary px-3 fw-bold">
                                                                        Final Bill - Details
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 mt-5">
                                                                <button type="button"
                                                                    class="btn btn-grd btn-grd-info px-3 fw-bold"
                                                                    onclick="sendBillEmail()">
                                                                    Send Bill - Details
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 flex">
                                                    <h4 class="text-warning fw-bold mb-3">Guest Final Bill Arrangement
                                                    </h4>
                                                    <hr>
                                                    <h6 class="fw-bold mb-3">Room Charges :
                                                        <span class="text-warning float-end" style="font-weight: normal;">
                                                            {{ number_format($registration->rs, 2) }}
                                                        </span>
                                                    </h6>
                                                    <h6 class="fw-bold">Other Charges :
                                                        <span id="totalOtherCharges" class="text-warning float-end"
                                                            style="font-weight: normal;">
                                                            {{ number_format($otherCharges->sum('bill_total'), 2) }}
                                                        </span>
                                                    </h6>
                                                    <hr>
                                                    <h6 class="fw-bold">Total :
                                                        <span class="text-warning float-end">
                                                            {{ number_format($registration->rs + $otherCharges->sum('bill_total'), 2) }}
                                                        </span>
                                                    </h6>
                                                    <hr>
                                                    <h6 class="fw-bold mt-4">Deduct from the Total :
                                                        <span class="text-warning float-end" style="font-weight: normal;">
                                                            0
                                                        </span>
                                                    </h6>
                                                    <hr>
                                                    <h6 class="fw-bold">
                                                        <span class="text-warning float-end">
                                                            {{ number_format($registration->rs + $otherCharges->sum('bill_total'), 2) }}
                                                        </span>
                                                    </h6>
                                                    <br>
                                                    <hr>
                                                    <h6 class="fw-bold mt-4">Advance :
                                                        <span class="text-warning float-end" style="font-weight: normal;">
                                                            {{ number_format($advancePayments->sum('bill_total'), 2) }}
                                                        </span>
                                                    </h6>
                                                    <hr>
                                                    <h5 class="fw-bold mt-4 text-warning">Final Bill (Rs) :
                                                        <span class="ms-5 float-end" style="color: red;">
                                                            {{ number_format($finalBill, 2) }}
                                                        </span>
                                                    </h5>
                                                    <hr>
                                                    <h5 class="fw-bold mt-4 text-warning"> US Dollars ($) :
                                                        <span id="usDollar" class="ms-5 float-end text-white">
                                                            {{ number_format($usDollarAmount, 2) }}
                                                        </span>
                                                    </h5>
                                                    <hr>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="card-body">
                        <div class="modal fade" id="BasicModal">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header border-bottom-0 py-2 bg-grd-primary">
                                        <h5 class="modal-title fw-bold fs-2">Guest Advance Payment</h5>
                                        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                                            <i class="material-icons-outlined">close</i>
                                        </a>
                                    </div>
                                    <div class="modal-body mt-4 mb-5">
                                        <form method="POST" action="{{ route('checkout.advance-payment', $hash) }}">
                                            @csrf
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <h6 class="mb-0">Room No:</h6>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" name="allocated_room_no"
                                                        value="{{ $registration->allocated_room_no }}" readonly>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mb-4">
                                                <div class="col-md-4">
                                                    <label for="advance_date" class="form-label">Advance Date</label>
                                                    <input type="date" class="form-control" id="advance_date"
                                                        name="advance_date" value="{{ date('Y-m-d') }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="payment_mode" class="form-label">Payment Mode</label>
                                                    <select name="payment_mode" id="payment_mode" class="form-select"
                                                        required>
                                                        <option value="">Select Payment Mode</option>
                                                        <option value="Cash">Cash</option>
                                                        <option value="Card Payment">Card Payment</option>
                                                        <option value="Bank Transfer">Bank Transfer</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="paid_details" class="form-label">Paid Details</label>
                                                    <input type="text" class="form-control" id="paid_details"
                                                        name="paid_details" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="paid_amount" class="form-label">Paid Amount</label>
                                                    <input type="number" step="0.01" class="form-control"
                                                        id="paid_amount" name="paid_amount" required>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                    <button type="submit" class="btn btn-grd btn-grd-info px-4 fw-bold">
                                                        Advance Pay
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-10 col-xl-10 mt-5">
                                            <table id="table1" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Paid Date</th>
                                                        <th>Description</th>
                                                        <th>Paid Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($advancePayments as $index => $payment)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $payment->bill_date->format('Y-m-d') }}</td>
                                                            <td>{{ $payment->item_name }}</td>
                                                            <td>{{ number_format($payment->price, 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center">No advance payments
                                                                found</td>
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
    </main>
@endsection

@section('scripts')
    <script>
        // Function to calculate the total payment
        function calculateTotal() {
            // Get the values from the input fields
            let cashPay = parseFloat($('#cash_pay').val()) || 0;
            let cardPay = parseFloat($('#card_pay').val()) || 0;
            let tourPay = parseFloat($('#tour_pay').val()) || 0;

            // Calculate the total
            let totalPay = cashPay + cardPay + tourPay;

            // Display the total in the #total span
            $('#total').html(`Total Pay: <span class="text-white"> ${totalPay.toFixed(2)} </span>`);
        }

        // Attach the event listeners to the input fields
        $('#cash_pay').on('input', calculateTotal);
        $('#card_pay').on('input', calculateTotal);
        $('#tour_pay').on('input', calculateTotal);
    </script>

    <script>
        function sendBillEmail() {
            $.ajax({
                url: '{{ route('checkout.send-bill', $hash) }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr[response.type](response.message);
                },
                error: function(xhr) {
                    toastr.error('Failed to send email');
                }
            });
        }
    </script>

    <script>
        function processCheckout() {
            const formData = {
                cash_pay: $('#cash_pay').val(),
                tour_pay: $('#tour_pay').val(),
                card_pay: $('#card_pay').val(),
                card_no: $('#card_no').val(),
                bank: $('#bank').val(),
                card_type: $('#card_type').val()
            };

            $.ajax({
                url: '{{ route('checkout.process', $hash) }}',
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr[response.type](response.message);
                    if (response.type === 'success') {
                        setTimeout(() => {
                            window.location.href = '{{ route('dashboard') }}';
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    toastr.error('Checkout failed');
                }
            });
        }
    </script>
@endsection
