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
     * @param string $host Host to ping
     * @return Ping
     */
    public function createPing($host)
    {
        return new Ping($host);
    }
}
