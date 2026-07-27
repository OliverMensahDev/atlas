<?php

namespace Atlas\AI\Providers;

use Atlas\AI\Contracts\LLMInterface;

class GeminiClient implements LLMInterface
{
    public function chat(string $message): string
    {
        return "Gemini: {$message}";
    }
}