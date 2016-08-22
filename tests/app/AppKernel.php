<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\SerializerBundle\JMSSerializerBundle;
use Speicher210\FastbillBundle\Speicher210FastbillBundle;
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
            new Speicher210FastbillBundle(),
            new JMSSerializerBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(dirname(__FILE__).'/config.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return sys_get_temp_dir().'/Speicher210FastbillBundle/Cache/';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return sys_get_temp_dir().'/Speicher210FastbillBundle/Log/';
    }
}
