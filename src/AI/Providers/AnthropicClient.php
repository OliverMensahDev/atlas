<?php

namespace Atlas\AI\Providers;

use Atlas\AI\Contracts\LLMInterface;

class AnthropicClient implements LLMInterface
{
    public function chat(string $message): string
    {
        return "Anthropic: {$message}";
    }
}