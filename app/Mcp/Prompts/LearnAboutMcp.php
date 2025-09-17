<?php

namespace App\Mcp\Prompts;

use Laravel\Mcp\Request;
use Laravel\Mcp\Server\Prompt;
use Laravel\Mcp\Server\Prompts\Argument;

class LearnAboutMcp extends Prompt
{
    protected string $description = 'Guides the user and AI agent to effectively learn about MCP from the right sources';

    public function handle(Request $request): string
    {
        return <<<PROMPT
Prompt goes here
Isn't it helpful
https://modelcontextprotocol.io

Attach the 'McpOverview' resource
	...
	...
PROMPT;
    }
}
