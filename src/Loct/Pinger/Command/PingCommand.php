<?php
namespace Loct\Pinger\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \JJG\Ping;
use Loct\Pinger\Notifier\NotifierInterface;

/**
 * Ping registered hosts and send notification.
 *
 * @author herloct <herloct@gmail.com>
 */
class PingCommand extends Command
{

    /**
     * Array of hosts
     *
     * @var string[]
     */
    private $hosts = [];

    /**
     *
     * @var Loct\Pinger\Notifier\NotifierInterface
     */
    private $notifier = null;

    /**
     * Constructor.
     *
     * @param string[]          $hosts    Array of host
     * @param NotifierInterface $notifier Notifier
     */
    public function __construct(array $hosts, NotifierInterface $notifier)
    {
        $this->hosts = $hosts;
        $this->notifier = $notifier;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('ping')
            ->setDescription('Ping some host and send notification if the host unreached');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pingedHosts = [];

        $hosts = $this->hosts;
        foreach ($hosts as $host) {
            $ping = new Ping($host);
            $latency = $ping->ping();
            if ($latency === false) {
                $pingedHosts[$host] = null;
            } else {
                $pingedHosts[$host] = $latency;
            }
        }

        $this->notifier
            ->notify($pingedHosts);

        $output->writeln('Finished ping-ing all hosts');
        foreach ($pingedHosts as $host => $result) {
            $info = is_null($result) ? 'Unreachable' : "{$result}ms";
            $output->writeln("- {$host}: {$info}");
        }
    }
}
