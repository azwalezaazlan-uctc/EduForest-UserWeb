<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EduForest') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div style="
        min-height: 100vh;
        background-image:
            linear-gradient(rgba(0,0,0,0.35), rgba(0,0,0,0.35)),
            url('https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/6170282320066187830.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    ">
        {{ $slot }}
    </div>
</body>
</html>