<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register RIDA FROZEN FOOD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- ICON WEB BROWSER --}}
<link rel="icon" href="{{ asset('assets_landingpage/asset_tambahan/logo/icon.png') }}" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/vendor/animate/animate.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_login/css/main.css') }}">
    <style>
        .input100 {
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-filled {
            border-color: #ff6426 !important;
            box-shadow: 0 0 5px #ff6426;
        }

        .img-preview {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            display: block;
            object-fit: cover;
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

                <form class="login100-form validate-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <span class="login100-form-title">
                        Register RIDA FROZEN FOOD
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Nama is required">
                        <input class="input100" type="text" name="name" placeholder="Nama" value="{{ old('name') }}" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Email is required: ex@abc.xyz">
                        <input class="input100" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Confirm Password is required">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100">
                        <input class="input100" type="number" name="umur" placeholder="Umur" value="{{ old('umur') }}" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100">
                        <select class="input100" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-venus-mars" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100">
                        <input type="text" class="input100" name="alamat" placeholder="Alamat" value="{{ old('alamat') }}" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-home" aria-hidden="true"></i>
                        </span>
                    </div>

                    <!-- Upload Gambar Profil -->
    <div class="wrap-input100">
        <label for="profile-pic">Foto Profil:</label>
        <input type="file" id="profile-pic" name="gambar_profil" accept="image/*" onchange="previewImage(event)">
        <img id="img-preview" class="img-preview" src="#" alt="Preview Foto" style="display:none;">
    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">Register</button>
                    </div>

                    <div class="text-right p-t-50">
                        <a class="txt2" href="{{ route('login') }}">
                            Sudah Punya Akun? Yuk Login Dulu !!
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
    <!-- Tilt JS -->
    <script src="{{ asset('assets_login/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        });

        function previewImage(event) {
            const imgPreview = document.getElementById('img-preview');
            const file = event.target.files[0];

            if (file) {
                imgPreview.style.display = 'block';
                imgPreview.src = URL.createObjectURL(file);
            } else {
                imgPreview.style.display = 'none';
                imgPreview.src = '';
            }
        }
    </script>
    <!-- Main JS -->
    <script src="{{ asset('assets_login/js/main.js') }}"></script>
</body>
</html>
