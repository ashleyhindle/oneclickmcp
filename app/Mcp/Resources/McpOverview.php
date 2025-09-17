<?php

namespace App\Mcp\Resources;

use Laravel\Mcp\Request;
use Laravel\Mcp\Server\Resource;

class McpOverview extends Resource
{
    protected string $description = 'Provides an overview of what MCP is';

    public function handle(Request $request): string
    {
        return <<<OVERVIEW
Hey
OVERVIEW;
    }
}
