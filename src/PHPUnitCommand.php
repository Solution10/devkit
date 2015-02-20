<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PHPUnitCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('phpunit')
            ->setDescription('Generates a phpunit.xml.dist for running unit tests, and creates the test bootstrap')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force overwrite of existing phpunit.xml.dist')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $copyDidSucceed = $this->copyTemplates(['phpunit.xml.dist', 'tests/bootstrap.php'], $input, $output);
        if ($copyDidSucceed === 0) {
            // Edit the phpunit file to include the package name:
            $composer = $this->composer();
            $replace = [
                '{{packageName}}' => ucfirst(str_replace('solution10/', '', $composer->name)),
            ];

            $phpunitContents = file_get_contents($this->containerDirectory() . '/phpunit.xml.dist');
            $phpunitContents = str_replace(array_keys($replace), array_values($replace), $phpunitContents);
            file_put_contents($this->containerDirectory() . '/phpunit.xml.dist', $phpunitContents);
            $output->writeln('<info>Updated phpunit.xml.dist</info>');
            return 1;
        }
    }
}
