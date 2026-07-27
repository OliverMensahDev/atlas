<?php

namespace Atlas\AI;

use Atlas\AI\Contracts\LLMInterface;

class LLMManager
{
    private array $providers = [];


    public function register(string $name, LLMInterface $provider): void 
    {
        $this->providers[$name] = $provider;
    }


    public function get(string $name): LLMInterface 
    {
        if (!isset($this->providers[$name])) {
            throw new \Exception(
                "LLM provider {$name} not found"
            );
        }

        return $this->providers[$name];
    }
}