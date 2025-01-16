<!doctype html>
<html lang="en" data-bs-theme="blue-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BBQ HUB') }} | Sign In</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/png">
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>

    <!--plugins-->
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/metisMenu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/mm-vertical.css') }}">
    <!--bootstrap css-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/main.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/blue-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('sass/responsive.css') }}" rel="stylesheet">
</head>

<body>
    <div class="auth-basic-wrapper d-flex align-items-center justify-content-center">
        <div class="container-fluid my-5 my-lg-0">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
                    <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
                        <div class="card-body pe-5 ps-5 pt-0 pb-0">
                            <img src="{{ asset('assets/images/logo.png') }}" class="mb-4 mt-5" width="145"
                                alt="">
                            <h2 class="fw-bold">BBQ HUB</h2>
                            <h4>Ella Wallawaya</h4>
                            <h5 class="mb-0">Sign In</h5>

                            <!-- Previous head section remains same -->

                            <div class="form-body my-5">
                                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                    @csrf

                                    <div class="col-12 mb-3">
                                        <label for="username" class="form-label fw-bold">Username</label>
                                        <input type="text"
                                            class="form-control @error('username') is-invalid @enderror" id="username"
                                            name="username" placeholder="Enter Username" value="{{ old('username') }}">
                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="password1" class="form-label fw-bold">Password 1</label>
                                        <div class="input-group show_hide_password">
                                            <input type="password"
                                                class="form-control @error('password1') is-invalid @enderror"
                                                id="password1" name="password1" placeholder="Enter Password 1">
                                            <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                    class="bi bi-eye-slash-fill"></i></a>
                                            @error('password1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="password2" class="form-label fw-bold">Password 2</label>
                                        <div class="input-group show_hide_password">
                                            <input type="password"
                                                class="form-control @error('password2') is-invalid @enderror"
                                                id="password2" name="password2" placeholder="Enter Password 2">
                                            <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                    class="bi bi-eye-slash-fill"></i></a>
                                            @error('password2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit"
                                                class="btn btn-grd-primary text-white fw-bold mt-3">Login</button>
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

    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".show_hide_password a").on('click', function(event) {
                event.preventDefault();
                let passwordInput = $(this).closest('.show_hide_password').find('input');
                let icon = $(this).find('i');

                if (passwordInput.attr("type") == "text") {
                    passwordInput.attr('type', 'password');
                    icon.addClass("bi-eye-slash-fill");
                    icon.removeClass("bi-eye-fill");
                } else {
                    passwordInput.attr('type', 'text');
                    icon.removeClass("bi-eye-slash-fill");
                    icon.addClass("bi-eye-fill");
                }
            });
        });
    </script>

</body>

</html>
