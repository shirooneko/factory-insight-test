<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Insight</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="icon" href="{{ asset('icons/dark/factory-insight-minimize.png') }}" type="image/png"> <!-- Ganti dengan path yang sesuai jika menggunakan format lain -->
    <link rel="apple-touch-icon" href="{{ asset('icons/dark/factory-insight-minimize.png') }}"> <!-- Untuk perangkat Apple -->

    <!-- Sidebar CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    @include('partials.sidebar')

    <div class="content">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
