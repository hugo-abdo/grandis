<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Grandis') }}</title>

       <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">	        

        <!-- Scripts -->
        @routes
        <script type="module" src="http://localhost:3000/@vite/client"></script>
    </head>
    <body class="font-sans antialiased duration-200 scroll-groadis scrollbar-thin  scrollbar-thumb-rounded-full scrollbar-track-rounded-full scrollbar-roun scrollbar-track-gray-200 dark:scrollbar-track-groadis-darker scrollbar-thumb-gray-400 dark:scrollbar-thumb-groadis-dark">
        @inertia

        @env ('local')
           <script type="module" src="http://localhost:3000/resources/js/app.js"></script>
        @endenv
    </body>
</html>
