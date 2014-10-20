<?php
namespace Loct\Pinger;

/**
 * Ping component that only use fsockopen.
 *
 * @author herloct <herloct@gmail.com>
 */
class Ping extends \JJG\Ping
{

    /**
     * Constructor
     *
     * @param string $host The host to be pinged
     */
    public function __construct($host)
    {
        parent::__construct($host, 10);

        $this->extractHostAndPort($host);
    }

    /**
     * Extract host and port.
     *
     * If the host doesn't include port information, then the default is 80.
     *
     * @param string $source
     */
    protected function extractHostAndPort($source)
    {
        $host = $source;
        $port = 80;
        $parts = explode(':', $source);

        if (count($parts) === 2) {
            $host = $parts[0];
            $port = $parts[1];
        }

        $this->setHost($host);
        $this->setPort($port);
    }

    /**
     * Ping a host.
     *
     * @param string $method
     *   Will always use fsockopen no matter what we choose.
     *
     * @return integer|false
     *   Latency as integer, in ms, if host is reachable or FALSE if host is down.
     */
    public function ping($method = 'exec') {
        $starttime = microtime(true);
        $file = @fsockopen($this->getHost(), $this->getPort(), $errno, $errstr, $this->getTtl());
        $stoptime = microtime(true);
        $latency = false;

        if ($file !== false) {
            fclose($file);
            $latency = floor(($stoptime - $starttime) * 1000);
        }

        return $latency;
    }
}
