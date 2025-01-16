<!DOCTYPE html>
<html>

<head>
    <title>Bill Summary</title>
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
        <h1 class="text-center fw-bold mt-3 mb-5">Bill Summary</h1>

        <div class="row">
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

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Room Charges</td>
                    <td class="text-center">{{ number_format($registration->rs, 2) }}</td>
                </tr>
                <tr>
                    <td>Other Charges</td>
                    <td class="text-center">{{ number_format($otherCharges->sum('bill_total'), 2) }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="fw-bold fs-4 text-center">{{ number_format($total, 2) }}</td>
                </tr>
                <tr>
                    <td class="fw-bold" style="border-right: none;">
                        Add to the bill
                        <br><br>
                        <span class="ms-4" style="font-weight: normal;">Total VAT</span>
                    </td>
                    <td class="text-center" style="border-left: none;">
                        <br><br>
                        000.00
                    </td>
                </tr>
                <tr>
                    <td class="fw-bold" style="border-right: none;">
                        Deduction to the bill
                        <br><br>
                        <span class="ms-4" style="font-weight: normal;">Advance Payment :</span>
                    </td>
                    <td class="text-center" style="border-left: none;">
                        <br><br>
                        {{ number_format($totalAdvance, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-3">
            <p class="fw-bold fs-5 mb-0">Final Bill Total</p>
            <p class="fw-bold fs-4 mb-0 me-5">{{ number_format($finalBill, 2) }}</p>
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
