<?php

use Atlas\Container;
use Atlas\AI\ChatService;
use Atlas\Config\AIConfig;
use Symfony\Component\Yaml\Yaml;
use Atlas\CLI\ChatCommand;
use Atlas\AI\LLMManager;
use Atlas\AI\Providers\DigitalOceanInferenceClient;
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
     * Register DigitalOcean Inference
     */
    $container->set(
        DigitalOceanInferenceClient::class,
        function() {
            return new DigitalOceanInferenceClient();
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

            $manager->register(
                "digitalocean",
                $container->get(DigitalOceanInferenceClient::class)
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
    * Register AI Configuration
    */
    $container->set(
        AIConfig::class,
        function() {

            $config = Yaml::parseFile(
                __DIR__ . '/ai.yaml'
            );

            return new AIConfig($config);
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
                ),
                $container->get(AIConfig::class)
            );
        }
    );
};