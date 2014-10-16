<?php
use \Loct\Pinger\Command\PingCommand;
use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Tester\CommandTester;
use \PHPUnit_Framework_TestCase;

class PingCommandTest extends PHPUnit_Framework_TestCase
{

    public function testExecuteIsSucces()
    {
        $application = new Application();
        $application->add(new PingCommand());

        $command = $application->find('ping');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $this->assertRegExp('/Finished ping-ing all hosts/', $commandTester->getDisplay());
    }
}