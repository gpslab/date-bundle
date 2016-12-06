<?php
/**
 * GpsLab component.
 *
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2016, Peter Gribanov
 * @license   http://opensource.org/licenses/MIT
 */
namespace GpsLab\Bundle\DateBundle\TimeZone\Resolver;

class ChainResolver
{
    /**
     * @var ResolverInterface[]
     */
    private $resolvers = [];

    /**
     * @param ResolverInterface $resolver
     *
     * @return ChainResolver
     */
    public function addResolver(ResolverInterface $resolver)
    {
        $this->resolvers[] = $resolver;

        return $this;
    }

    /**
     * @return ResolverInterface[]
     */
    public function getResolvers()
    {
        return $this->resolvers;
    }
}
