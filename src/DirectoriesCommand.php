<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DirectoriesCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('directories')
            ->setDescription('Creates docs, src and tests directories in the project')
            ->addOption(
                'skip-if-present',
                's',
                InputOption::VALUE_NONE,
                'Simply skip (don\'t error) if the directory exists already'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $baseDir = $this->containerDirectory();
        $toCreate = ['docs', 'src', 'tests'];
        $returnCode = 0;
        foreach ($toCreate as $folder) {
            $fullpath = $baseDir.DIRECTORY_SEPARATOR.$folder;
            if (!file_exists($fullpath)) {
                mkdir($fullpath);
                $output->writeln('<info>Created directory '.$fullpath.'</info>');
            } elseif ($input->getOption('skip-if-present') === false) {
                $output->writeln('<error>Directory '.$fullpath.' already exists!</error>');
                $returnCode = 1;
            } else {
                $output->writeln('<comment>Directory '.$fullpath.' already exists, skipping.</comment>');
            }
        }
        return $returnCode;
    }
}
