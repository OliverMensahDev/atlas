<?php

namespace Atlas\AI\Providers;

use Atlas\AI\ChatRequest;
use Atlas\AI\Contracts\LLMInterface;

class DigitalOceanInferenceClient implements LLMInterface
{
    public function chat(ChatRequest $request): string
    {
        return "DigitalOcean Inference: {$request->message}";
    }
}