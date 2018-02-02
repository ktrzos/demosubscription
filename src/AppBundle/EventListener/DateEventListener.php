<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Event listener listening on Doctrine events and operating on fields which
 * values are instances of `\DateTime` class.
 *
 * @package AppBundle\EventListener
 * @author  Krzysztof Trzos
 */
class DateEventListener
{
    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if(method_exists($entity, 'setUpdatedAt')) {
            $entity->setUpdatedAt(new \DateTime('now'));
        }
    }
}