<!--start overlay-->
<div class="overlay btn-toggle"></div>
<!--end overlay-->

<!--start footer-->
<footer class="page-footer mt-auto">
    <p class="mb-0">Copyright © {{ date('Y') }}. All right reserved.</p>
</footer>
<!--end footer-->

<!--bootstrap js-->
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

<!--plugins-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>
<script>
    $(".data-attributes span").peity("donut")
</script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/dashboard1.js') }}"></script>
<script>
    new PerfectScrollbar(".user-list")
</script>

<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Initialize Toastr.js -->
@if (session()->has('toastr'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let toastrData = @json(session('toastr'));
            toastr[toastrData.type](toastrData.message);
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".time-picker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });

    $(".date-range").flatpickr({
        mode: "range",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });

    $("#calendar-inline").flatpickr({
        inline: true,
        mode: "range",
        altInput: false,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr) {
            if (selectedDates.length > 0) {
                let startDate = selectedDates[0];
                let endDate = selectedDates[1] || selectedDates[0];

                fetch('{{ route('dashboard.check-available-rooms') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            start_date: startDate.toISOString().split('T')[0],
                            end_date: endDate.toISOString().split('T')[0]
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateAvailableRoomsTable(data.availableRooms, dateStr);
                    });
            }
        }
    });
</script>

<script src="{{ asset('assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#image-uploadify').imageuploadify();
    })
</script>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

@yield('scripts')
</body>

</html>
