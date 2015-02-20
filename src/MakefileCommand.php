<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakefileCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('makefile')
            ->setDescription('Generates a makefile for running unit tests, creating API docs and the like')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force overwrite of existing Makefile')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->copyTemplates(['Makefile'], $input, $output);
    }
}
