<?php

namespace Solution10\Devkit;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LegalCommand extends DevkitCommand
{
    protected function configure()
    {
        $this
            ->setName('legal')
            ->setDescription('Creates the LICENSE, CONTRIBUTING and readme.md files')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force overwrite of existing files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = ['LICENSE.md', 'CONTRIBUTING.md', 'readme.md'];

        foreach ($files as $file) {
            // This one's simple, simply copy the file from one location
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

        // Edit the copyright to have this years date
        $licenseContents = file_get_contents($this->containerDirectory().'/LICENSE.md');
        $licenseContents = str_replace('{{year}}', date('Y'), $licenseContents);
        file_put_contents($this->containerDirectory().'/LICENSE.md', $licenseContents);
        $output->writeln('<info>Updated LICENSE.md</info>');

        // Now let's go edit the readme.md based on info from the composer.json in the top level
        $composer = $this->composer();
        $replace = [
            '{{packageName}}' => $composer->name,
            '{{packageDescription}}' => $composer->description,
        ];
        $authors = [];
        foreach ($composer->authors as $author) {
            $authors[] = $author->name.' <'.$author->email.'>';
        }
        $replace['{{authors}}'] = '- '.implode(PHP_EOL.'- ', $authors);

        $readmeContents = file_get_contents($this->containerDirectory().'/readme.md');
        $readmeContents = str_replace(array_keys($replace), array_values($replace), $readmeContents);
        file_put_contents($this->containerDirectory().'/readme.md', $readmeContents);
        $output->writeln('<info>Updated readme.md</info>');
    }
}
