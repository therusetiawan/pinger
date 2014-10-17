<?php
namespace Loct\Pinger\Provider;

use \Illuminate\Config\FileLoader;
use \Illuminate\Config\Repository;
use \Illuminate\Filesystem\Filesystem;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

class ConfigProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['config_path'] = function ($pimple) {
            return $pimple['app_path'] . '/config';
        };

        $pimple['environment'] = function ($pimple) {
            return file_exists($pimple['config_path'] . '/dev') ? 'dev' : 'production';
        };

        $pimple['config'] = function ($pimple) {
            $filesystem = new Filesystem();
            $loader = new FileLoader($filesystem, $pimple['config_path']);

            return new Repository($loader, $pimple['environment']);
        };
    }

}