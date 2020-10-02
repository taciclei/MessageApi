<?php

namespace App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class Kernel
{
    /**
     * @var ContainerBuilder
     */
    private  $sevice;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        $this->sevice = $this->configureContainer();

    }


    protected function configureContainer()
    {
        $containerBuilder = new ContainerBuilder();
        $loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__));
        $loader->load('services.php');
        $containerBuilder->compile();

        return $containerBuilder;
    }

    /**
     * @return ContainerBuilder
     */
    public function getSevice()
    {
        return $this->sevice;
    }
}