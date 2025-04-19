<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'DASHBOARD ADMIN | RFF')</title> <!-- Default title jika @section('title') tidak ada -->
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    @include('includes.admin.styles') <!-- Menggunakan include yang sesuai -->
</head>

<body>
    <div class="wrapper">
        <!-- Include sidebar -->
        @include('includes.admin.sidebar')
        <!-- end sidebar -->

        <!-- Main Content -->
        <!-- Tempatkan konten dinamis di sini -->
        @yield('content')
        @include('includes.admin.footer')
    </div>

 <!-- Menampilkan script tambahan -->
    {{-- @stack('addon-script') --}}
     
</body>
    <!-- Include scripts -->
    @include('includes.admin.scripts') 

</html>
