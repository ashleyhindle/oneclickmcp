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
        $validated = $request->validated();
        $name = $validated['name'];
        $url = $validated['url'];
        $headers = $this->processHeaders($validated['headers'] ?? []);

        $routeParams = [
            'name' => $name,
            'url' => $url,
        ];

        // Build the URL with query parameters if headers exist
        $redirectUrl = route('install', $routeParams);
        if (! empty($headers)) {
            $redirectUrl .= '?headers='.urlencode(base64_encode(json_encode($headers)));
        }

        return redirect($redirectUrl);
    }

    private function processHeaders(?array $headers): array
    {
        if (empty($headers)) {
            return [];
        }

        $processed = [];
        foreach ($headers as $header) {
            if (! empty($header['key']) && ! empty($header['value'])) {
                $processed[$header['key']] = $header['value'];
            }
        }

        return $processed;
    }

    public function install(string $name, string $url)
    {
        // URL is automatically decoded by Laravel
        // Validate URL format
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return redirect()->route('home')->withErrors(['url' => 'Invalid URL format']);
        }

        // Decode headers from query parameter if provided
        $decodedHeaders = [];
        $headersParam = request()->query('headers');
        if ($headersParam) {
            try {
                $decodedHeaders = json_decode(base64_decode($headersParam), true) ?: [];
            } catch (\Exception $e) {
                $decodedHeaders = [];
            }
        }

        // Detect variables in headers (pattern: {{VARIABLE_NAME}})
        $detectedVariables = [];
        $hasVariables = false;
        foreach ($decodedHeaders as $key => $value) {
            if (preg_match_all('/\{\{([^}]+)\}\}/', $value, $matches)) {
                $hasVariables = true;
                foreach ($matches[1] as $variable) {
                    $detectedVariables[$variable] = '';
                }
            }
        }

        // Generate configuration JSON
        $config = [
            'name' => $name,
            'url' => $url,
        ];

        if (! empty($decodedHeaders)) {
            $config['headers'] = $decodedHeaders;
        }

        // Generate deep links
        $cursorUrl = $this->generateCursorDeepLink($name, $config);
        $vscodeUrl = $this->generateVscodeDeepLink($config);
        $claudeCommand = $this->generateClaudeCommand($name, $url, $decodedHeaders);

        // Generate badge URL
        $badgeUrl = route('badge', ['name' => $name, 'url' => $url]);

        // Generate share URL with headers if present
        $shareUrl = url()->current();
        if (! empty($decodedHeaders) && $headersParam) {
            $shareUrl .= '?headers='.$headersParam;
        }

        return view('results', [
            'name' => $name,
            'url' => $url,
            'config' => $config,
            'cursorUrl' => $cursorUrl,
            'vscodeUrl' => $vscodeUrl,
            'claudeCommand' => $claudeCommand,
            'configJson' => json_encode($config, JSON_PRETTY_PRINT),
            'badgeUrl' => $badgeUrl,
            'shareUrl' => $shareUrl,
            'headers' => $decodedHeaders,
            'headersParam' => $headersParam,
            'hasVariables' => $hasVariables,
            'detectedVariables' => array_keys($detectedVariables),
            'headersJson' => json_encode($decodedHeaders),
        ]);
    }

    private function generateCursorDeepLink(string $name, array $config): string
    {
        $encodedConfig = base64_encode(json_encode($config));

        return 'cursor://anysphere.cursor-deeplink/mcp/install?name='.urlencode($name).'&config='.urlencode($encodedConfig);
    }

    private function generateVscodeDeepLink(array $config): string
    {
	$config['type'] = 'http';
        return 'vscode:mcp/install?'.urlencode(json_encode($config));
    }

    private function generateClaudeCommand(string $name, string $url, array $headers = []): string
    {
        $command = sprintf('claude mcp add -s user -t http "%s" "%s"', Str::kebab($name), $url);

        foreach ($headers as $key => $value) {
            // Escape double quotes in the value
            $escapedValue = str_replace('"', '\\"', $value);
            $command .= sprintf(' --header "%s: %s"', $key, $escapedValue);
        }

        return $command;
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
