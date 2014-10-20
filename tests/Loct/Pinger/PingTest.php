<?php
namespace Loct\Pinger;

use \PHPUnit_Framework_TestCase;

class PingTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider dataProviderTestHostAndPort
     */
    public function testHostAndPort($raw, $host, $port)
    {
        $ping = new Ping($raw);

        $this->assertEquals($host, $ping->getHost());
        $this->assertEquals($port, $ping->getPort());
        $this->assertEquals(10, $ping->getTtl());
    }

    public function dataProviderTestHostAndPort()
    {
        return [
            ['127.0.0.1', '127.0.0.1', 80],
            ['127.0.0.1:8181', '127.0.0.1', 8181],
            ['google.com', 'google.com', 80]
        ];
    }
}