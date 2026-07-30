<?php

namespace Atlas\Config;

final class AIConfig
{
    public function __construct(
        private readonly array $config
    ) {
    }

    public function defaultProvider(): string
    {
        return $this->config['default_provider'];
    }

    public function defaultModel(string $provider): string
    {
        return $this->provider($provider)['default_model'];
    }

    public function provider(string $provider): array
    {
        if (! isset($this->config['providers'][$provider])) {
            throw new \InvalidArgumentException(
                sprintf('Unknown provider "%s".', $provider)
            );
        }

        return $this->config['providers'][$provider];
    }

    public function providers(): array
    {
        return array_keys($this->config['providers']);
    }
}