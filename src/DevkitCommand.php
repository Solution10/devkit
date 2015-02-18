<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DevkitCommand extends Command
{
    /**
     * Returns the top level directory of the containing project. So if I'm in
     *
     *  /Users/alex/s10-orm/vendor/solution10/devkit/src/MakefileCommand.php
     *
     * This command will return:
     *  /Users/alex/s10-orm
     *
     * It'll also detect if your developing the devkit (INCEPTION) and return the
     * testbed directory so you can test what you're doing.
     *
     * @return  string
     */
    protected function containerDirectory()
    {
        $candidatePath = realpath(__DIR__.'/../../..');
        if (basename($candidatePath) === 'vendor') {
            return $candidatePath.'/..';
        } else {
            $testbed = realpath(__DIR__.'/..').'/testbed';
            if (!file_exists($testbed)) {
                mkdir($testbed, 0777);
            }
            return $testbed;
        }
    }

    /**
     * Returns the directory containing the file templates that many commands make use of
     *
     * @return  string
     */
    protected function templatesDirectory()
    {
        return realpath(__DIR__.'/../templates');
    }

    /**
     * Returns the containing projects composer.json file contents.
     *
     * @return  \stdClass
     */
    protected function composer()
    {
        $containerDir = $this->containerDirectory();
        if (basename($containerDir) !== 'testbed') {
            $filename = $containerDir.'/composer.json';
        } else {
            $filename = $containerDir.'/../composer.json';
        }

        return json_decode(file_get_contents($filename));
    }

    /**
     * Copies an array of files from the templates directory into the target directory.
     * Used by a lot of commands.
     *
     * @param   array               $files
     * @param   InputInterface      $input
     * @param   OutputInterface     $output
     */
    protected function copyTemplates(array $files = [], InputInterface $input, OutputInterface $output)
    {
        foreach ($files as $file) {
            $sourceFile = $this->templatesDirectory().'/'.$file;
            $destFile = $this->containerDirectory().'/'.$file;

            if (!file_exists($destFile) || $input->getOption('force')) {
                (@copy($sourceFile, $destFile)) ?
                    $output->writeln('<info>Created '.$file.' at: ' . realpath($destFile) . '</info>')
                    : $output->writeln('<error>Unable to copy '.$file.' :(</error>');
            } else {
                $output->writeln('<error>'.$file.' already exists, will not overwrite without --force</error>');
            }
        }
    }

}
