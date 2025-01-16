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
                                            <form id="staffForm" method="POST" action="{{ route('staff.store') }}"
                                                class="row g-3 needs-validation" novalidate>
                                                @csrf
                                                <input type="hidden" name="id" id="id">

                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Known Name</label>
                                                        <input type="text" class="form-control" name="known_name"
                                                            id="known_name" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the known name.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" class="form-control" name="full_name"
                                                            id="full_name" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the full name.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Contact No</label>
                                                        <input type="text" class="form-control" name="contact_no"
                                                            id="contact_no" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the contact no.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-4">
                                                        <label class="form-label">Address</label>
                                                        <input type="text" class="form-control" name="address"
                                                            id="address" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the address.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label class="form-label">Department</label>
                                                        <select class="form-select" name="department" id="department"
                                                            required>
                                                            <option value="">Select Department</option>
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department }}">{{ $department }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select a department.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="id_no" class="form-label">ID No</label>
                                                        <input type="text" class="form-control" name="id_no"
                                                            id="id_no" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the ID No.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="religion" class="form-label">Religion</label>
                                                        <input type="text" class="form-control" name="religion"
                                                            id="religion" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the religion.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="blood_group" class="form-label">Blood Group</label>
                                                        <input type="text" class="form-control" name="blood_group"
                                                            id="blood_group" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the blood group.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-4">
                                                        <label for="em_contact_no" class="form-label">Emergency Contact
                                                            No</label>
                                                        <input type="text" class="form-control" name="em_contact_no"
                                                            id="em_contact_no" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the emergency contact no.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="account_no" class="form-label">Account No</label>
                                                        <input type="text" class="form-control" name="account_no"
                                                            id="account_no" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the account no.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="account_name" class="form-label">Account Name</label>
                                                        <input type="text" class="form-control" name="account_name"
                                                            id="account_name" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the account name.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="bank" class="form-label">Bank</label>
                                                        <input type="text" class="form-control" name="bank"
                                                            id="bank" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the bank.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mb-4">
                                                        <label for="branch" class="form-label">Branch</label>
                                                        <input type="text" class="form-control" name="branch"
                                                            id="branch" required>
                                                        <div class="invalid-feedback">
                                                            Please enter the branch.
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <label for="special_skills" class="form-label">Special
                                                            Skills</label>
                                                        <input type="text" class="form-control" name="special_skills"
                                                            id="special_skills">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="pre_worked" class="form-label">Previously
                                                            Worked</label>
                                                        <input type="text" class="form-control" name="pre_worked"
                                                            id="pre_worked">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="joined_date" class="form-label">Joined Date</label>
                                                        <input type="date" class="form-control" name="joined_date"
                                                            id="joined_date" required>
                                                        <div class="invalid-feedback">
                                                            Please select a joined date.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="currently_employed" class="form-label">Currently
                                                            Employed</label>
                                                        <select name="currently_employed" id="currently_employed"
                                                            class="form-select" required>
                                                            <option value="">Select</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Please select the type.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="resign_date" class="form-label">Resign Date</label>
                                                        <input type="date" class="form-control" id="resign_date"
                                                            name="resign_date">
                                                    </div>
                                                    <div class="col-md-3 mb-4">
                                                        <label for="reason" class="form-label">Reason</label>
                                                        <input type="text" class="form-control" name="reason"
                                                            id="reason">
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <label for="comments" class="form-label">Comments</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4"></textarea>
                                                    </div>

                                                    <div class="col-md-12 mt-5">
                                                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                            <button type="submit" id="submit" name="submit"
                                                                class="btn btn-grd btn-grd-info px-5 fw-bold"
                                                                style="display: block;">Submit</button>
                                                            <button type="submit" id="update"
                                                                class="btn btn-grd btn-grd-warning px-5 py-2 fw-bold"
                                                                style="display: none;">Update</button>
                                                            <button type="reset"
                                                                class="btn btn-grd btn-grd-royal px-5 fw-bold">Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-xl-12 mt-3">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-start gap-3 flex-wrap">
                                            <button type="button" id="upload"
                                                class="btn btn-grd btn-grd-primary px-4 fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#FullScreenModal">Image
                                                Upload</button>
                                        </div>
                                    </div>
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Full Name</th>
                                                            <th>Image</th>
                                                            <th>Contact No</th>
                                                            <th>Address</th>
                                                            <th>Department</th>
                                                            <th>NIC</th>
                                                            <th>Religion</th>
                                                            <th>Blood Group</th>
                                                            <th>Emergency Contact No</th>
                                                            <th>Bank Details</th>
                                                            <th>Special Skills</th>
                                                            <th>Pre Worked</th>
                                                            <th>Joined Date</th>
                                                            <th>Currently Employed</th>
                                                            <th>Resign Date</th>
                                                            <th>Reason</th>
                                                            <th>Comments</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($staff as $index => $member)
                                                            <tr data-id="{{ $member->id }}">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $member->full_name }}</td>

                                                                <td>
                                                                    @if (!empty($member->image))
                                                                        <div class="staff-image-container">
                                                                            <img src="{{ asset('storage/staff/' . $member->image) }}"
                                                                                alt="Staff Image" class="img-thumbnail"
                                                                                style="max-width: 100px; max-height: 100px;">
                                                                            <img src="{{ asset('storage/staff/' . $member->image) }}"
                                                                                alt="Staff Image"
                                                                                class="staff-image-zoom">
                                                                        </div>
                                                                    @endif
                                                                </td>

                                                                <td>{{ $member->contact_no }}</td>
                                                                <td>{{ $member->address }}</td>
                                                                <td>{{ $member->department }}</td>
                                                                <td>{{ $member->id_no }}</td>
                                                                <td>{{ $member->religion }}</td>
                                                                <td>{{ $member->blood_group }}</td>
                                                                <td>{{ $member->em_contact_no }}</td>
                                                                <td>
                                                                    {{ $member->account_no }}<br>
                                                                    {{ $member->account_name }}<br>
                                                                    {{ $member->bank }}<br>
                                                                    {{ $member->branch }}
                                                                </td>
                                                                <td>{{ $member->special_skills }}</td>
                                                                <td>{{ $member->pre_worked }}</td>
                                                                <td>{{ date('Y-m-d', strtotime($member->joined_date)) }}
                                                                </td>
                                                                </td>
                                                                <td>{{ $member->currently_employed }}</td>
                                                                <td>{{ $member->resign_date }}
                                                                </td>
                                                                <td>{{ $member->reason }}</td>
                                                                <td>{{ $member->comments }}</td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-center gap-3 flex-wrap">
                                                                        <button type="button"
                                                                            class="btn btn-grd btn-grd-danger px-4 delete-btn"
                                                                            data-id="{{ $member->id }}">Delete</button>
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
                                                <input id="image-uploadify" type="file" accept="image/*" multiple>
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
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const staffForm = document.getElementById('staffForm');
            const submitBtn = document.getElementById('submit');
            const updateBtn = document.getElementById('update');

            function populateForm(data) {
                for (const field in data) {
                    const input = document.getElementById(field);
                    if (input) {
                        input.value = data[field];
                    }
                }

                submitBtn.style.display = 'none';
                updateBtn.style.display = 'block';

                // Update form action and method
                staffForm.action = `/staff/${data.id}`;

                // Add method spoofing for PUT
                let methodInput = document.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    staffForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';

                staffForm.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            // Table row click handler
            document.querySelectorAll('table#example tbody tr').forEach(row => {
                row.addEventListener('click', function() {
                    const staffId = this.getAttribute('data-id');
                    if (!staffId) return;

                    fetch(`/staff/${staffId}/edit`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            populateForm(data);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('Error fetching staff data');
                        });
                });
            });

            // Reset form handler
            staffForm.addEventListener('reset', function() {
                submitBtn.style.display = 'block';
                updateBtn.style.display = 'none';

                // Reset form action and method
                staffForm.action = "{{ route('staff.store') }}";
                const methodInput = document.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
            });

            // Form validation
            staffForm.addEventListener('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                this.classList.add('was-validated');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedStaffId = null;

            // Add click event to table rows
            document.querySelectorAll('table#example tbody tr').forEach(row => {
                row.addEventListener('click', function() {
                    selectedStaffId = this.getAttribute('data-id');
                    // Highlight the selected row
                    document.querySelectorAll('table#example tbody tr').forEach(r => r.classList
                        .remove('selected'));
                    this.classList.add('selected');
                });
            });

            // Upload button click handler
            document.getElementById('upload').addEventListener('click', function() {
                if (!selectedStaffId) {
                    toastr.error('Please select a staff member first.');
                    return;
                }
                // Modal will open automatically due to data-bs-toggle attribute
            });

            // Save button click handler
            document.getElementById('save').addEventListener('click', function() {
                const fileInput = document.getElementById('image-uploadify');
                if (fileInput.files.length === 0) {
                    toastr.error('Please select an image to upload.');
                    return;
                }

                const formData = new FormData();
                formData.append('image', fileInput.files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                fetch(`/staff/upload-image/${selectedStaffId}`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.type === 'success') {
                            document.getElementById('FullScreenModal').querySelector(
                                '[data-bs-dismiss="modal"]').click();
                            toastr.success(result.message);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            toastr.error(result.message);
                        }
                    })
                    .catch(error => {
                        toastr.error('Error uploading image');
                        console.error('Error:', error);
                    });
            });
        });
    </script>

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
                    form.action = `/staff/${deleteId}/destroy`;

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
