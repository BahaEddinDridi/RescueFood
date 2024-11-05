<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin Panel')</title>   
    <link href="{{ asset('backoffice/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div id="app">
        @include('admin.partials.navbar')

        <div class="container-fluid">
            <div class="row">
                @include('admin.partials.sidebar')

                <main class="content">
                    @yield('content')
                </main>
            </div>
        </div>

        @include('admin.partials.footer')
    </div>

    <!-- Scripts (include at the bottom for performance) -->
    @if (app()->environment('local'))
        <script src="{{ asset('backoffice/js/app.js.map') }}"></script>
    @endif
    <script src="{{ asset('backoffice/js/app.js') }}"></script>
</body>
</html>
