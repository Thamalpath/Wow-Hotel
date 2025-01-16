<!DOCTYPE html>
<html>

<head>
    <title>Registration Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
                text-align: center;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .no-print {
                display: none;
            }
        }

        .container {
            max-width: 100%;
            width: 1000px;
            padding: 20px;
            box-sizing: border-box;
        }

        .registration-table {
            width: 100%;
            text-align: left;
        }

        .telephone {
            text-align: center;
            margin-bottom: 20px;
        }

        .registration-card {
            border: 1px solid black;
            padding: 20px;
            position: relative;
            width: 100%;
        }

        .registration-card .row {
            margin-bottom: 15px;
        }

        .small-table {
            border: 1px solid black;
            text-align: center;
            width: 100%;
        }

        .small-table td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="container" style="position: relative;">
        <div
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1; z-index: -1;">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Watermark Logo" style="width: 80%;">
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <h3 class="text-start fw-bold fs-2 text-warning">Registration Card</h3>
                <div class="telephone text-start">
                    <h6>0777 305 613 / 057 222 0375</h6>
                </div>
            </div>
            <div>
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid"
                    style="max-height: 60px;">
            </div>
        </div>

        <div class="registration-card">
            <div class="row">
                <div class="col-6 text-start">
                    <table class="registration-table mt-4">
                        <tr>
                            <th>Full Name :</th>
                            <td>{{ $registration->guest_type }} {{ $registration->guest_name }}</td>
                        </tr>
                        <tr>
                            <th>Address :</th>
                            <td>{{ $registration->address }}</td>
                        </tr>
                        <tr>
                            <th>Telephone :</th>
                            <td>{{ $registration->contact_no }}</td>
                        </tr>
                        <tr>
                            <th>Email :</th>
                            <td>{{ $registration->email }}</td>
                        </tr>
                        <tr>
                            <th>Tour Agent :</th>
                            <td>{{ $registration->guest_from_cat }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-6 text-end">
                    <table class="small-table">
                        <tr>
                            <th colspan="2">Arrival</th>
                        </tr>
                        <tr>
                            <td class="fw-bold">Date</td>
                            <td>{{ $registration->reservation_date->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Time</td>
                            <td>{{ $registration->reservation_time->format('H:i') }}</td>
                        </tr>
                    </table>
                    <table class="small-table mt-2">
                        <tr>
                            <th colspan="2">Departure</th>
                        </tr>
                        <tr>
                            <td class="fw-bold">Date</td>
                            <td>{{ $registration->departure_date->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Time</td>
                            <td>{{ $registration->departure_time->format('H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="registration-card">
            <div class="row">
                <div class="col-6 text-start">
                    <table class="registration-table mt-4">
                        <tr>
                            <th>Nationality : <span
                                    style="font-weight: normal;">{{ $registration->guest_country }}</span></th>
                        </tr>
                        <tr>
                            <th>Passport / ID : <span
                                    style="font-weight: normal;">{{ $registration->id_pass ?? '' }}</span>
                            </th>
                        </tr>
                        <tr>
                    </table>
                </div>
                <div class="col-6 text-end">
                    <table class="registration-table mt-4">
                        <tr>
                            <th>Profession : <span style="font-weight: normal;">{{ $registration->profession }}</span>
                            </th>
                        </tr>
                        <tr>
                            <th>Expire Date : <span
                                    style="font-weight: normal;">{{ $registration->expire_date ? $registration->expire_date->format('Y-m-d') : '' }}</span>
                            </th>
                        </tr>
                        <tr>
                    </table>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-3">
                    <p>------------------------</p>
                    <h6 class="fw-bold">Guest Signature 1</h6>
                </div>
                <div class="col-3">
                    <p>------------------------</p>
                    <h6 class="fw-bold">Guest Signature 1</h6>
                </div>
                <div class="col-3">
                    <p>------------------------</p>
                    <h6 class="fw-bold">Guest Signature 1</h6>
                </div>
                <div class="col-3">
                    <p>------------------</p>
                    <h6 class="fw-bold">Date</h6>
                </div>
            </div>
        </div>

        <div class="registration-card mt-2">
            <div class="row">
                <div class="col-12">
                    <table class="registration-table w-100">
                        <tr rowspan="2">
                            <th class="fs-3 text-center">FOR OFFICIAL USE ONLY</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="registration-card">
            <div class="row">
                <div class="col-6 text-start">
                    <table class="registration-table">
                        <tr>
                            <th>Key Room Number : <span
                                    style="font-weight: normal;">{{ $registration->key_room }}</span>
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="col-6 text-end">
                    <table class="registration-table">
                        <tr>
                            <th>Group :
                                <span style="font-weight: normal;">
                                    @if ($rooms->count() > 0)
                                        {{ $rooms->implode(', ') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="registration-card mt-2">
            <table class="registration-table" style="width: 100%;">
                <tr>
                    <td class="fw-bold" style="border-right: 1px solid black; padding-right: 10px;">
                        Meal Plan : <span style="font-weight: normal;">{{ $registration->meal_plan }}</span>
                    </td>
                    <td class="fw-bold" style="border-right: 1px solid black; padding-right: 10px; padding-left: 10px;">
                        No of Pax : <span style="font-weight: normal;">{{ $registration->no_of_pax }}</span>
                    </td>
                    <td class="fw-bold" style="padding-left: 10px;">
                        Room Type : <span style="font-weight: normal;">{{ $registration->room_type }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="registration-card mt-3">
            <div class="row">
                <div class="col-12 text-start">
                    <h6 class="fw-bold">Guest Bill No :</h6>
                </div>
            </div>
        </div>
        <div class="registration-card">
            <div class="row">
                <div class="col-2" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <th>Discount</th>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <th>Authorized By</th>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <th>Percentage / Amount</th>
                        </tr>
                    </table>
                </div>
                <div class="col-2">
                    <table class="registration-table">
                        <tr>
                            <th>Manager's Signature</th>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <tb>
                            </tb>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <tb>
                            </tb>
                        </tr>
                    </table>
                </div>
                <div class="col-2">
                    <table class="registration-table">
                        <tr>
                            <tb>
                            </tb>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="registration-card mt-3">
            <div class="row">
                <div class="col-2" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <th>Payment</th>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <th>Direct</th>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <th>Credit</th>
                        </tr>
                    </table>
                </div>
                <div class="col-2">
                    <table class="registration-table">
                        <tr>
                            <th>Receptionist</th>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <tb>
                            </tb>
                        </tr>
                    </table>
                </div>
                <div class="col-4" style="border-right: 1px solid black; padding-right: 10px;">
                    <table class="registration-table">
                        <tr>
                            <tb>
                            </tb>
                        </tr>
                    </table>
                </div>
                <div class="col-2">
                    <table class="registration-table">
                        <tr>
                            <tb>
                            </tb>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
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
