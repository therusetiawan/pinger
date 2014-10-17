<?php
namespace Loct\Pinger\Notifier;

/**
 * NotifierInterface is the interface implemented by all notifier classes.
 *
 * @author herloct <herloct@gmail.com>
 */
interface NotifierInterface
{
    /**
     * Notify all recipients.
     *
     * @param array $pingResults Ping results
     */
    public function notify(array $pingResults);
}
