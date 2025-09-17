<?php

namespace App\Mcp\Servers;

use Laravel\Mcp\Server;

class AddMcp extends Server
{
    protected string $name = 'addmcp.fyi';

    protected string $version = '0.0.1';

    protected string $instructions = 'Use to generate guided MCP setup/install pages, and to help the user understand MCP';

    protected array $tools = [
        \App\Mcp\Tools\CreateSetupPage::class,
    ];

    protected array $resources = [
        \App\Mcp\Resources\McpOverview::class,
    ];

    protected array $prompts = [
        \App\Mcp\Prompts\LearnAboutMcp::class,
    ];
}
