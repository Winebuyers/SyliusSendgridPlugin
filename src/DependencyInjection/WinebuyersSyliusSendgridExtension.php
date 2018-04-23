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
    public function load(array $config, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (array_key_exists('SyliusMailerBundle', $bundles)) {
            $this->loadServices($config, $container);
            $this->loadMailerConfig($config, $container);                        
        }
    }

    private function loadServices(array $config, ContainerBuilder $container): void
    {
        // $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $configFiles = [
            'services.yml',
        ];
        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }
    }

    private function loadMailerConfig(array $config, ContainerBuilder $container): void
    {
        $mailer_config = Yaml::parseFile(__DIR__ . '/../Resources/config/mailer.yml');

        $container->setParameter('sylius.mailer.sender_name', $mailer_config['sender']['name']);
        $container->setParameter('sylius.mailer.sender_address', $mailer_config['sender']['address']);
        $container->setParameter('sylius.mailer.emails', $mailer_config['emails']);
    }
}
