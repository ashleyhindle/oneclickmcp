<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Let\'s go') - AddMCP</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- SEO Tags -->
        <meta name="description" content="@yield('description', 'Generate one-click installation links for your MCP server across different IDEs and tools')">
        <meta property="og:title" content="@yield('og:title', 'One-Click MCP')">
        <meta property="og:description" content="@yield('og:description', 'Generate one-click installation links for your MCP server across different IDEs and tools')">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="https://addmcp.fancyog.com/og.png?v=1&title={{ urlencode(View::yieldContent('og:title', '')) }}&subtitle={{ urlencode(View::yieldContent('og:subtitle', '')) }}"/>
        <meta name="twitter:card" content="summary_large_image">


	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="AddMCP" />
	<link rel="manifest" href="/site.webmanifest" />

	@stack('head')
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
	@yield('content')

	@stack('scripts')
    </body>
</html>
