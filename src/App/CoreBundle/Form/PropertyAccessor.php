<?php

namespace App\CoreBundle\Form;

use Psr\Cache\CacheItemPoolInterface;

/**
 * PropertyAccessor allowing magic method __call to be executed in Symfony\Component\PropertyAccessor
 * So we can work with DoctrineBehaviors Bundle.
 * Registered as Service in AdminBundle services with name: property_accessor
 * Class PropertyAccessor
 * @package App\CoreBundle\Form
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class PropertyAccessor extends \Symfony\Component\PropertyAccess\PropertyAccessor
{
    /**
     * PropertyAccessor constructor.
     * @param bool $magicCall
     * @param bool $throwExceptionOnInvalidIndex
     * @param CacheItemPoolInterface|null $cacheItemPool
     */
    public function __construct(
        $magicCall = false,
        $throwExceptionOnInvalidIndex = false,
        CacheItemPoolInterface $cacheItemPool = null)
    {
        parent::__construct($magicCall, $throwExceptionOnInvalidIndex, $cacheItemPool);
    }


}