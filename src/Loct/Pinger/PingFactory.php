<?php
namespace Loct\Pinger;

use \JJG\Ping;

/**
 * Factory to create new JJG\Ping
 * 
 * @author herloct <herloct@gmail.com>
 */
class PingFactory
{
    /**
     * Create new JJG\Ping
     * 
     * @params string  $host Host
     * @params integer $ttl  Ping ttl
     * @return \JJG\Ping
     */
    public function createPing($host)
    {
        return new Ping($host);
    }
}
