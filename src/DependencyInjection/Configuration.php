<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Config tree builder.
     *
     * Example config:
     *
     * gpslab_date:
     *     time_zone: 'Europe/Moscow'
     *     cookie:
     *         used: true
     *         name: '_time_zone_name'
     *         offset: '_time_zone_offset'
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        return (new TreeBuilder())
            ->root('gpslab_date')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('time_zone')
                ->end()
                ->arrayNode('cookie')
                    ->children()
                        ->scalarNode('used')
                            ->defaultValue(true)
                        ->end()
                        ->scalarNode('name')
                            ->cannotBeEmpty()
                            ->defaultValue('_time_zone_name')
                        ->end()
                        ->scalarNode('offset')
                            ->cannotBeEmpty()
                            ->defaultValue('_time_zone_offset')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
