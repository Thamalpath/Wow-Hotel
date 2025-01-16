<!DOCTYPE html>
<html>

<head>
    <title>Bill Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 80%;
            margin-top: 70px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        h4 {
            margin-top: 20px;
        }

        .full-width-line {
            border-top: 1px solid black;
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center fw-bold mt-3 mb-5">Guest Final Bill - Detail Report</span></h1>

        <!-- Guest Information -->
        <div class="row mb-4">
            <div class="col-8">
                <p class="fw-bold">Guest Name: <span style="font-weight: normal;">{{ $registration->guest_type }}
                        {{ $registration->guest_name }}</span></p>
                <p class="fw-bold">Room No: <span
                        style="font-weight: normal;">{{ $registration->allocated_room_no }}</span></p>
                <p class="fw-bold">Arrival: <span
                        style="font-weight: normal;">{{ $registration->reservation_date->format('Y-m-d') }}</span></p>
                <p class="fw-bold">Meal Plan: <span style="font-weight: normal;">{{ $registration->meal_plan }}</span>
                </p>
            </div>
            <div class="col-4">
                <p class="fw-bold">Tour Agent: <span
                        style="font-weight: normal;">{{ $registration->guest_from_cat }}</span></p>
                <p class="fw-bold">Room Type: <span style="font-weight: normal;">{{ $registration->room_type }}</span>
                </p>
                <p class="fw-bold">Departure: <span
                        style="font-weight: normal;">{{ $registration->departure_date->format('Y-m-d') }}</span></p>
            </div>
        </div>

        <!-- Billing Items -->
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Room No</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $registration->reservation_date->format('Y-m-d') }}</td>
                    <td>{{ $registration->allocated_room_no }}</td>
                    <td>ROOM CHARGES</td>
                    <td>1</td>
                    <td class="text-end">{{ number_format($registration->rs, 2) }}</td>
                    <td class="text-end">{{ number_format($registration->rs, 2) }}</td>
                </tr>
                @foreach ($billingItems as $item)
                    <tr>
                        <td>{{ $item->bill_date->format('Y-m-d') }}</td>
                        <td>{{ $item->allocated_room_no }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td class="text-end">{{ number_format($item->price, 2) }}</td>
                        <td class="text-end">{{ number_format($item->bill_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="d-flex justify-content-between mt-3">
            <p class="fw-bold fs-5 mb-0 ms-5">Final Bill Total</p>
            <p class="fw-bold fs-4 mb-0 me-5">{{ number_format($total, 2) }}</p>
        </div>
        <div class="full-width-line"></div>
        <div class="mt-4">
            <p class="fw-bold fs-5 mt-3">Deduct from the bill</p>
            <div class="d-flex justify-content-between mb-2">
                <span class="ms-5 fs-6">Advance Payment:</span>
                <span class="me-5 fs-6">{{ number_format($totalAdvance, 2) }}</span>
            </div>
        </div>
        <div class="full-width-line"></div>

        <div class="d-flex justify-content-between mt-2">
            <span class="ms-5 fs-5 fw-bold">Final Total:</span>
            <span class="me-5 fs-5 fw-bold">{{ number_format($finalBill, 2) }}</span>
        </div>
        <div class="full-width-line"></div>
        <div class="full-width-line"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        });
    </script>
</body>

</html>
