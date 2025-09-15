<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\McpConfigRequest;

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
