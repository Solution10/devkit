<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BootstrapCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('bootstrap-component')
            ->setDescription('Runs all of the sub-commands to get a brand new empty project on its feet')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = ['directories', 'gitignore', 'legal', 'makefile', 'phpunit', 'travis'];

        $output->writeln('<info>Welcome to the S10 Devkit.</info>');
        $output->writeln('Bootstrapping your component now...');
        $output->writeln('');

        foreach ($commands as $commandName) {
            $command = $this->getApplication()->find($commandName);
            $command->run(new ArrayInput([
                'command' => $commandName
            ]), $output);
            $output->writeln('');
        }
    }
}
