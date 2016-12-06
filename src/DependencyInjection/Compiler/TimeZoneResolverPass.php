<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TimeZoneResolverPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('gpslab.date.tz.resolver')) {
            return;
        }

        $resolvers = [];
        foreach ($container->findTaggedServiceIds('gpslab.date.tz.resolver') as  $id => $attributes) {
            $resolvers[] = [
                'id' => $id,
                'attributes' => $attributes[0],
            ];
        }

        usort($resolvers, function ($a, $b) {
            return $this->sort($a, $b);
        });

        $definition = $container->findDefinition('gpslab.date.tz.resolver');
        foreach ($resolvers as $resolver) {
            $definition->addMethodCall('addResolver', [new Reference($resolver['id'])]);
        }
    }

    /**
     * @param array $a
     * @param array $b
     *
     * @return int
     */
    protected function sort($a, $b)
    {
        $a = isset($a['attributes']['priority']) ? $a['attributes']['priority'] : 0;
        $b = isset($b['attributes']['priority']) ? $b['attributes']['priority'] : 0;

        return $a < $b ? -1 : ($a > $b ? 1 : 0);
    }
}
