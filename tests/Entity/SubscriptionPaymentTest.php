<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\SubscriptionPayment;

/**
 * Tests for `SubscriptionPayment` entity type.
 *
 * @package Tests\AppBundle\Entity
 * @author  Krzysztof Trzos
 */
class SubscriptionPaymentTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    /**
     * Test basics.
     *
     * @return void
     */
    public function testBasics(): void
    {
        $entity = new SubscriptionPayment();

        self::assertTrue(method_exists($entity, 'getId'));
        self::assertTrue(method_exists($entity, 'getSubscription'));
        self::assertTrue(method_exists($entity, 'setSubscription'));
        self::assertTrue(method_exists($entity, 'getChargedAmount'));
        self::assertTrue(method_exists($entity, 'setChargedAmount'));
        self::assertTrue(method_exists($entity, 'getDate'));
        self::assertTrue(method_exists($entity, 'setDate'));
        self::assertTrue(method_exists($entity, 'getUpdatedAt'));
        self::assertTrue(method_exists($entity, 'setUpdatedAt'));
        self::assertTrue(method_exists($entity, 'getCreatedAt'));

        self::assertFalse(method_exists($entity, 'setId'));
        self::assertFalse(method_exists($entity, 'setCreatedAt'));
        self::assertNotNull($entity->getCreatedAt());
    }

    /**
     * Test `Subscription` entity type metadata.
     *
     * @return void
     */
    public function testMetadata(): void
    {
        self::bootKernel();

        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $meta    = $manager->getClassMetadata(SubscriptionPayment::class);
        $fields  = $meta->getFieldNames();

        self::assertContains('id', $fields);
        self::assertContains('chargedAmount', $fields);
        self::assertContains('date', $fields);
        self::assertContains('updatedAt', $fields);
        self::assertContains('createdAt', $fields);
        self::assertCount(5, $fields);
    }
}