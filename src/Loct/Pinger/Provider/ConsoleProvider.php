<?php
namespace Loct\Pinger\Provider;

use \Pimple\Container;
use \Pimple\ServiceProviderInterface;
use \Symfony\Component\Console\Application;

/**
 * Service provider for console related classes and parameters.
 *
 * @author herloct <herloct@gmail.com>
 */
class ConsoleProvider implements ServiceProviderInterface
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
        $pimple['console'] = function ($pimple)
        {
            $command = $pimple['ping_command'];

            $application = new Application($pimple['app_name'], $pimple['app_version']);
            $application->add($command);

            return $application;
        };
    }
}
