<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\McpConfigRequest;
use Illuminate\Support\Str;

class McpController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function generate(McpConfigRequest $request)
    {
        $name = $request->validated()['name'];
        $url = $request->validated()['url'];

        // Create slug from name
        $nameSlug = Str::slug($name);

        // URL encode for use in path (Laravel will handle this automatically)
        // Redirect to the shareable install URL
        return redirect()->route('install', [
            'name' => $nameSlug,
            'url' => $url
        ]);
    }

    public function install(Request $request, string $name, string $url)
    {
        // URL is automatically decoded by Laravel
        // Validate URL format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return redirect()->route('home')->withErrors(['url' => 'Invalid URL format']);
        }

        // Generate configuration JSON
        $config = [
            'name' => $name,
            'type' => 'http',
            'url' => $url,
        ];

        // Generate deep links
        $cursorUrl = $this->generateCursorDeepLink($name, $config);
        $vscodeUrl = $this->generateVscodeDeepLink($config);
        $vscodeInsidersUrl = $this->generateVscodeInsidersDeepLink($config);
        $claudeCommand = $this->generateClaudeCommand($name, $url);

        return view('results', [
            'name' => $name,
            'url' => $url,
            'config' => $config,
            'cursorUrl' => $cursorUrl,
            'vscodeUrl' => $vscodeUrl,
            'vscodeInsidersUrl' => $vscodeInsidersUrl,
            'claudeCommand' => $claudeCommand,
            'configJson' => json_encode($config, JSON_PRETTY_PRINT),
        ]);
    }

    private function generateCursorDeepLink(string $name, array $config): string
    {
        $encodedConfig = base64_encode(json_encode($config));
        return "cursor://anysphere.cursor-deeplink/mcp/install?name=" . urlencode($name) . "&config=" . urlencode($encodedConfig);
    }

    private function generateVscodeDeepLink(array $config): string
    {
        return "vscode:mcp/install?" . urlencode(json_encode($config));
    }

    private function generateVscodeInsidersDeepLink(array $config): string
    {
        return "vscode-insiders:mcp/install?" . urlencode(json_encode($config));
    }

    private function generateClaudeCommand(string $name, string $url): string
    {
        return sprintf('claude mcp add -s user -t http "%s" %s', $name, $url);
    }
}
