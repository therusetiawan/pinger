<?php
namespace Loct\Pinger;

use \PHPUnit_Framework_TestCase;

class PingFactoryTest extends PHPUnit_Framework_TestCase
{
    
    public function testCreatePing()
    {
        $host = '127.0.0.1';
        
        $factory = new PingFactory();
        $ping = $factory->createPing($host);
        
        $this->assertInstanceOf('\JJG\Ping', $ping);
        $this->assertEquals($host, $ping->getHost());
    }
}