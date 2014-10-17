<?php
namespace Loct\Pinger\Provider;

use \Loct\Pinger\Notifier\MailgunNotifier;
use \Mailgun\Mailgun;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

/**
 * Service provider for notifier related classes and parameters.
 *
 * @author herloct <herloct@gmail.com>
 */
class NotifierProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple An Container instance
     */
    public function register(Container $pimple)
    {
        $pimple['notifier'] = function ($pimple)
        {
            $config = $pimple['config'];

            $apiKey = $config->get('pinger.notifications.mailgun.api_key');
            $domain = $config->get('pinger.notifications.mailgun.domain');
            $recipients = $config->get('pinger.notifications.mailgun.recipients');

            $mailgun = new Mailgun($apiKey);

            return new MailgunNotifier($mailgun, $domain, $recipients);
        };
    }
}
