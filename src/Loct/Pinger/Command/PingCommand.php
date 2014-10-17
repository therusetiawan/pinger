<?php
namespace Loct\Pinger\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \JJG\Ping;

class PingCommand extends Command
{

    /**
     * Array of hosts
     *
     * @var string[]
     */
    private $hosts = [];

    /**
     * Get Array of hosts
     *
     * @return string[] Array of hosts
     */
    protected function getHosts()
    {
        return $this->hosts;

        print_r($this->hosts);
    }

    /**
     *
     * @param string[] $hosts
     */
    public function __construct(array $hosts)
    {
        $this->hosts = $hosts;

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

        $hosts = $this->getHosts();
        foreach ($hosts as $host) {
            $ping = new Ping($host);
            $latency = $ping->ping();
            if ($latency === false) {
                $pingedHosts[$host] = null;
            } else {
                $pingedHosts[$host] = $latency;
            }
        }

        $output->writeln('Finished ping-ing all hosts');
        foreach ($pingedHosts as $host => $result) {
            $info = is_null($result) ? 'Unreachable' : "{$result}ms";
            $output->writeln("- {$host}: {$info}");
        }
    }
}
