<?php

namespace Atlas\CLI;

use Symfony\Component\Console\Command\Command;
use Atlas\AI\ChatService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Atlas\AI\ChatRequest;
use Atlas\Config\AIConfig;
use Symfony\Component\Console\Question\Question;

class ChatCommand extends Command
{
    private ChatService $service;
    public function __construct(
        private ChatService $chatService,
        private AIConfig $config
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->setName('chat')
        ->setDescription('Start an interactive Atlas chat session.')
        ->setHelp('Type messages and Atlas will echo them back. Type "exit" to quit.')
        ->addArgument('name', InputArgument::OPTIONAL, 'Your name')
        ->addOption(
            'provider',
            'p',
            InputOption::VALUE_REQUIRED,
            'LLM Provider',
        )
        ->addOption(
            'model',
            'm',
            InputOption::VALUE_REQUIRED,
            'Model',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $provider = $input->getOption('provider') ?? $this->config->defaultProvider();
        $model = $input->getOption('model') ?? $this->config->defaultModel($provider);

        if (is_string($name) && $name !== '') {
            $output->writeln(sprintf('<info>Atlas 0.1 is alive, %s.</info>', $name));
        } else {
            $output->writeln('<info>Atlas is 0.1 alive.</info>');
        }

        $output->writeln('');

        $output->writeln(sprintf(
            'Provider : <comment>%s</comment>',
            $provider
        ));

        $output->writeln(sprintf(
            'Model    : <comment>%s</comment>',
            $model
        ));

        $output->writeln('');
        $output->writeln('<comment>Type "exit" to quit.</comment>');
        $output->writeln('');

        $helper = new QuestionHelper();

        while (true) {
            $question = new Question('> ');
            $message = $helper->ask($input, $output, $question);

            if ($message === null) {
                continue;
            }

            $text = trim($message);

            if ($text === '') {
                continue;
            }

            if (strtolower($text) === 'exit') {
                $output->writeln('<info>Goodbye.</info>');
                break;
            }
            $request = new ChatRequest(
                message: $text,
                provider: $provider,
                model: $model
            );
            $response = $this->chatService->reply($request);
            $output->writeln($response);
        }

        return Command::SUCCESS;
    }
}