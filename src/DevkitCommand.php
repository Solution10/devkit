<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Command\Command;

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
            return $candidatePath;
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
}
