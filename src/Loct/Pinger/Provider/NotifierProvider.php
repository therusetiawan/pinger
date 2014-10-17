<?php
namespace Loct\Pinger\Provider;

use \Loct\Pinger\Notifier\MailgunNotifier;
use \Mailgun\Mailgun;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

class NotifierProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['notifier'] = function ($pimple) {
            $config = $pimple['config'];

            $apiKey = $config->get('pinger.notifications.mailgun.api_key');
            $domain = $config->get('pinger.notifications.mailgun.domain');
            $recipients = $config->get('pinger.notifications.mailgun.recipients');

            $mailgun = new Mailgun($apiKey);
            return new MailgunNotifier($mailgun, $domain, $recipients);
        };
    }

}
