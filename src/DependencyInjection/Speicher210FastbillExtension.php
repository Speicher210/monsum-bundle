<?php

namespace Speicher210\FastbillBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 */
class Speicher210FastbillExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        if ($container->getParameter('kernel.debug') === true) {
            $loader->load('collector.xml');
        }

        $container
            ->getDefinition('speicher210_fastbill.api_credentials')
            ->addArgument($config['username'])
            ->addArgument($config['api_key'])
            ->addArgument($config['account_hash']);
    }
}
