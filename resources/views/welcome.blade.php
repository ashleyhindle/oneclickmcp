@extends('layouts.app')

@section('title', 'Create MCP Setup Page')
@section('description', 'Generate one-click installation links for your MCP server. Support for Cursor, VS Code, Claude Code, and more.')

@section('content')
        <div class="w-full lg:max-w-2xl flex flex-col gap-y-4">
            <div class="text-center">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto">
                    <path d="M 13.045 47.331 L 50.659 12.066 L 50.496 71.367 M 30.009 49.633 L 86.955 49.597 L 53.774 87.934"
                          fill="none"
                          stroke-linecap="round"
                          style="stroke-linejoin: bevel; transform-box: fill-box; transform-origin: 51.9085% 48.7322%; stroke-width: 10.5px;"
                          class="stroke-blue-600 dark:stroke-blue-400">
                    </path>
                </svg>
                    <h1 class="text-4xl font-bold text-slate-700">addmcp</h1>
                    <p class="text-lg text-[#706f6c] dark:text-[#A1A09A]">
                        Create a guided installation page for your MCP server
                    </p>
            </div>


            <div class="bg-white dark:bg-[#161615] rounded-xl border border-[#e3e3e0] dark:border-[#3E3E3A] py-6 p-8 shadow-sm space-y-4">
                <h2 class="font-medium">Server details</h2>
                <form action="{{ route('generate') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="My MCP Server Name"
                            class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#1b1b18] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-[#A1A09A]"
                            required
                        />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <input
                            type="url"
                            id="url"
                            name="url"
                            value="{{ old('url') }}"
                            placeholder="https://your-server.com/mcp"
                            class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#1b1b18] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-[#A1A09A]"
                            required
                        />
                        <p class="text-xs text-gray-400">We recommend HTTP streaming</p>
                        @error('url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1b1b18] py-3 px-6 rounded-lg hover:bg-black dark:hover:bg-white transition-colors font-medium shadow-xs"
                    >
                        Create guided installation page
                    </button>
                </form>
            </div>

            <div class="p-4 bg-blue-300/4 dark:bg-blue-800/10 border border-blue-100 dark:border-blue-800/30 rounded-lg">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                        <p class="text-sm text-blue-600 dark:text-blue-300 gap-x-2 flex items-center">
                            Setup the MCP server for AddMCP.
                            <a href="{{ url('/addmcp/https://addmcp.fyi/mcp') }}" class="underline hover:no-underline font-medium">
                                Setup →
                            </a>
                        </p>
                </div>
            </div>
        </div>
@endsection
