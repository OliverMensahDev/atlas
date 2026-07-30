<?php

namespace Atlas\AI\Contracts;

use Atlas\AI\ChatRequest;

interface LLMInterface
{
    public function chat(ChatRequest $request): string;
}