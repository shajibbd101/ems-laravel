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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex">

        <!-- Sidebar -->
        <div style="width:200px; background:#333; color:white; min-height:100vh; padding:20px;">
            <h3>EMS</h3>
            <a href="/dashboard" style="color:white;display:block;margin:10px 0;">Dashboard</a>
            <a href="/employees" style="color:white;display:block;margin:10px 0;">Employees</a>
        </div>

        <!-- Main Content -->
        <div style="flex:1;">
            {{ $slot }}
        </div>

    </body>
</html>
