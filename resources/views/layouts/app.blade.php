<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- DATA TABLE --}}
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
    {{-- DATA TABLE END --}}

    @php
        $route_names = [];
        foreach (Route::getRoutes()->getRoutes() as $route) {
            $action = $route->getAction();
            if (array_key_exists('as', $action)) {
                $route_names[$action['as']] = [
                    'name' => $action['as'],
                    'uri' => $route->uri,
                    'methods' => $route->methods,
                ];
            }
        }
    @endphp
    <script>
        var csrf = "{{ csrf_token() }}"
        var routes = @json($route_names)
    </script>

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        {{-- @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- DATA TABLE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    {{-- DATA TABLE END --}}
    <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>
    @stack('script')
</body>

</html>
