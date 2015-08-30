<?php

namespace Carlosv2\HermesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class HermesExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('carlosv2.configuration.keep_copy', $config['keep_copy']);
        $container->setParameter('carlosv2.configuration.prevent_delivery', $config['prevent_delivery']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('hermes.xml');

        $container->setAlias('mailer', 'carlosv2.hermesbundle.swiftmailer.proxy');
    }
}
