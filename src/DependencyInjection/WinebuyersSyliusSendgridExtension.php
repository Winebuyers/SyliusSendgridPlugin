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
    public function load(array $config, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $configFiles = [
            'services.xml',
        ];

        foreach ($configFiles as $configFile) {
            $loader->load($configFile);
        }

        $container->setAlias('sylius.email_sender.adapter', $config['sender_adapter']);
        $container->setAlias('sylius.email_renderer.adapter', $config['renderer_adapter']);

        $container->setParameter('sylius.mailer.sender_name', $config['sender']['name']);
        $container->setParameter('sylius.mailer.sender_address', $config['sender']['address']);

        $templates = $config['templates'] ?? ['Default' => 'SyliusMailerBundle::default.html.twig'];

        $container->setParameter('sylius.mailer.emails', $config['emails']);
        $container->setParameter('sylius.mailer.templates', $templates);
    }
    // public function load(array $config, ContainerBuilder $container)
    // {
    //     $bundles = $container->getParameter('kernel.bundles');
    //     if (array_key_exists('SyliusMailerBundle', $bundles)) {
    //         $this->loadServices($config, $container);
    //         $this->loadMailerConfig($config, $container);                        
    //     }
    // }

    // private function loadServices(array $config, ContainerBuilder $container): void
    // {
    //     $configuration = new Configuration();
    //     $config = $this->processConfiguration($this->getConfiguration([], $container), $config);

    //     $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    //     $configFiles = [
    //         'services.yml'
    //     ];
    //     foreach ($configFiles as $configFile) {
    //         $loader->load($configFile);
    //     }
    // }

    // private function loadMailerConfig(array $config, ContainerBuilder $container): void
    // {
    //     $mailer_config = Yaml::parseFile(__DIR__ . '/../Resources/config/mailer.yml');

    //     $container->setParameter('sylius.mailer.sender_name', $mailer_config['sylius_mailer']['sender']['name']);
    //     $container->setParameter('sylius.mailer.sender_address', $mailer_config['sylius_mailer']['sender']['address']);
    //     $container->setParameter('sylius.mailer.emails', $mailer_config['sylius_mailer']['emails']);
    // }
}
