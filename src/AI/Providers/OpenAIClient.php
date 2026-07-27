<?php

namespace Atlas\AI\Providers;

use Atlas\AI\Contracts\LLMInterface;

class OpenAIClient implements LLMInterface
{
    public function chat(string $message): string
    {
        return "OpenAI: {$message}";
    }
}