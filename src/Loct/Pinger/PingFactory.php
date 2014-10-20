<?php
namespace Loct\Pinger;

/**
 * Factory to create new Ping
 *
 * @author herloct <herloct@gmail.com>
 */
class PingFactory
{
    /**
     * Create new Ping
     *
     * @params string  $host Host
     * @params integer $ttl  Ping ttl
     * @return Loct\Pinger\Ping
     */
    public function createPing($host)
    {
        return new Ping($host);
    }
}
