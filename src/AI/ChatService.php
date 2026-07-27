<?php 

namespace Atlas\AI;

class ChatService
{
    public function __construct(private LLMManager $manager)
    {
    }
    public function reply(string $message, string $provider="openai"): string
    {
        $llm = $this->manager->get($provider);

        return $llm->chat($message);
    }
}