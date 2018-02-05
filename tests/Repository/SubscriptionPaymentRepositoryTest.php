<?php

namespace Tests\AppBundle\Repository;

use AppBundle\Repository\SubscriptionPaymentRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests for `SubscriptionPaymentRepository` Doctrine ORM repository.
 *
 * @package Tests\AppBundle\Repository
 * @author  Krzysztof Trzos
 */
class SubscriptionPaymentRepositoryTest extends KernelTestCase
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
                SubscriptionPaymentRepository::class,
                EntityRepository::class
            )
        );
    }
}