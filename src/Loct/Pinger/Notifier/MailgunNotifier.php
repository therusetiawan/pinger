<?php
namespace Loct\Pinger\Notifier;

use Mailgun\Mailgun;

/**
 * Notify recipients by email using Mailgun.
 *
 * @author herloct <herloct@gmail.com>
 */
class MailgunNotifier implements NotifierInterface
{

    /**
     * Mailgun
     *
     * @var Mailgun
     */
    private $mailgun = null;

    /**
     * Sender domain
     *
     * @var string
     */
    private $domain = null;

    /**
     * Array of recipient
     *
     * @var string[]
     */
    private $recipients = [];

    /**
     * Constructor.
     *
     * @param Mailgun  $mailgun    Mailgun
     * @param string   $domain     Sender domain
     * @param string[] $recipients Array of recipient
     */
    public function __construct(Mailgun $mailgun, $domain, array $recipients)
    {
        $this->mailgun = $mailgun;
        $this->domain = $domain;
        $this->recipients = $recipients;
    }

    /**
     * Notify all recipients
     *
     * @param array $pingResults Ping results
     */
    public function notify(array $pingResults)
    {
        $mailgun    = $this->mailgun;
        $domain     = $this->domain;
        $recipients = $this->recipients;

        if (empty($recipients) || empty($pingResults)) {
            return;
        }

        $failedHosts = [];
        foreach ($pingResults as $host => $result) {
            if (is_null($result)) {
                $failedHosts[] = $host;
            }
        }

        if (count($failedHosts) > 0) {
            $date = (new \DateTime())->setTimezone(new \DateTimeZone('Asia/Jakarta'))
                ->format('Y-m-d H:i:s');
            $subject = "Pinger Report : {$date} : Cannot reach some of your hosts";
            $text = 'Sorry, we cannot reach some of your hosts';

            foreach ($pingResults as $host => $result) {
                $info = is_null($result) ? 'Unreachable' : "{$result}ms";
                $text .= PHP_EOL."- {$host}: {$info}";
            }

            $messageBuilder = $mailgun->MessageBuilder();
            $messageBuilder->setFromAddress("no-reply@{$domain}");
            $messageBuilder->setSubject($subject);
            $messageBuilder->setTextBody($text);

            foreach ($recipients as $recipient) {
                $messageBuilder->addToRecipient($recipient);
            }

            $mailgun->post("{$domain}/messages", $messageBuilder->getMessage());
        }
    }
}
