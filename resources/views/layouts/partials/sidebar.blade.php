<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ asset('assets/images/logo.png') }}" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">BBQ HUB</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="{{ route('reservations.index') }}" class="{{ Request::is('reservation') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">book_online</i>
                    </div>
                    <div class="menu-title">Reservation</div>
                </a>
            </li>
            <li>
                <a href="{{ route('registration.index') }}" class="{{ Request::is('registration') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">how_to_reg</i>
                    </div>
                    <div class="menu-title">Registration</div>
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="{{ Request::is('category') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">widgets</i>
                    </div>
                    <div class="menu-title">Categories</div>
                </a>
            </li>
            <li>
                <a href="javascript:;"
                    class="has-arrow {{ Request::is('billing*') || Request::is('other-billing*') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">receipt_long</i>
                    </div>
                    <div class="menu-title">Billing</div>
                </a>
                <ul>
                    <li><a href="{{ route('billing.index') }}" class="{{ Request::is('billing') ? 'active' : '' }}"><i
                                class="material-icons-outlined">arrow_right</i>Item Billings</a>
                    </li>
                    <li><a href="{{ route('other-billing.index') }}"
                            class="{{ Request::is('other-billing') ? 'active' : '' }}"><i
                                class="material-icons-outlined">arrow_right</i>Other Billings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('rooms.index') }}" class="{{ Request::is('rooms') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">bed</i>
                    </div>
                    <div class="menu-title">Rooms</div>
                </a>
            </li>
            <li>
                <a href="{{ route('items.index') }}" class="{{ Request::is('items') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">restaurant</i>
                    </div>
                    <div class="menu-title">Items</div>
                </a>
            </li>
            <li>
                <a href="{{ route('staff.index') }}" class="{{ Request::is('staffs') ? 'active' : '' }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group_add</i></div>
                    <div class="menu-title">Staff</div>
                </a>
            </li>
            <li>
                <a href="#" data-bs-toggle="modal" data-bs-target="#rateModal">
                    <div class="parent-icon"><i class="material-icons-outlined">paid</i></div>
                    <div class="menu-title">Rate</div>
                </a>
            </li>
        </ul>

        <!--end navigation-->
        <ul class="metismenu" id="sidenav" style="position: absolute; bottom: 10px; width: 100%;">
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    <div class="parent-icon"><i class="material-icons-outlined">logout</i>
                    </div>
                    <div class="menu-title">Logout</div>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
        <!--end navigation-->
    </div>
</aside>

<!-- Bootstrap Modal -->
<div class="modal fade" id="rateModal" tabindex="-1" aria-labelledby="rateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0 py-2 bg-grd-deep-blue">
                <h5 class="modal-title fw-bold">Enter Password</h5>
                <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
                    <i class="material-icons-outlined">close</i>
                </a>
            </div>
            <div class="modal-body mt-3 mb-3">
                <input type="password" id="ratePassword" class="form-control" placeholder="Password">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-grd-deep-blue px-4 fw-bold text-white">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rateModal = document.querySelector('#rateModal');
        const ratePasswordInput = document.querySelector('#ratePassword');
        const rateSubmitButton = rateModal.querySelector('.btn-grd-deep-blue');

        rateSubmitButton.addEventListener('click', function() {
            const password = ratePasswordInput.value;
            const correctPassword = "Rate@123"; // Your hardcoded password here

            if (password === correctPassword) {
                window.location.href = "{{ route('rate.index') }}";
            } else {
                // Clear the input
                ratePasswordInput.value = '';

                // Show error message
                toastr.error('Invalid password');
            }
        });

        // Clear password when modal is hidden
        rateModal.addEventListener('hidden.bs.modal', function() {
            ratePasswordInput.value = '';
        });

        // Handle enter key press
        ratePasswordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                rateSubmitButton.click();
            }
        });
    });
</script>
