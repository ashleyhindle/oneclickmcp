<?php

namespace App\Mcp\Tools;

use Illuminate\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class CreateSetupPage extends Tool
{
    protected string $description = 'Generate installation instructions and links for a HTTP Streaming MCP server';

    public function handle(Request $request): Response
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'not_regex:/[\'"]/'],
                'url' => ['required', 'url', 'max:2000'],
            ],
            [
                'name.required' => 'You must provide a server name.',
                'name.not_regex' => 'The server name must not contain quotes.',
                'name.max' => 'The server name must not exceed 255 characters.',
                'url.required' => 'You must provide a server URL.',
                'url.url' => 'Please provide a valid URL starting with https:// or http://',
                'url.max' => 'The URL must not exceed 2000 characters.',
            ]
        );

        $name = $validated['name'];
        $url = $validated['url'];

        $setupUrl = route('install', ['name' => $name, 'url' => $url]);

        return Response::text(
            "Successfully generated setup page!\n\n".
            "Share this URL with users to install your MCP server:\n".
            $setupUrl."\n\n".
            "This link will provide one-click installation instructions for:\n".
            "- Claude Code\n".
            "- Cursor\n".
            "- VS Code\n".
            '- And other MCP-compatible clients'
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
                ->description('The server name')
                ->required(),

            'url' => $schema->string()
                ->description('The MCP server URL (e.g., "https://your-server.com/mcp")')
                ->required(),
        ];
    }
}
