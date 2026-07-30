<?php

namespace Atlas\AI\Providers;

use Atlas\AI\ChatRequest;
use Atlas\AI\Contracts\LLMInterface;

class GeminiClient implements LLMInterface
{
    public function chat(ChatRequest $request): string
    {
        return "Gemini: {$request->message}";
    }
}