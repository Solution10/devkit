<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TravisCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('travis')
            ->setDescription('Creates a .travis.yml file that works for most s10 packages')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force overwrite of existing .travis.yml')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->copyTemplates(['.travis.yml'], $input, $output);
    }
}
