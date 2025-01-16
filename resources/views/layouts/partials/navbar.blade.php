<nav class="navbar navbar-expand align-items-center gap-4">
    <div class="btn-toggle">
        <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
    </div>
    <div class="search-bar flex-grow-1">
        <div class="position-relative">
            <div class="card-body search-content" style="display: none;">
            </div>
        </div>
    </div>

    <ul class="navbar-nav gap-1 nav-right-links align-items-center">
        <li class="nav-item dropdown" style="display: none;">
            <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
                <div class="notify-list">

                </div>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a href="javascript:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                <img src="{{ asset('assets/images/user.png') }}" class="rounded-circle p-1 border" width="45"
                    height="45" alt="User Avatar">
            </a>
            <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                <a class="dropdown-item gap-2 py-2" href="javascript:;">
                    <div class="text-center">
                        <img src="{{ asset('assets/images/user.png') }}" class="rounded-circle p-1 shadow mb-3"
                            width="90" height="90" alt="User Avatar">
                        <h5 class="user-name mb-0 fw-bold">Hello, {{ Auth::user()->username }}</h5>
                    </div>
                </a>
                <hr class="dropdown-divider">
                <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <i class="material-icons-outlined">power_settings_new</i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
