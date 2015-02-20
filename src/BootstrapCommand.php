<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BootstrapCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('bootstrap-component')
            ->setDescription('Runs all of the sub-commands to get a brand new empty project on its feet')
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force overwrite of files (directories will NOT be overwritten)'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = [
            'directories' => ['--skip-if-present' => true],
            'gitignore' => ($input->getOption('force'))? ['-f' => true] : [],
            'legal' => ($input->getOption('force'))? ['-f' => true] : [],
            'makefile' => ($input->getOption('force'))? ['-f' => true] : [],
            'phpunit' => ($input->getOption('force'))? ['-f' => true] : [],
            'travis' => ($input->getOption('force'))? ['-f' => true] : []
        ];

        $output->writeln('<info>Welcome to the S10 Devkit.</info>');
        $output->writeln('Bootstrapping your component now...');
        $output->writeln('');

        if ($input->getOption('force')) {
            $output->writeln(
                '<fg=yellow;options=bold>Note: Forcing overwrite of files.</fg=yellow;options=bold> You were warned :)'
            );
            $output->writeln('');
        }

        foreach ($commands as $commandName => $args) {
            $command = $this->getApplication()->find($commandName);
            $returnCode = $command->run(new ArrayInput(array_merge([
                'command' => $commandName,
            ], $args)), $output);

            $output->writeln('');

            if ($returnCode !== 0) {
                $output->writeln('Errors detected, aborting.');
                $output->writeln('');
                return 1;
            }
        }
    }
}
