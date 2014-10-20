<?php
namespace Loct\Pinger\Command;

use \Symfony\Component\Console\Command\Command;
use \Symfony\Component\Console\Input\InputInterface;
use \Symfony\Component\Console\Output\OutputInterface;
use \Loct\Pinger\PingFactory;
use \Loct\Pinger\Notifier\NotifierInterface;

/**
 * Ping registered hosts and send notification.
 *
 * @author herloct <herloct@gmail.com>
 */
class PingCommand extends Command
{

    /**
     *
     * @var Loct\Pinger\Notifier\NotifierInterface
     */
    private $notifier = null;

    /**
     * Array of hosts
     *
     * @var string[]
     */
    private $hosts = [];

    /**
     * Constructor.
     *
     * @param PingFactory       $factory  PingFactory
     * @param NotifierInterface $notifier Notifier
     * @param string[]          $hosts    Array of host
     */
    public function __construct(NotifierInterface $notifier, array $hosts)
    {
        $this->notifier = $notifier;
        $this->hosts = $hosts;

        parent::__construct();
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('ping')
            ->setDescription('Ping some host and send notification if the host unreached');
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int     null or 0 if everything went fine, or an error code
     *
     * @throws \LogicException When this abstract method is not implemented
     * @see    setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pingedHosts = [];

        $hosts = $this->hosts;
        foreach ($hosts as $host) {
            $latency = $this->ping($host);
            $pingedHosts[$host] = $latency === false ? null : $latency;
        }

        $this->notifier
            ->notify($pingedHosts);

        $output->writeln('<info>Finished ping-ing all hosts</info>');
        $output->writeln('');

        $table = $this->getHelper('table');
        $table->setHeaders(['Host', 'Status', 'Latency']);

        foreach ($pingedHosts as $host => $result) {
            $table->addRow([
                $host,
                is_null($result) ? '<fg=red>failed</fg=red>' : 'success',
                is_null($result) ? '-' : "{$result}ms"
            ]);
        }

        $table->render($output);
    }

    protected function extractHostAndPort($source)
    {
        $host = $source;
        $port = 80;
        $parts = explode(':', $source);

        if (count($parts) === 2) {
            $host = $parts[0];
            $port = $parts[1];
        }

        return ['host' => $host, 'port' => $port];
    }

    /**
     * Ping the host
     *
     * @param string $host Host to ping
     * @return boolean
     */
    protected function ping($host) {
        $parts = $this->extractHostAndPort($host);

        $starttime = microtime(true);
        $file      = @fsockopen ($parts['host'], $parts['port'], $errno, $errstr, 10);
        $stoptime  = microtime(true);
        $status    = 0;

        if (!$file) {
            $status = false;  // Site is down
        } else {
            fclose($file);
            $status = ($stoptime - $starttime) * 1000;
            $status = floor($status);
        }
        return $status;
    }
}
