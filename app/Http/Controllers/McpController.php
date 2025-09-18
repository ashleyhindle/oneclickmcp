<?php

namespace App\Http\Controllers;

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
        ['name' => $name, 'url' => $url] = $request->validated();

        return redirect()->route('install', [
            'name' => $name,
            'url' => $url,
        ]);
    }

    public function install(string $name, string $url)
    {
        // URL is automatically decoded by Laravel
        // Validate URL format
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
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

        // Generate badge URL
        $badgeUrl = route('badge', ['name' => $name, 'url' => $url]);

        return view('results', [
            'name' => $name,
            'url' => $url,
            'config' => $config,
            'cursorUrl' => $cursorUrl,
            'vscodeUrl' => $vscodeUrl,
            'vscodeInsidersUrl' => $vscodeInsidersUrl,
            'claudeCommand' => $claudeCommand,
            'configJson' => json_encode($config, JSON_PRETTY_PRINT),
            'badgeUrl' => $badgeUrl,
            'shareUrl' => url()->current(),
        ]);
    }

    private function generateCursorDeepLink(string $name, array $config): string
    {
        unset($config['type']);
        $encodedConfig = base64_encode(json_encode($config));

        return 'cursor://anysphere.cursor-deeplink/mcp/install?name='.urlencode($name).'&config='.urlencode($encodedConfig);
    }

    private function generateVscodeDeepLink(array $config): string
    {
        return 'vscode:mcp/install?'.urlencode(json_encode($config));
    }

    private function generateVscodeInsidersDeepLink(array $config): string
    {
        return 'vscode-insiders:mcp/install?'.urlencode(json_encode($config));
    }

    private function generateClaudeCommand(string $name, string $url): string
    {
        return sprintf('claude mcp add -s user -t http "%s" "%s"', Str::kebab($name), $url);
    }

    public function badge(string $name, string $url)
    {
        // URL is automatically decoded by Laravel
        // Validate URL format
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Invalid URL format'], 400);
        }

        // Get query parameters for customization
        $text = request('text', "Setup {$name} MCP");
        $color = request('color', '#0f44c5'); // Default blue color from the logo
        $labelColor = request('labelColor', '#fafafa');
        $style = request('style', 'flat');

        // Generate the SVG badge
        $svg = $this->generateBadgeSvg($text, $color, $labelColor, $style);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=3600')
            ->header('X-Content-Type-Options', 'nosniff');
    }

    private function generateBadgeSvg(string $text, string $color, string $labelColor, string $style): string
    {
        // Calculate text width (approximate)
        $textLength = strlen($text);
        $textWidth = $textLength * 7; // Approximate character width
        $height = 28;
        $logoWidth = 28;
        $borderRadius = 4;
        $padding = 6;
        $labelWidth = $logoWidth + $padding;
        $textSectionWidth = $textWidth + ($padding * 3.5);
        $totalWidth = $labelWidth + $textSectionWidth;
        $textX = $labelWidth + ($textSectionWidth / 2);
        $textY = $height / 2 + 4;

        // SVG template
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$totalWidth}" height="{$height}" viewBox="0 0 {$totalWidth} {$height}">
  <defs>
    <linearGradient id="b" x2="0" y2="100%">
      <stop offset="0" stop-color="#bbb" stop-opacity=".1"/>
      <stop offset="1" stop-opacity=".1"/>
    </linearGradient>
    <clipPath id="a">
      <rect width="{$totalWidth}" height="{$height}" rx="{$borderRadius}"/>
    </clipPath>
  </defs>
  <g clip-path="url(#a)">
    <path fill="{$labelColor}" d="M0 0h{$labelWidth}v{$height}H0z"/>
    <path fill="{$color}" d="M{$labelWidth} 0h{$textSectionWidth}v{$height}H{$labelWidth}z"/>
    <path fill="url(#b)" d="M0 0h{$totalWidth}v{$height}H0z"/>
  </g>
  <g fill="#fff" text-anchor="middle" font-family="Verdana,Geneva,DejaVu Sans,sans-serif" font-size="12">
    <!-- AddMCP Logo -->
    <g transform="translate(7.5, 3) scale(1.2, 1.2)">
      <path d="M 2.174 7.887 L 8.439 2.01 L 8.415 11.895 M 5.001 8.281 L 14.493 8.279 L 8.962 14.656"
            fill="none"
            stroke="#0f44c5"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="bevel"/>
    </g>
    <text x="{$textX}" y="{$textY}" fill="#fff">{$text}</text>
  </g>
</svg>
SVG;

        return $svg;
    }
}
