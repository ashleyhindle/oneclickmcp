@extends('layouts.app')

@section('title', 'Add the ' . $name . ' MCP')
@section('description', 'Install the ' . $name . ' MCP server with one click. Support for Cursor, VS Code, Claude Code, and more.')
@section('og:title', 'Setup the \'' . $name . '\' MCP')
@section('og:subtitle', 'Guided installation for your favorite AI agent')
@section('og:description', 'Install the ' . $name . ' MCP server with one click in your favorite AI agent.')

@section('content')
        <div class="w-full max-w-4xl px-4 sm:px-6 lg:px-8 py-3">
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-bold mb-3">Add the '{{ $name }}' MCP</h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A]">Guided installation for your favorite AI agent</p>
            </div>

            <div data-slot="card" class="bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] flex flex-col gap-6 border border-[#e3e3e0] dark:border-[#3E3E3A] py-6 shadow-sm rounded-xl">
                <div data-slot="card-header" class="flex flex-col gap-1.5 px-6">
                    <div data-slot="card-title" class="leading-none font-semibold text-xl">Quick Installation</div>
                    <div class="text-sm text-[#706f6c] dark:text-[#A1A09A] break-all">{{ $url }}</div>
                </div>

                <div data-slot="card-content" class="px-6 space-y-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ $cursorUrl }}"
                           class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1b1b18] shadow-xs hover:bg-black dark:hover:bg-white h-9 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" x2="12" y1="15" y2="3"></line>
                            </svg>
                            Add to Cursor
                        </a>

                        <a href="{{ $vscodeUrl }}"
                           class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 bg-[#f4f4f3] dark:bg-[#262625] text-[#1b1b18] dark:text-[#EDEDEC] shadow-xs hover:bg-[#e8e8e7] dark:hover:bg-[#363635] h-9 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" x2="12" y1="15" y2="3"></line>
                            </svg>
                            Add to VS Code
                        </a>

                        <button type="button"
                                onclick="toggleSection('claude-section', this)"
                                id="claude-button"
                                class="gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 outline-none h-9 px-4 py-2 bg-[#c6613f] text-white hover:bg-[#cb6644] hover:text-white flex items-center justify-center gap-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <polyline points="4 17 10 11 4 5"></polyline>
                                <line x1="12" x2="20" y1="19" y2="19"></line>
                            </svg>
                            Add to Claude Code
                        </button>

                        <button type="button"
                                onclick="toggleSection('other-section', this)"
                                id="other-button"
                                class="gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 outline-none bg-[#f4f4f3] dark:bg-[#262625] text-[#1b1b18] dark:text-[#EDEDEC] shadow-xs hover:bg-[#e8e8e7] dark:hover:bg-[#363635] h-9 px-4 py-2 flex items-center justify-center gap-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <line x1="12" x2="18" y1="18" y2="12"></line>
                                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect>
                                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                            </svg>
                            Add to Other Agents
                        </button>
                    </div>

                    <div id="claude-section" class="transition-all duration-200 overflow-hidden opacity-0 max-h-0 -mt-2" aria-hidden="true">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <code class="text-xs bg-[#f9f9f8] dark:bg-[#1b1b18] p-3 rounded border border-[#e3e3e0] dark:border-[#3E3E3A] font-mono break-all leading-relaxed flex-1">{{ $claudeCommand }}</code>
                            <button type="button"
                                    onclick="copyToClipboard('{{ $claudeCommand }}', this)"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] shadow-xs hover:bg-[#f9f9f8] dark:hover:bg-[#1e1e1d] text-[#1b1b18] dark:text-[#EDEDEC] h-8 rounded-md px-3 sm:shrink-0 w-full sm:w-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect>
                                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                                </svg>
                                Copy
                            </button>
                        </div>
                    </div>

                    <div id="other-section" class="transition-all duration-200 overflow-hidden opacity-0 max-h-0 -mt-2" aria-hidden="true">
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <code class="text-xs bg-[#f9f9f8] dark:bg-[#1b1b18] p-3 rounded border border-[#e3e3e0] dark:border-[#3E3E3A] font-mono break-all leading-relaxed flex-1">{{ $url }}</code>
                                <button type="button"
                                        onclick="copyToClipboard('{{ $url }}', this)"
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] shadow-xs hover:bg-[#f9f9f8] dark:hover:bg-[#1e1e1d] text-[#1b1b18] dark:text-[#EDEDEC] h-8 rounded-md px-3 sm:shrink-0 w-full sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                                        <rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect>
                                        <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                                    </svg>
                                    Copy
                                </button>
                            </div>

                            <div class="mt-4 hidden">
                                <h4 class="text-sm font-medium mb-2">Manual Configuration</h4>
                                <pre class="text-xs bg-[#f9f9f8] dark:bg-[#1b1b18] p-3 rounded border border-[#e3e3e0] dark:border-[#3E3E3A] font-mono overflow-x-auto">{{ $configJson }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div data-slot="card" class="bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] flex flex-col gap-6 border border-[#e3e3e0] dark:border-[#3E3E3A] py-6 shadow-sm rounded-xl mt-6">
                <div data-slot="card-header" class="flex flex-col gap-1.5 px-6">
                    <div data-slot="card-title" class="leading-none font-semibold text-xl">Share this server</div>
                    <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Help others discover the {{ $name }} MCP server</div>
                </div>

                <div data-slot="card-content" class="px-6 space-y-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button"
                                onclick="copyShareLink(this)"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1b1b18] shadow-xs hover:bg-black dark:hover:bg-white h-9 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                            </svg>
                            Copy AddMCP Link
                        </button>

                        <a href="https://twitter.com/intent/tweet?text={{ urlencode('Install ' . $name . ' MCP with one click: ' . url()->current()) }}"
                           target="_blank"
                           class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 bg-[#f4f4f3] dark:bg-[#262625] text-[#1b1b18] dark:text-[#EDEDEC] shadow-xs hover:bg-[#e8e8e7] dark:hover:bg-[#363635] h-9 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                            </svg>
                            Share to X
                        </a>

                        <a href="https://bsky.app/intent/compose?text={{ urlencode('Install ' . $name . ' MCP with one click: ' . url()->current()) }}"
                           target="_blank"
                           class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 bg-[#f4f4f3] dark:bg-[#262625] text-[#1b1b18] dark:text-[#EDEDEC] shadow-xs hover:bg-[#e8e8e7] dark:hover:bg-[#363635] h-9 px-4 py-2">
                            <svg width="24" height="24" viewBox="0 0 600 530" xmlns="http://www.w3.org/2000/svg" class="size-4 opacity-60">
                                <path d="m135.72 44.03c66.496 49.921 138.02 151.14 164.28 205.46 26.262-54.316 97.782-155.54 164.28-205.46 47.98-36.021 125.72-63.892 125.72 24.795 0 17.712-10.155 148.79-16.111 170.07-20.703 73.984-96.144 92.854-163.25 81.433 117.3 19.964 147.14 86.092 82.697 152.22-122.39 125.59-175.91-31.511-189.63-71.766-2.514-7.3797-3.6904-10.832-3.7077-7.8964-0.0174-2.9357-1.1937 0.51669-3.7077 7.8964-13.714 40.255-67.233 197.36-189.63 71.766-64.444-66.128-34.605-132.26 82.697-152.22-67.108 11.421-142.55-7.4491-163.25-81.433-5.9562-21.282-16.111-152.36-16.111-170.07 0-88.687 77.742-60.816 125.72-24.795z" fill="currentColor"/>
                            </svg>
                            Share to Bluesky
                        </a>

                        <button type="button"
                                onclick="shareNative()"
                                class="sm:hidden inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-[color,box-shadow] disabled:pointer-events-none disabled:opacity-50 outline-none focus-visible:ring-2 focus-visible:ring-blue-500 bg-[#f4f4f3] dark:bg-[#262625] text-[#1b1b18] dark:text-[#EDEDEC] shadow-xs hover:bg-[#e8e8e7] dark:hover:bg-[#363635] h-9 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                                <circle cx="18" cy="5" r="3"></circle>
                                <circle cx="6" cy="12" r="3"></circle>
                                <circle cx="18" cy="19" r="3"></circle>
                                <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line>
                                <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>
                            </svg>
                            Share
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                        <path d="M 13.045 47.331 L 50.659 12.066 L 50.496 71.367 M 30.009 49.633 L 86.955 49.597 L 53.774 87.934"
                              fill="none"
                              stroke-linecap="round"
                              style="stroke-linejoin: bevel; transform-box: fill-box; transform-origin: 51.9085% 48.7322%; stroke-width: 10.5px;"
                              class="stroke-[#706f6c] dark:stroke-[#A1A09A]">
                        </path>
                    </svg>
                </div>
                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    Powered by <a href="{{ route('home') }}" class="underline hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">addmcp.fyi</a>
                </p>
            </div>
        </div>
@endsection

@push('scripts')
        <script>
            function toggleSection(sectionId, button) {
                const section = document.getElementById(sectionId);
                const isHidden = section.classList.contains('opacity-0');
                const allButtons = document.querySelectorAll('[id$="-button"]');
                const allSections = document.querySelectorAll('[id$="-section"]');

                // Remove active state from all buttons
                allButtons.forEach(btn => {
                    btn.classList.remove('ring-2', 'ring-blue-500', 'ring-offset-2');
                });

                // If clicking on the already open section, just close it
                if (!isHidden) {
                    section.classList.add('opacity-0', 'max-h-0', '-mt-2');
                    section.classList.remove('opacity-100', 'max-h-96', 'mt-0');
                    section.setAttribute('aria-hidden', 'true');
                    return;
                }

                // Hide all sections first
                allSections.forEach(el => {
                    el.classList.add('opacity-0', 'max-h-0', '-mt-2');
                    el.classList.remove('opacity-100', 'max-h-96', 'mt-0');
                    el.setAttribute('aria-hidden', 'true');
                });

                // Show the clicked section
                section.classList.remove('opacity-0', 'max-h-0', '-mt-2');
                section.classList.add('opacity-100', 'max-h-96', 'mt-0');
                section.setAttribute('aria-hidden', 'false');

                // Add active state to clicked button
                button.classList.add('ring-2', 'ring-blue-500', 'ring-offset-2');
            }

            function copyToClipboard(text, button) {
                navigator.clipboard.writeText(text).then(() => {
                    const originalHTML = button.innerHTML;
                    button.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 mr-2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Copied!
                    `;
                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                    }, 2000);
                });
            }

            function copyShareLink(button) {
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    const originalHTML = button.innerHTML;
                    button.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Link Copied!
                    `;
                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                    }, 2000);
                }).catch((err) => {
                    console.error('Failed to copy link: ', err);
                });
            }

            function shareNative() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Add {{ $name }} MCP',
                        text: 'Install {{ $name }} MCP with one click',
                        url: window.location.href
                    }).catch((error) => {
                        if (error.name !== 'AbortError') {
                            console.error('Error sharing:', error);
                        }
                    });
                } else {
                    // Fallback to copy link if native share is not available
                    const button = document.querySelector('[onclick*="shareNative"]');
                    copyShareLink(button);
                }
            }
        </script>
@endpush
