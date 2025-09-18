@extends('layouts.app')

@section('title', 'Create MCP Setup Page')
@section('description', 'Generate one-click installation links for your MCP server. Support for Cursor, VS Code, Claude Code, and more.')
@section('og:title', 'Create an MCP Setup Page')
@section('og:subtitle', 'Guided MCP installation for your users and their favorite AI agent')
@section('og:description', 'Generate one-click installation links for your MCP server. Support for Cursor, VS Code, Claude Code, and more.')

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
                    <h1 class="text-4xl font-bold text-slate-700 dark:text-slate-300">addmcp</h1>
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
			    autofocus
                            value="{{ old('name') }}"
                            placeholder="Server Name"
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
                        @error('url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div
                        x-data="headerManager"
                        class="space-y-3"
                    >
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">Headers (optional)</label>
                            <div class="flex gap-3">
                                <button
                                    type="button"
                                    @click="addHeader()"
                                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline focus:outline-none"
                                >
                                    + Add header
                                </button>
                                <button
                                    type="button"
                                    @click="addAuthHeader()"
                                    x-show="!hasAuthHeader()"
                                    class="text-sm text-green-600 dark:text-green-400 hover:underline focus:outline-none"
                                >
                                    + Add Auth Header
                                </button>
                            </div>
                        </div>


                        <div class="space-y-2">
                            <div x-show="headers.length > 0" class="grid grid-cols-[1fr_1fr_auto] gap-2 text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] mb-2">
                                <div>Key</div>
                                <div>Value</div>
                                <div class="w-10"></div>
                            </div>
                            <template x-for="(header, index) in headers" :key="index">
                                <div class="grid grid-cols-[1fr_1fr_auto] gap-2">
                                    <input
                                        type="text"
                                        :name="`headers[${index}][key]`"
                                        x-model="header.key"
                                        placeholder="Header name"
                                        class="px-3 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#1b1b18] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors placeholder-[#A1A09A] text-sm"
                                    />
                                    <div
                                        contenteditable="true"
                                        @input="updateHeaderValue(index, $event)"
                                        @keydown.enter.prevent="$event.target.blur()"
                                        x-init="if (header.value) $el.innerHTML = formatHeaderValue(header.value)"
                                        data-placeholder="Header value or @{{VARIABLE}}"
                                        class="px-3 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#1b1b18] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm min-h-[2.5rem] [&:empty]:before:content-[attr(data-placeholder)] [&:empty]:before:text-[#A1A09A] [&:empty]:before:pointer-events-none"
                                        style="white-space: pre-wrap; word-wrap: break-word;"
                                    ></div>
                                    <input
                                        type="hidden"
                                        :name="`headers[${index}][value]`"
                                        x-model="header.value"
                                    />
                                    <button
                                        type="button"
                                        @click="removeHeader(index)"
                                        class="px-3 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <div x-show="headers.length > 0" class="grid grid-cols-[1fr_1fr_auto] gap-2 mt-2">
                                <div></div>
                                <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Use <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">@{{VARIABLE_NAME}}</code> for values users should provide.
                                </div>
                                <div></div>
                            </div>
                        </div>

                        @error('headers.*.*')
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

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('headerManager', () => ({
        headers: @json(old('headers', [])),
        addHeader() {
            this.headers.push({ key: '', value: '' });
        },
        addAuthHeader() {
            this.headers.push({ key: 'Authorization', value: 'Bearer @{{TOKEN}}' });
        },
        removeHeader(index) {
            this.headers.splice(index, 1);
        },
        hasAuthHeader() {
            return this.headers.some(header => header.key.toLowerCase() === 'authorization');
        },
        updateHeaderValue(index, event) {
            const element = event.target;
            const selection = window.getSelection();
            const cursorPosition = this.getCursorPosition(element);

            // Get plain text content
            const plainText = element.textContent || '';
            this.headers[index].value = plainText;

            // Format content with highlighting
            const formattedHTML = this.formatHeaderValue(plainText);

            // Only update DOM if content changed
            if (element.innerHTML !== formattedHTML) {
                element.innerHTML = formattedHTML;
                this.setCursorPosition(element, cursorPosition);
            }
        },
        formatHeaderValue(value) {
            if (!value) return '';
            return value.replace(/\{\{([^}]+)\}\}/g, '<span class="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-1 rounded font-mono text-xs">@{{$1}}</span>');
        },
        getCursorPosition(element) {
            const selection = window.getSelection();
            if (selection.rangeCount === 0) return 0;

            const range = selection.getRangeAt(0);
            const preCaretRange = range.cloneRange();
            preCaretRange.selectNodeContents(element);
            preCaretRange.setEnd(range.endContainer, range.endOffset);

            return preCaretRange.toString().length;
        },
        setCursorPosition(element, position) {
            const range = document.createRange();
            const selection = window.getSelection();

            let currentPos = 0;
            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );

            let node;
            while (node = walker.nextNode()) {
                const nodeLength = node.textContent.length;
                if (currentPos + nodeLength >= position) {
                    range.setStart(node, position - currentPos);
                    range.collapse(true);
                    selection.removeAllRanges();
                    selection.addRange(range);
                    return;
                }
                currentPos += nodeLength;
            }

            // Fallback: place cursor at end
            range.selectNodeContents(element);
            range.collapse(false);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    }));
});
</script>
@endpush

