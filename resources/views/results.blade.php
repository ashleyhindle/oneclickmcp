<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Installation Links</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] p-6 lg:p-8 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <header class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-2">Installation Links Generated</h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A]">
                    Server: <strong>{{ $name }}</strong> • URL: <strong>{{ $url }}</strong>
                </p>
                <a href="{{ route('home') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-700 underline">
                    ← Generate another
                </a>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Deep Links -->
                <div class="bg-white dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-6">
                    <h2 class="text-xl font-semibold mb-4">One-Click Installation</h2>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-[#f8f9fa] dark:bg-[#1b1b18] rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Cursor</span>
                            </div>
                            <a href="{{ $cursorUrl }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Install in Cursor
                            </a>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-[#f8f9fa] dark:bg-[#1b1b18] rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">VS Code</span>
                            </div>
                            <a href="{{ $vscodeUrl }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Install in VS Code
                            </a>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-[#f8f9fa] dark:bg-[#1b1b18] rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">VS Code Insiders</span>
                            </div>
                            <a href="{{ $vscodeInsidersUrl }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Install in Insiders
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Command Line -->
                <div class="bg-white dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-6">
                    <h2 class="text-xl font-semibold mb-4">Command Line</h2>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] mb-2">Claude Code</h3>
                            <div class="bg-[#1b1b18] dark:bg-black rounded-lg p-4 text-white font-mono text-sm relative group">
                                <code id="claude-command">{{ $claudeCommand }}</code>
                                <button
                                    onclick="copyToClipboard('claude-command')"
                                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-700 hover:bg-gray-600 px-2 py-1 rounded text-xs"
                                    title="Copy to clipboard"
                                >
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Configuration -->
            <div class="mt-8 bg-white dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-6">
                <h2 class="text-xl font-semibold mb-4">Manual Configuration</h2>
                <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                    For tools that don't support deep links, you can manually add this JSON configuration:
                </p>

                <div class="bg-[#1b1b18] dark:bg-black rounded-lg p-4 text-white font-mono text-sm relative group overflow-auto">
                    <pre id="config-json">{{ $configJson }}</pre>
                    <button
                        onclick="copyToClipboard('config-json')"
                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-700 hover:bg-gray-600 px-2 py-1 rounded text-xs"
                        title="Copy to clipboard"
                    >
                        Copy
                    </button>
                </div>
            </div>

            <!-- URLs for debugging -->
            <details class="mt-8">
                <summary class="cursor-pointer text-[#706f6c] dark:text-[#A1A09A] text-sm">Show raw URLs (for debugging)</summary>
                <div class="mt-4 space-y-2 text-xs font-mono break-all">
                    <div>
                        <strong>Cursor:</strong>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">{{ $cursorUrl }}</span>
                    </div>
                    <div>
                        <strong>VS Code:</strong>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">{{ $vscodeUrl }}</span>
                    </div>
                    <div>
                        <strong>VS Code Insiders:</strong>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">{{ $vscodeInsidersUrl }}</span>
                    </div>
                </div>
            </details>
        </div>

        <script>
            function copyToClipboard(elementId) {
                const element = document.getElementById(elementId);
                const text = element.textContent;

                navigator.clipboard.writeText(text).then(function() {
                    // Show success feedback
                    const button = element.nextElementSibling;
                    const originalText = button.textContent;
                    button.textContent = 'Copied!';
                    button.classList.remove('bg-gray-700', 'hover:bg-gray-600');
                    button.classList.add('bg-green-600');

                    setTimeout(function() {
                        button.textContent = originalText;
                        button.classList.add('bg-gray-700', 'hover:bg-gray-600');
                        button.classList.remove('bg-green-600');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Failed to copy: ', err);
                });
            }
        </script>
    </body>
</html>