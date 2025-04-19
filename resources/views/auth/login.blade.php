<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login RIDA FROZEN FOOD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- ICON WEB BROWSER --}}
    <link rel="icon" href="{{ asset('assets_landingpage/asset_tambahan/logo/icon.png') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/vendor/animate/animate.css') }}">
    <!-- Hamburgers -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/vendor/select2/select2.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/main.css') }}">
    <style>
        .input100 {
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-filled {
            border-color: #ff6426 !important;
            /* Warna border sesuai tombol */
            box-shadow: 0 0 5px #ff6426;
        }
    </style>
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="{{ asset('assets_login/images/img-01.png') }}" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <span class="login100-form-title">
                        LOGIN RIDA FROZEN FOOD
                    </span>

                    <!-- Email -->
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="email" name="email" placeholder="Email"
                            oninput="highlightInput(this)">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <!-- Password -->
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password"
                            oninput="highlightInput(this)">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <!-- Error Message -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Login Button -->
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <!-- Register Button -->
                    <div class="container-login100-form-btn">
                        <a href="{{ route('register') }}" class="login100-form-btn">
                            Register
                        </a>
                    </div>

                    <div class="text-right p-t-50">
                        <a class="txt2" href="{{ route('landingpage') }}">
                            Kembali ke Home Page
                        </a>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets_login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets_login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets_login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets_login/vendor/select2/select2.min.js') }}"></script>
    <!-- Tilt JS -->
    <script src="{{ asset('assets_login/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        });

        // Fungsi untuk mengubah warna border saat input diisi
        function highlightInput(input) {
            if (input.value.trim() !== '') {
                input.classList.add('input-filled');
            } else {
                input.classList.remove('input-filled');
            }
        }
    </script>
    <!-- Main JS -->
    <script src="{{ asset('assets_login/js/main.js') }}"></script>
</body>

</html>
