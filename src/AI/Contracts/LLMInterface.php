<?php

namespace Atlas\AI\Contracts;

interface LLMInterface
{
    public function chat(string $message): string;
}