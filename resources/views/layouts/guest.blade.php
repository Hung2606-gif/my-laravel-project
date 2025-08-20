
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        

        {{-- Nội dung chính --}}
        <div class="flex-1 flex justify-center items-center p-6">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
