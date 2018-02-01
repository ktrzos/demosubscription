<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityRepository;

/**
 * Class SubscriptionRepositoryTest
 *
 * @package Tests\AppBundle\Repository
 * @author  Krzysztof Trzos
 */
class SubscriptionRepositoryTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    /**
     * Basic assertions.
     *
     * @return void
     */
    public function testBasics(): void
    {
        self::assertTrue(
            is_subclass_of(
                SubscriptionRepository::class,
                EntityRepository::class
            )
        );
    }
}