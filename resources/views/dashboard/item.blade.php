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
                                            <form id="item-form" method="POST" action="{{ route('items.store') }}"
                                                class="row g-3 needs-validation" novalidate>
                                                @csrf
                                                <input type="hidden" name="id" id="id">

                                                <div class="col-md-3">
                                                    <label for="a" class="form-label fw-bold">Item Code</label>
                                                    <input type="text" class="form-control" name="item_code"
                                                        id="item_code" required>
                                                    <div class="invalid-feedback">
                                                        Please enter item code.
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="item_name" class="form-label fw-bold">Item Name</label>
                                                    <input type="text" class="form-control" name="item_name"
                                                        id="item_name" required>
                                                    <div class="invalid-feedback">
                                                        Please enter item name.
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="price" class="form-label fw-bold">Price</label>
                                                    <input type="number" step="0.01" class="form-control" name="price"
                                                        id="price" required>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="item_cat" class="form-label fw-bold">Item Category
                                                        Type</label>
                                                    <select name="item_cat" id="item_cat" class="form-select" required>
                                                        <option value="">Select Item</option>
                                                        <option value="R">Restaurant</option>
                                                        <option value="O">Other</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please select a item category.
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-5">
                                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                        <button type="submit" class="btn btn-grd btn-grd-info px-5 fw-bold"
                                                            id="submitBtn">
                                                            Add Item
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-grd btn-grd-royal px-5 fw-bold" id="resetBtn">
                                                            Reset
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Item Code</th>
                                                            <th>Item Name</th>
                                                            <th>Price</th>
                                                            <th>Category</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($items as $index => $item)
                                                            <tr data-item="{{ json_encode($item) }}">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $item->item_code }}</td>
                                                                <td>{{ $item->item_name }}</td>
                                                                <td>{{ $item->price }}</td>
                                                                <td>{{ $item->item_cat }}</td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-center gap-3 flex-wrap">
                                                                        <button type="button"
                                                                            class="btn btn-grd btn-grd-danger px-4 delete-btn"
                                                                            data-id="{{ $item->id }}">Delete</button>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#example tbody tr');
            const resetBtn = document.getElementById('resetBtn');
            const form = document.getElementById('item-form');
            const submitBtn = document.getElementById('submitBtn');
            const itemCatSelect = document.getElementById('item_cat');
            const priceInput = document.getElementById('price');

            // Handle price field requirement based on category
            itemCatSelect.addEventListener('change', function() {
                if (this.value === 'R') {
                    priceInput.setAttribute('required', 'required');
                    priceInput.parentElement.querySelector('label').classList.add('required');
                } else {
                    priceInput.removeAttribute('required');
                    priceInput.parentElement.querySelector('label').classList.remove('required');
                }
            });

            resetBtn.addEventListener('click', function() {
                form.reset();
                document.getElementById('id').value = '';
                submitBtn.textContent = 'Add Item';
                submitBtn.classList.replace('btn-grd-warning', 'btn-grd-info');
                priceInput.removeAttribute('required');
            });

            rows.forEach(row => {
                row.addEventListener('click', function() {
                    const item = JSON.parse(this.dataset.item);
                    document.getElementById('id').value = item.id;
                    document.getElementById('item_code').value = item.item_code;
                    document.getElementById('item_name').value = item.item_name;
                    document.getElementById('price').value = item.price;
                    document.getElementById('item_cat').value = item.item_cat;

                    // Set price field requirement based on loaded item category
                    if (item.item_cat === 'R') {
                        priceInput.setAttribute('required', 'required');
                    } else {
                        priceInput.removeAttribute('required');
                    }

                    submitBtn.textContent = 'Update Item';
                    submitBtn.classList.replace('btn-grd-info', 'btn-grd-warning');
                });
            });
        });

        // Delete confirmation
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
                        <p class="fs-3 text-black fw-bold">Are you sure?</p>
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
                    // Create and submit form programmatically
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/items/${deleteId}/destroy`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    form.appendChild(csrfToken);
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
    </script>
@endsection
