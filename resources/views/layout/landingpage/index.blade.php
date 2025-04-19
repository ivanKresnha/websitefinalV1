<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LANDINGPAGE | RFF')</title> <!-- Tambahkan judul default -->

    <!-- Tambahkan Style -->
    @stack('prepend-style') <!-- Untuk gaya tambahan sebelum styles -->
    @include('includes.landingpage.styles') <!-- Styles utama -->
    @stack('addon-style') <!-- Untuk gaya tambahan setelah styles -->
</head>

<body>
    <!-- Header -->
    @include('includes.landingpage.header')
 

    <!-- Konten Utama -->
    <main>
        @yield('container')
    </main> 

    <!-- Footer -->
    @include('includes.landingpage.footer')

    <!-- Script -->
    @stack('prepend-script') <!-- Untuk script tambahan sebelum scripts -->
    @include('includes.landingpage.scripts') <!-- Scripts utama -->
    @stack('addon-script') <!-- Untuk script tambahan setelah scripts -->

</body>
</html>
