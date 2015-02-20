<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DirectoriesCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('directories')
            ->setDescription('Creates docs, src and tests directories in the project')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $baseDir = $this->containerDirectory();
        $toCreate = ['docs', 'src', 'tests'];
        foreach ($toCreate as $folder) {
            $fullpath = $baseDir.DIRECTORY_SEPARATOR.$folder;
            if (!file_exists($fullpath)) {
                mkdir($fullpath);
                $output->writeln('<info>Created directory '.$fullpath.'</info>');
            } else {
                $output->writeln('<error>Directory '.$fullpath.' already exists!</error>');
                return 1;
            }
        }
    }
}
