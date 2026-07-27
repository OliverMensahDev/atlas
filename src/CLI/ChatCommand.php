<?php

namespace Atlas\CLI;

use Symfony\Component\Console\Command\Command;
use Atlas\AI\ChatService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;

class ChatCommand extends Command
{
    private ChatService $service;
    public function __construct(private ChatService $chatService)
    {
        $this->service = $chatService;
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
            'Choose AI provider (openai, gemini)',
            'gemini'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $provider = $input->getOption('provider');

        if (is_string($name) && $name !== '') {
            $output->writeln(sprintf('<info>Atlas is alive, %s.</info>', $name));
        } else {
            $output->writeln('<info>Atlas is alive.</info>');
        }

        $output->writeln('<comment>Type "exit" to quit.</comment>');

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

            $response = $this->service->reply(
                $message,
                $provider
            );
            $output->writeln($response);
        }

        return Command::SUCCESS;
    }
}