<?php

use Atlas\Container;
use Atlas\AI\ChatService;
use Atlas\CLI\ChatCommand;
use Atlas\AI\LLMManager;
use Atlas\AI\Providers\OpenAIClient;
use Atlas\AI\Providers\GeminiClient;


return function(Container $container) {


    /*
     * Register OpenAI
     */
    $container->set(
        OpenAIClient::class,
        function() {
            return new OpenAIClient();
        }
    );


    /*
     * Register Gemini
     */
    $container->set(
        GeminiClient::class,
        function() {
            return new GeminiClient();
        }
    );


    /*
     * Register LLM Manager
     */
    $container->set(
        LLMManager::class,
        function(Container $container) {

            $manager = new LLMManager();


            $manager->register(
                "openai",
                $container->get(OpenAIClient::class)
            );


            $manager->register(
                "gemini",
                $container->get(GeminiClient::class)
            );


            return $manager;
        }
    );


    /*
     * Register Chat Service
     */
    $container->set(
        ChatService::class,
        function(Container $container) {

            return new ChatService(
                $container->get(
                    LLMManager::class
                )
            );
        }
    );

    /*
     * Register Chat Command
     */
    $container->set(
        ChatCommand::class,
        function(Container $container){

            return new ChatCommand(
                $container->get(
                    ChatService::class
                )
            );
        }
    );
};