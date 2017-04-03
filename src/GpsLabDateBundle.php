<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */

namespace GpsLab\Bundle\DateBundle;

use GpsLab\Bundle\DateBundle\DependencyInjection\Compiler\TimeZoneResolverPass;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GpsLabDateBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TimeZoneResolverPass());
    }

    /**
     * @return ExtensionInterface|null
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = false;
            $class = $this->getContainerExtensionClass();

            if (class_exists($class)) {
                $extension = new $class();

                if ($extension instanceof ExtensionInterface) {
                    $this->extension = $extension;
                }
            }
        }

        return $this->extension ?: null;
    }
}
