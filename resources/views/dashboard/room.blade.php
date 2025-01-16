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
                                            <form method="POST" action="{{ route('rooms.store') }}" class="row g-3">
                                                @csrf
                                                <input type="hidden" name="id" id="room_id">
                                                <div class="col-md-6">
                                                    <label for="room_no" class="form-label fw-bold">Room No</label>
                                                    <input type="text" class="form-control" id="room_no" name="room_no"
                                                        placeholder="Room No">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="room_type" class="form-label fw-bold">Room Type</label>
                                                    <select class="form-control" id="room_type" name="room_type">
                                                        <option value="">Select Room Type</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->cat_name }}">
                                                                {{ $category->cat_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mt-5">
                                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                        <button type="submit" id="submitBtn"
                                                            class="btn btn-grd btn-grd-info px-5 fw-bold">Add Room</button>
                                                        <button type="button" id="resetBtn"
                                                            class="btn btn-grd btn-grd-royal px-5 fw-bold">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="card mt-5">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Room No</th>
                                                            <th>Room Type</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($rooms as $index => $room)
                                                            <tr class="room-row" data-id="{{ $room->id }}"
                                                                data-room-no="{{ $room->room_no }}"
                                                                data-room-type="{{ $room->room_type }}">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $room->room_no }}</td>
                                                                <td>{{ $room->room_type }}</td>
                                                                <td>{{ $room->status }}</td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex justify-content-center gap-3 flex-wrap">
                                                                        <button type="button"
                                                                            class="btn btn-grd btn-grd-danger px-4 delete-btn"
                                                                            data-id="{{ $room->id }}">Delete</button>
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
        $(document).ready(function() {
            $('.room-row').on('click', function() {
                // Get data from the clicked row
                const id = $(this).data('id');
                const roomNo = $(this).data('room-no');
                const roomType = $(this).data('room-type');

                // Populate the form fields
                $('#room_id').val(id);
                $('#room_no').val(roomNo);
                $('#room_type').val(roomType);

                // Change button text to indicate edit mode
                $('#submitBtn').text('Update Room');
                $('#submitBtn').removeClass('btn-grd-info').addClass('btn-grd-warning');

            });

            // Reset Function
            $('#resetBtn').on('click', function() {
                // Clear form fields
                $('#room_id').val('');
                $('#room_no').val('');
                $('#room_type').val('');

                // Reset button text
                $('#submitBtn').text('Add Room');
                $('#submitBtn').removeClass('btn-grd-warning').addClass('btn-grd-info');
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
                        form.action = `/rooms/${deleteId}/destroy`;

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
        });
    </script>
@endsection
