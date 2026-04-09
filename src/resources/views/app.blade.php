<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Newganizze') }}</title>

        @vite(['resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="min-h-screen bg-stone-950 text-stone-100 antialiased">
        @inertia
    </body>
</html>