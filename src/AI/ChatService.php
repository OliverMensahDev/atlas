<?php 

namespace Atlas\AI;

class ChatService
{
    public function __construct(private LLMManager $manager)
    {}
    public function reply(ChatRequest $request): string
    {
        $llm = $this->manager->get($request->provider);

        return $llm->chat($request);
    }
}