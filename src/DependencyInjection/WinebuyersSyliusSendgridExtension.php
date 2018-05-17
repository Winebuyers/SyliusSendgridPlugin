<?php

declare (strict_types = 1);

namespace Winebuyers\SyliusSendgridPlugin\DependencyInjection;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class WinebuyersSyliusSendgridExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configDir = __DIR__ . '/../Resources/config';

        // Load the config file
        $configFile = $configDir . '/config.yml';
        $configDefault = Yaml::parse(file_get_contents($configFile));
        $configs[$this->getAlias()] = array_merge($configDefault[$this->getAlias()], $configs[0]);
        unset($configs[0]);

        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        // Bind the services
        $loader = new YamlFileLoader($container, new FileLocator($configDir));
        $loader->load('services.yml');

        // Replace Sylius config
        $container->setParameter('sylius.mailer.emails', $config['emails']);
    }
 
}
