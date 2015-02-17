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
        // This one's simple, simply copy the file from one location
        $sourceFile = $this->templatesDirectory().'/Makefile';
        $destFile = $this->containerDirectory().'/Makefile';

        if (!file_exists($destFile) || $input->getOption('force')) {
            (@copy($sourceFile, $destFile))?
                $output->writeln('<info>Created Makefile at: '.realpath($destFile).'</info>')
                : $output->writeln('<error>Unable to copy Makefile :(</error>')
            ;
        } else {
            $output->writeln('<error>Makefile already exists, will not overwrite without --force</error>');
        }
    }
}
