<?php

namespace Atlas\AI;

class ChatRequest
{
    public function __construct(
        public readonly string $message,
        public readonly string $provider = 'digitalocean',
        public readonly string $model = 'llama-3.3-70b',
        public readonly bool $stream = false,
    ) {
    }
}