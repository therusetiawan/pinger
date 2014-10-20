<?php
namespace Loct\Pinger\Command;

use \Symfony\Component\Console\Application;
use \Symfony\Component\Console\Tester\CommandTester;
use \PHPUnit_Framework_TestCase;

class PingCommandTest extends PHPUnit_Framework_TestCase
{

    public function testExecuteIsSucces()
    {
        $results = [
            '127.0.0.1' => 0,
            'google.com' => 10,
            '192.168.0.123' => false
        ];
        $hosts = array_keys($results);
        
        $factory = $this->getMockBuilder('Loct\Pinger\PingFactory')
            ->getMock();
        
        for ($i = 0; $i < count($hosts); $i++) {
            $ping = $this->getMockBuilder('JJG\Ping')
                ->disableOriginalConstructor()
                ->getMock();
                
            $ping->expects($this->once())
                ->method('ping')
                ->willReturn($results[$hosts[$i]]);
            
            $factory->expects($this->at($i))
                ->method('createPing')
                ->willReturn($ping);
        }
        
        $notifier = $this->getMockBuilder('Loct\Pinger\Notifier\NotifierInterface')
            ->getMock();

        $notifier->expects($this->once())
            ->method('notify');

        $application = new Application();
        $application->add(new PingCommand($factory, $notifier, $hosts));

        $command = $application->find('ping');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $display = $commandTester->getDisplay();
        $this->assertRegExp('/Finished ping-ing all hosts/', $display);
        foreach ($hosts as $host) {
            $this->assertRegExp("/{$hosts[0]}/", $display);
        }
    }
}
