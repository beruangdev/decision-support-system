<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="layoutApp()" x-init="this.init" :class="color_theme">

<head>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ join(' ', explode('_', config('app.name', 'Laravel'))) }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- DATA TABLE --}}
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css" rel="stylesheet">
    {{-- DATA TABLE END --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

    {{-- <script>
        var manifest = @json(collect(json_decode(File::get(public_path('build/manifest.json'))))->toBase())

        let newManifest = {}
        Object.keys(manifest).forEach(key => {
            newManifest[key] = {
                file: manifest[key].file,
                isEntry: manifest[key].isEntry,
                src: manifest[key].src,
                url: `public/build/${manifest[key].file}`
            }
        });
        manifest = newManifest
    </script> --}}

    <script>
        const version = {{ File::lastModified(public_path('build/manifest.json')) ?? 0 }};
    </script>
    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
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

    {{-- DATA TABLE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script> --}}

    {{-- DT Buttons --}}
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
    {{-- DT Buttons --}}

    {{-- DATA TABLE END --}}
    <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
