<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Winebuyers\SyliusSendgridPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('winebuyers_sylius_sendgrid');

        $rootNode
            ->children()
                ->scalarNode('sender_adapter')->defaultValue('sylius.email_sender.adapter.swiftmailer')->end()
                ->scalarNode('renderer_adapter')->defaultValue('sylius.email_renderer.adapter.twig')->end()
            ->end()
        ;

        $this->addEmailsSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addEmailsSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('sender')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('name')->defaultValue('Example.com Store')->end()
                        ->scalarNode('address')->defaultValue('no-reply@example.com')->end()
                    ->end()
                ->end()
                ->arrayNode('emails')
                    ->useAttributeAsKey('code')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('subject')->cannotBeEmpty()->end()
                            ->scalarNode('template')->cannotBeEmpty()->end()
                            ->scalarNode('transformer')->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->arrayNode('sender')
                                ->children()
                                    ->scalarNode('name')->end()
                                    ->scalarNode('address')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('templates')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;
    }
}
