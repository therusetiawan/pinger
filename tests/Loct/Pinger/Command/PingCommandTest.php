<?php
namespace Loct\Pinger\Command;

use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Tester\CommandTester;
use \PHPUnit_Framework_TestCase;

class PingCommandTest extends PHPUnit_Framework_TestCase
{

    public function testExecuteIsSucces()
    {
        $hosts = [
            '127.0.0.1',
            'google.com'
        ];
        $application = new Application();
        $application->add(new PingCommand($hosts));

        $command = $application->find('ping');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $display = $commandTester->getDisplay();
        $this->assertRegExp('/Finished ping-ing all hosts/', $display);
        foreach ($hosts as $host) {
            $this->assertRegExp("/{$hosts[0]}: /", $display);
        }
    }
}
