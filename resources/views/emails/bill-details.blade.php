<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1 style='text-align: center;'>BBQ HUB</h1>
    <h2 style='text-align: center;'>Bill Details Report</h2>

    <div>
        <p><strong>Guest Name:</strong> {{ $registration->guest_type }} {{ $registration->guest_name }}</p>
        <p><strong>Room No:</strong> {{ $registration->allocated_room_no }}</p>
        <p><strong>Room Type:</strong> {{ $registration->room_type }}</p>
        <p><strong>Stay Period:</strong> {{ $registration->reservation_date->format('Y-m-d') }} to
            {{ $registration->departure_date->format('Y-m-d') }}
        </p>
    </div>

    <h3 style="margin-top: 30px">Bill Summary</h3>
    <table>
        <tr>
            <th>Description</th>
            <th>Amount (Rs.)</th>
        </tr>
        <tr>
            <td>Room Charges</td>
            <td>{{ number_format($registration->rs, 2) }}</td>
        </tr>
        <tr>
            <td>Other Charges</td>
            <td>{{ number_format($otherCharges->sum('bill_total'), 2) }}</td>
        </tr>
        <tr>
            <td>Total Amount</td>
            <td>{{ number_format($registration->rs + $otherCharges->sum('bill_total'), 2) }}</td>
        </tr>
        <tr>
            <td>Advance Payment</td>
            <td>{{ number_format($advancePayments->sum('bill_total'), 2) }}</td>
        </tr>
        <tr class='total'>
            <td>Final Amount</td>
            <td>{{ number_format($finalBill, 2) }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 30px">Other Charges Details</h3>
    <table>
        <tr>
            <th>#</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Price (Rs.)</th>
            <th>Total (Rs.)</th>
            <th>Bill Date</th>
        </tr>
        @forelse($otherCharges as $index => $charge)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $charge->item_name }}</td>
                <td>{{ $charge->qty }}</td>
                <td>{{ number_format($charge->price, 2) }}</td>
                <td>{{ number_format($charge->bill_total, 2) }}</td>
                <td>{{ $charge->bill_date->format('Y-m-d') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No other charges found</td>
            </tr>
        @endforelse
    </table>

    <p>Thank you for choosing our services!</p>
    <p>Best regards,<br>BBQ HUB</p>
</body>

</html>
