<?php
namespace Loct\Pinger\Notifier;

/**
 * Notifier Interface
 *
 * @author herloct
 */
interface NotifierInterface
{
    /**
     * Notify all recipients
     *
     * @param array $pingResults Ping results
     */
    public function notify($pingResults);
}
