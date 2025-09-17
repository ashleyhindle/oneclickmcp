@extends('layouts.app')

@section('title', 'Create MCP Setup Page')
@section('description', 'Generate one-click installation links for your MCP server. Support for Cursor, VS Code, Claude Code, and more.')

@section('content')
        <div class="w-full lg:max-w-2xl">
            <div class="text-center mb-8">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto">
                    <path d="M 13.045 47.331 L 50.659 12.066 L 50.496 71.367 M 30.009 49.633 L 86.955 49.597 L 53.774 87.934"
                          fill="none"
                          stroke-linecap="round"
                          style="stroke-linejoin: bevel; transform-box: fill-box; transform-origin: 51.9085% 48.7322%; stroke-width: 10.5px;"
                          class="stroke-blue-600 dark:stroke-blue-400">
                    </path>
                </svg>
            </div>

            <header class="text-center mb-12">
                <h1 class="text-4xl font-bold mb-4">Guided MCP Install</h1>
                <p class="text-lg text-[#706f6c] dark:text-[#A1A09A]">
                    Generate installation instructions for your MCP server 
                </p>
            </header>

            <div class="bg-white dark:bg-[#161615] rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] p-8 shadow-sm">
                <form action="{{ route('generate') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">
                            Server Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="my-mcp-server"
                            class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#1b1b18] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-[#A1A09A]"
                            required
                        />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="url" class="block text-sm font-medium mb-2">
                            Server URL
                        </label>
                        <input
                            type="url"
                            id="url"
                            name="url"
                            value="{{ old('url') }}"
                            placeholder="https://your-server.com/mcp"
                            class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#1b1b18] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-[#A1A09A]"
                            required
                        />
                        @error('url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1b1b18] py-3 px-6 rounded-lg hover:bg-black dark:hover:bg-white transition-colors font-medium shadow-xs"
                    >
                        Generate Installation Links
                    </button>
                </form>
            </div>

            @if ($errors->any())
                <div class="mt-6 bg-[#fff2f2] dark:bg-[#1D0002] border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="text-red-400">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                Please fix the following errors:
                            </h3>
                            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800/30 rounded-lg">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm">
                        <p class="text-blue-900 dark:text-blue-100 font-medium">Want to add AddMCP to your MCP client?</p>
                        <p class="text-blue-700 dark:text-blue-300 mt-1">
                            Get instant setup instructions for the AddMCP server itself.
                            <a href="{{ url('/addmcp/https://addmcp.fyi/mcp') }}" class="underline hover:no-underline font-medium">
                                Install AddMCP →
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
@endsection
