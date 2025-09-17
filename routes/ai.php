<?php

use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp', \App\Mcp\Servers\AddMcp::class);
