<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateSetupPage extends Tool
{
    /**
     * The tool's description.
     */
    protected string $description = 'Generate installation instructions and links for an MCP server';

    /**
     * Handle the tool request.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/'],
                'url' => ['required', 'url', 'max:2000'],
            ],
            [
                'name.required' => 'You must provide a server name.',
                'name.regex' => 'The server name must be lowercase with hyphens only (e.g., "my-mcp-server").',
                'name.max' => 'The server name must not exceed 255 characters.',
                'url.required' => 'You must provide a server URL.',
                'url.url' => 'Please provide a valid URL starting with https:// or http://',
                'url.max' => 'The URL must not exceed 2000 characters.',
            ]
        );

        $name = $validated['name'];
        $url = $validated['url'];

        // Encode the URL for use in the path
        $encodedUrl = urlencode($url);

        // Generate the setup URL using the app URL
        $setupUrl = config('app.url') . "/addmcp/{$encodedUrl}?name={$name}";

        return Response::text(
            "Successfully generated setup page!\n\n" .
            "Share this URL with users to install your MCP server:\n" .
            $setupUrl . "\n\n" .
            "This link will provide one-click installation instructions for:\n" .
            "- Claude Code\n" .
            "- Cursor\n" .
            "- VS Code\n" .
            "- And other MCP-compatible clients"
        );
    }

    /**
     * Get the tool's input schema.
     *
     * @return array<string, \Illuminate\JsonSchema\JsonSchema>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()
                ->description('The server name (lowercase with hyphens, e.g., "my-mcp-server")')
                ->required(),

            'url' => $schema->string()
                ->description('The MCP server URL (e.g., "https://your-server.com/mcp")')
                ->required(),
        ];
    }
}
