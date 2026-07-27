<?php

namespace Atlas;

use Symfony\Component\Console\Application as SymfonyApplication;
use Atlas\CLI\ChatCommand;

class Application
{
    public static function create(\Atlas\Container $container): SymfonyApplication
    {
        $application = new SymfonyApplication('Atlas','0.1.0');

        $application->addCommand($container->get(ChatCommand::class));

        return $application;
    }
}