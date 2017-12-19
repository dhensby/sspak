<?php

namespace SilverStripe\SSPak\Console\Command;

use SilverStripe\SSPak\Service\SSProject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SaveCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('save');
        $this->setDescription('Create an SSPak file from a SilverStripe project');
        $this->addArgument('project', InputArgument::REQUIRED, 'The location of the SilverStripe project');
        $this->addArgument('destination', InputArgument::OPTIONAL, 'The location to save the SSPak file', getcwd());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('SSPak being created from ' . $input->getArgument('project'));
        $output->writeln(' and saved into ' . $input->getArgument('destination'));
        $project = SSProject::resolve($input->getArgument('project'));
        $output->writeln('Project detected as ' . (new \ReflectionClass($project))->getShortName());
        $output->writeln('Project DB credentials detected as:');
        foreach ($project->getDBConfig() as $key => $value) {
            $output->writeln(sprintf(' - %s: %s', $key, $value));
        }
    }
}
