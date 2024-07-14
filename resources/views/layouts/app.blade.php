<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('img/logo-removebg.png') }}" type="image/x-icon">


    @include('layouts.additional.styles')

    @stack('css')

</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('layouts.sidebar')
        @yield('content')
    </div>

    @include('layouts.additional.script')

    @stack('js')
</body>

</html>
