<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Grandis') }}</title>

       <link rel="stylesheet" href="/css/line-awesome.min.css">	
        <!-- Scripts -->
        @routes
        @vite
    </head>
    <body class="font-sans scrollbar-thin  scrollbar-thumb-rounded-full scrollbar-track-rounded-full scrollbar-track-gray-200 dark:scrollbar-track-groadis-darker scrollbar-thumb-groadis dark:scrollbar-thumb-groadis-dark bg-gray-200 duration-200 dark:bg-groadis-darker ">
        @inertia
    </body>
</html>
