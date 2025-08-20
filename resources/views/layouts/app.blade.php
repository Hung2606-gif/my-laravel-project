<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    

    <!-- Scripts & Styles -->
     
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
  
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Header --}}
        @hasSection('header')
            <header class="bg-white shadow">
                <div class="w-full px-4 sm:px-6 lg:px-8 py-1">
                    @yield('header')
                </div>
            </header>
        @endif

        {{-- Flash Messages --}}
        @if (session('status'))
            <div class="max-w-full mx-auto p-4 text-green-600 bg-green-100 rounded-md shadow mt-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="max-w-full mx-auto p-4 text-red-600 bg-red-100 rounded-md shadow mt-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="pt-24 px-4">
            @yield('content')
         

            {{ $slot ?? '' }}
        </main>
    </div>
     {{-- ✅ Thêm jQuery CDN ở đây --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- ✅ Sau đó mới gọi @yield('scripts') --}}
    @yield('scripts')
</body>
</html>




