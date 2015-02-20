<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GitignoreCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('gitignore')
            ->setDescription('Creates a gitignore file that works for most s10 packages')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force overwrite of existing .gitignore')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->copyTemplates(['.gitignore'], $input, $output);
    }
}
