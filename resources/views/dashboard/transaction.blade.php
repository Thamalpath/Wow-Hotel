@extends('layouts.app')

@section('content')
    <main class="main-wrapper min-vh-100">
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12 d-flex align-items-stretch">
                    <div class="card w-100 overflow-hidden rounded-4">
                        <div class="card-body position-relative p-4">
                            <div class="row">
                                <div class="col-6 col-xl-6">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <form action="{{ route('transactions.store.expense') }}" method="POST"
                                                class="row g-3 needs-validation" novalidate>
                                                @csrf
                                                <h2 class="mb-3">Expenses</h2>

                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Bill No</label>
                                                        <input type="text" class="form-control" name="bill_no" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the bill no.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold">Expenses Category</label>
                                                        <select name="category" class="form-select" required>
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->cat_name }}">
                                                                    {{ $category->cat_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select the expenses category.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-4">
                                                        <label for="amount" class="form-label fw-bold">Amount</label>
                                                        <input type="number" class="form-control" id="amount"
                                                            name="amount" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the amount.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-4">
                                                        <label for="handle_by" class="form-label fw-bold">Handle By</label>
                                                        <input type="text" class="form-control" id="handle_by"
                                                            name="handle_by" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the handler name.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 mb-4">
                                                        <label for="description"
                                                            class="form-label fw-bold">Description</label>
                                                        <input type="text" class="form-control" id="description"
                                                            name="description" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the description.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mt-5">
                                                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                            <button type="submit"
                                                                class="btn btn-grd btn-grd-info px-5 fw-bold">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Income Form -->
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('transactions.store.income') }}" method="POST"
                                                class="row g-3 needs-validation" novalidate>
                                                @csrf
                                                <h2 class="mb-3">Income</h2>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Amount</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="amount" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the amount.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold">Description</label>
                                                        <input type="text" class="form-control" name="description"
                                                            required>
                                                        <div class="invalid-feedback">
                                                            Please enter the description.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-5">
                                                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                            <button type="submit"
                                                                class="btn btn-grd btn-grd-info px-5 fw-bold">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transactions Table -->
                                <div class="col-12 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Type</th>
                                                            <th>Bill No</th>
                                                            <th>Category</th>
                                                            <th>Amount</th>
                                                            <th>Date</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($transactions as $transaction)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $transaction->status }}</td>
                                                                <td>{{ $transaction->bill_no }}</td>
                                                                <td>{{ $transaction->ex_cat }}</td>
                                                                <td>Rs. {{ number_format($transaction->amount, 2) }}</td>
                                                                <td>{{ $transaction->date->format('Y-m-d') }}</td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-center gap-3 flex-wrap">
                                                                        <button type="button"
                                                                            class="btn btn-grd btn-grd-danger px-4 delete-btn"
                                                                            data-id="{{ $transaction->id }}">Delete</button>
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
        document.querySelectorAll('.delete-btn').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const deleteId = this.getAttribute('data-id');

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
                    form.action = `/transactions/${deleteId}/destroy`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                });

                document.getElementById('noButton').addEventListener('click', function() {
                    document.body.removeChild(confirmationDialog);
                    toastr.error('Delete canceled');
                });
            });
        });
    </script>
@endsection
