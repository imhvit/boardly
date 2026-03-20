<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preload" href="/fonts/geist/Geist[wght].woff2" crossorigin="anonymous" as="font" type="font/woff2">
    <link rel="preload" href="/fonts/geist/Geist-Italic[wght].woff2" crossorigin="anonymous" as="font" type="font/woff2">
    <link rel="preload" href="/fonts/geist/GeistMono[wght].woff2" crossorigin="anonymous" as="font" type="font/woff2">
    <link rel="preload" href="/fonts/geist/GeistMono-Italic[wght].woff2" crossorigin="anonymous" as="font" type="font/woff2">

    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>