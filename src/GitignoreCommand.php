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
        // This one's simple, simply copy the file from one location
        $sourceFile = $this->templatesDirectory().'/gitignore';
        $destFile = $this->containerDirectory().'/.gitignore';

        if (!file_exists($destFile) || $input->getOption('force')) {
            (@copy($sourceFile, $destFile))?
                $output->writeln('<info>Created .gitignore at: '.realpath($destFile).'</info>')
                : $output->writeln('<error>Unable to copy .gitignore :(</error>')
            ;
        } else {
            $output->writeln('<error>.gitignore already exists, will not overwrite without --force</error>');
        }
    }
}
