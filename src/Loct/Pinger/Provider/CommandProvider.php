<?php
namespace Loct\Pinger\Provider;

use \Loct\Pinger\Command\PingCommand;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

/**
 * Service provider for command related classes and parameters.
 *
 * @author herloct <herloct@gmail.com>
 */
class CommandProvider implements ServiceProviderInterface
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
        $pimple['ping_command'] = function ($pimple)
        {
            $config = $pimple['config'];

            $hosts = $config->get('pinger.hosts');
            $notifier = $pimple['notifier'];

            return new PingCommand($hosts, $notifier);
        };
    }
}
