<?php

namespace Speicher210\MonsumBundle\Test\app;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\SerializerBundle\JMSSerializerBundle;
use Speicher210\MonsumBundle\Speicher210MonsumBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

/**
 * AppKernel for testing.
 */
class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();

        AnnotationRegistry::registerLoader('class_exists');
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new Speicher210MonsumBundle(),
            new JMSSerializerBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return sys_get_temp_dir() . '/Speicher210MonsumBundle/Cache/';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return sys_get_temp_dir() . '/Speicher210MonsumBundle/Log/';
    }
}
