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
        $pingedResults = [
            '127.0.0.1' => null
        ];

        $messageBuilder = $this->getMockBuilder('Mailgun\Messages\MessageBuilder')
            ->getMock();

        $messageBuilder->expects($this->once())
            ->method('setFromAddress');

        $messageBuilder->expects($this->exactly(count($recipients)))
            ->method('addToRecipient');

        $messageBuilder->expects($this->once())
            ->method('setSubject');

        $messageBuilder->expects($this->once())
            ->method('setTextBody');

        $messageBuilder->expects($this->once())
            ->method('getMessage');

        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')
            ->disableOriginalConstructor()
            ->getMock();

        $mailgun->expects($this->once())
            ->method('MessageBuilder')
            ->willReturn($messageBuilder);

        $mailgun->expects($this->once())
            ->method('post');

        $notifier = new MailgunNotifier($mailgun, $domain, $recipients);
        $this->assertInstanceOf('Loct\Pinger\Notifier\NotifierInterface', $notifier);

        $notifier->notify($pingedResults);
    }
}
