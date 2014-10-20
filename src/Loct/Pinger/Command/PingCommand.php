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
     * @var Loct\Pinger\PingFactory
     */
    private $factory = null;

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
    public function __construct(PingFactory $factory, NotifierInterface $notifier, array $hosts)
    {
        $this->factory = $factory;
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

        $factory = $this->factory;
        $hosts = $this->hosts;
        foreach ($hosts as $host) {
            $ping = $factory->createPing($host);
            $latency = $ping->ping();
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
}
