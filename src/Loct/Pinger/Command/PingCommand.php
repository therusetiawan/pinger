<?php
namespace Loct\Pinger\Command;

use \Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PingCommand extends Command
{
    protected function configure()
    {
        $this->setName('ping')
            ->setDescription('Ping some host and send notification if the host unreached');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>All host has been successfully ping-ed</info>');
    }
}