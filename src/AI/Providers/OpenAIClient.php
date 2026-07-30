<?php

namespace Atlas\AI\Providers;

use Atlas\AI\Contracts\LLMInterface;
use Atlas\AI\ChatRequest;

class OpenAIClient implements LLMInterface
{
    public function chat(ChatRequest $request): string
    {
        return "OpenAI: {$request->message}";
    }
}