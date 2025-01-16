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
                                            <form id="billingForm" method="POST" class="row g-3 needs-validation"
                                                novalidate>
                                                @csrf

                                                <h5 class="mb-1">Room No:</h5>
                                                <div class="col-md-3 mb-2">
                                                    <select name="allocated_room_no" id="allocated_room_no"
                                                        class="form-select">
                                                        <option value="">Select Room</option>
                                                        @foreach ($rooms as $room)
                                                            <option value="{{ $room->room_no }}">
                                                                {{ $room->room_no }} ||
                                                                {{ $room->registration->guest_name }}
                                                            </option>
                                                        @endforeach
                                                        <option value="Other Billing">Other Billing</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-9 mb-2">
                                                    <h2 class="mb-1 text-center text-uppercase fw-bold">Guest Item Billing
                                                    </h2>
                                                </div>
                                                <hr class="mb-4">

                                                <div class="col-md-5">
                                                    <div class="table-responsive"
                                                        style="max-height: 450px; overflow-y: auto;">
                                                        <table id="table1" class="table table-striped table-bordered"
                                                            style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Room No</th>
                                                                    <th>Bill Date</th>
                                                                    <th>Guest Name</th>
                                                                    <th>Bill No</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-7">
                                                    <div class="col-md-12 mb-2">
                                                        <h3 id="guestName" class="text-center fw-bold text-warning"
                                                            style="display: none;"></h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="bill_date" class="form-label">Bill Date</label>
                                                            <input type="date" class="form-control" id="bill_date"
                                                                name="bill_date" value="{{ now()->format('Y-m-d') }}"
                                                                required>
                                                            <div class="invalid-feedback">
                                                                Please select a bill date.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="item" class="form-label">Item</label>
                                                            <select class="form-select" name="item" id="item"
                                                                required disabled>
                                                                <option value="">Select Item</option>
                                                                @foreach ($items as $item)
                                                                    <option value="{{ $item->item_name }}"
                                                                        data-item-code="{{ $item->item_code }}"
                                                                        data-price="{{ $item->price }}">
                                                                        {{ $item->item_code }} - {{ $item->item_name }} -
                                                                        {{ $item->price }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Please select the item.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="qty" class="form-label">Quantity</label>
                                                            <input type="number" class="form-control" id="qty"
                                                                name="qty" required>
                                                            <div class="invalid-feedback">
                                                                Please enter a quantity.
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-4">
                                                            <label for="price" class="form-label">Price</label>
                                                            <input type="number" class="form-control" id="price"
                                                                name="price" readonly required>
                                                            <div class="invalid-feedback">
                                                                Please select an item to set the price.
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-4">
                                                            <label for="addItem" class="form-label">&nbsp;</label>
                                                            <button type="button" id="addItem"
                                                                class="btn btn-grd btn-grd-info px-5 fw-bold mt-4">Add
                                                                Item</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-4">
                                                        <div class="table-responsive">
                                                            <table id="table2" class="table table-striped table-bordered"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Item Name</th>
                                                                        <th>Qty</th>
                                                                        <th>Price</th>
                                                                        <th>Total</th>
                                                                        <th>Bill Date</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- Table body will be populated dynamically -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-4">
                                                        <h4 class="mb-1 text-start fw-bold">Total Value of the Bill : <span
                                                                id="totalBill" class="text-warning"></span></h4>
                                                        <button type="submit" id="submitBill"
                                                            class="btn btn-grd btn-grd-primary px-5 fw-bold mt-3">Print
                                                            Bill</button>
                                                    </div>
                                                </div>
                                            </form>
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
        $(document).ready(function() {
            let billItems = [];
            let billNo = localStorage.getItem('billNo') || 1000;
            billNo = parseInt(billNo, 10);

            updateBillingTable();

            $('#submitBill').prop('disabled', true);

            $('#allocated_room_no').change(function() {
                const roomNo = $(this).val();
                if (roomNo === 'Other Billing') {
                    $('#guestName').hide();
                    $('#item').prop('disabled', false);
                } else if (roomNo) {
                    const selectedOption = $(this).find('option:selected');
                    const guestName = selectedOption.text().split('||')[1].trim();
                    $('#guestName').text(guestName).show();
                    $('#item').prop('disabled', false);
                } else {
                    $('#item').prop('disabled', true);
                    $('#guestName').hide();
                }
            });

            $('#item').change(function() {
                const selectedOption = $(this).find('option:selected');
                const price = selectedOption.data('price');
                $('#price').val(price);
            });

            $('#addItem').click(function() {
                addItemToBill();
            });

            $('#qty').keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    addItemToBill();
                }
            });

            function addItemToBill() {
                const selectedOption = $('#item option:selected');
                const itemData = {
                    itemName: selectedOption.val(),
                    itemCode: selectedOption.data('item-code'),
                    itemCat: 'R',
                    qty: $('#qty').val(),
                    price: $('#price').val(),
                    billDate: $('#bill_date').val()
                };

                if (itemData.itemName && itemData.qty && itemData.price) {
                    itemData.total = itemData.qty * itemData.price;
                    billItems.push(itemData);
                    updateTable();
                    updateTotalBill();
                    resetForm();
                } else {
                    toastr.error('Please fill in all fields');
                }
            }

            function updateTable() {
                const tableBody = $('#table2 tbody');
                tableBody.empty();

                billItems.forEach((item, index) => {
                    tableBody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.itemName}</td>
                    <td>${item.qty}</td>
                    <td>${item.price}</td>
                    <td>${item.total.toFixed(2)}</td>
                    <td>${item.billDate}</td>
                    <td>
                        <button class="btn btn-danger delete-row px-3 fw-bold raised" 
                                data-index="${index}">X</button>
                    </td>
                </tr>
            `);
                });

                $('#submitBill').prop('disabled', billItems.length === 0);
            }

            $(document).on('click', '.delete-row', function() {
                const indexToDelete = $(this).data('index');
                billItems.splice(indexToDelete, 1);
                updateTable();
                updateTotalBill();
            });

            function updateTotalBill() {
                const total = billItems.reduce((sum, item) => sum + item.total, 0);
                $('#totalBill').text(total.toFixed(2));
            }

            function resetForm() {
                $('#item').val('');
                $('#qty').val('');
                $('#price').val('');
            }

            $('#billingForm').submit(function(e) {
                e.preventDefault();

                const currentTime = new Date().toLocaleTimeString();
                const formData = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    allocated_room_no: $('#allocated_room_no').val(),
                    guest_name: $('#guestName').text() || 'Other Billing',
                    bill_date: $('#bill_date').val(),
                    bill_no: billNo,
                    bill_items: billItems,
                    total_bill: $('#totalBill').text()
                };

                $.ajax({
                    url: "{{ route('billing.store') }}",
                    type: 'POST',
                    data: JSON.stringify(formData),
                    contentType: 'application/json',
                    success: function(response) {
                        if (response.success) {
                            printBill(formData, currentTime);
                            billNo++;
                            localStorage.setItem('billNo', billNo);
                            billItems = [];
                            updateTable();
                            updateTotalBill();
                            updateBillingTable();
                            toastr.success('Bill created successfully');
                            $('#allocated_room_no').val('');
                            $('#guestName').hide();
                            $('#item').prop('disabled', true);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        if (response && response.errors) {
                            Object.values(response.errors).forEach(error => {
                                toastr.error(error[0]);
                            });
                        } else {
                            toastr.error(response?.message || 'Error creating bill');
                        }
                    }
                });
            });

            function printBill(formData, currentTime) {
                const printWindow = window.open('', '_blank');
                const printContent = `
                    <html>
                    <head>
                        <title>Print Bill</title>
                        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
                        <style>
                            body { 
                                font-family: Arial, sans-serif; 
                            }
                            .container {
                                max-width: 100%;
                                width: 500px;
                                padding: 20px;
                                box-sizing: border-box;
                                margin-top: 40px;
                                margin-left: 40px;
                                border: 1px solid black;
                            }
                            table { 
                                width: 100%; 
                                border-collapse: collapse; 
                            }
                            table, th, td { 
                                border: 1px solid black; 
                                padding: 8px;
                            }
                            .left { 
                                float: left; 
                                width: 50%; 
                            }
                            .right { 
                                float: right; 
                                width: 50%; 
                                text-align: right; 
                            }
                            .full-width-line { 
                                border-top: 1px solid black; 
                                margin: 4px 0; 
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <h1 class="text-center fw-bold mt-3 mb-3" style="font-family: Lora, sans-serif;">BBQ HUB</h1>
                            <div class="left">
                                <p class="fw-bold">Guest Billing : <span style="font-weight: normal;">Restaurant</span></p>
                                <p class="fw-bold">Date : <span style="font-weight: normal;">${formData.bill_date}</span></p>
                                <p class="fw-bold">Room No : <span class="fw-bold">${formData.allocated_room_no}</span></p>
                                <p class="fw-bold">Guest Name : <span class="fw-bold">${formData.guest_name}</span></p>
                            </div>
                            <div class="right">
                                <p>${currentTime}</p>
                                <p class="fw-bold">Bill No: <span style="font-weight: normal;">${formData.bill_no}</span></p>
                            </div>
                            <div style="clear: both;"></div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${formData.bill_items.map(item => `
                                                                                            <tr>
                                                                                                <td>${item.itemName}</td>
                                                                                                <td>${item.qty}</td>
                                                                                                <td>${item.price}</td>
                                                                                                <td>${item.total.toFixed(2)}</td>
                                                                                            </tr>
                                                                                        `).join('')}
                                </tbody>
                            </table>
                            <h5 class="mt-4 fw-bold">Total Bill: ${formData.total_bill}</h5>
                            <div class="full-width-line"></div>
                            <div class="full-width-line"></div>
                            <p class="mt-4">................................</p>
                            <p class="fw-bold">Guest Signature</p>
                        </div>
                    </body>
                    </html>
                `;

                printWindow.document.write(printContent);
                printWindow.document.close();
                printWindow.print();

                printWindow.onafterprint = function() {
                    printWindow.close();
                    window.location.href = "{{ route('billing.index') }}";
                };
            }

            function updateBillingTable() {
                $.get("{{ route('billing.latest') }}", function(data) {
                    const tableBody = $('#table1 tbody');
                    tableBody.empty();

                    data.forEach((billing, index) => {
                        tableBody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${billing.key_room}</td>
                                <td>${new Date(billing.bill_date).toLocaleDateString()}</td>
                                <td>${billing.guest_name}</td>
                                <td>${billing.bill_no}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${billing.id}">
                                        X
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                });
            }
        });
    </script>

    <script>
        // Replace the existing delete button click handler with this code
        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const billNo = $(this).closest('tr').find('td:eq(4)')
                    .text(); // Get bill_no from the table row

                const confirmationDialog = document.createElement('div');
                confirmationDialog.classList.add('confirmation-dialog');
                confirmationDialog.innerHTML = `
                    <div>
                        <img src="{{ asset('assets/images/wired-outline-1140-error.gif') }}" alt="Warning Icon" class="warning-icon">
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
                    $.ajax({
                        url: `/billing/${billNo}/delete-all`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Billing items deleted successfully');
                                setTimeout(function() {
                                    window.location.href =
                                        "{{ route('billing.index') }}";
                                    updateBillingTable
                                        (); // Refresh the billing table
                                }, 2000);
                            } else {
                                toastr.error(response.message);
                            }
                            document.body.removeChild(confirmationDialog);
                        },
                        error: function(xhr) {
                            toastr.error('Error deleting billing items');
                            document.body.removeChild(confirmationDialog);
                        }
                    });
                });

                document.getElementById('noButton').addEventListener('click', function() {
                    document.body.removeChild(confirmationDialog);
                    toastr.error('Delete canceled');
                });
            });
        });
    </script>
@endsection
