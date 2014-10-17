<?php
namespace Loct\Pinger\Notifier;

use \PHPUnit_Framework_TestCase;

class MailgunNotifierTest extends PHPUnit_Framework_TestCase
{

    public function testNotify()
    {
        $domain = 'somedomain.com';
        $recipients = [
            'herloct@gmail.com'
        ];

        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')
            ->disableOriginalConstructor()
            ->getMock();

        $mailgun->expects($this->exactly(1))
            ->method('sendMessage')
            ->withConsecutive(
                [$this->equalTo($domain), $this->anything()]
            );

        $notifier = new MailgunNotifier($mailgun, $domain, $recipients);
        $this->assertInstanceOf('Loct\Pinger\Notifier\NotifierInterface', $notifier);

        $notifier->notify([]);
    }
}
