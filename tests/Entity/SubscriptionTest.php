<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Subscription;

/**
 * Test for `Subscription` entity type.
 *
 * @package Tests\AppBundle\Entity
 * @author  Krzysztof Trzos
 */
class SubscriptionTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    /**
     * Test basics.
     *
     * @return void
     */
    public function testBasics(): void
    {
        $entity = new Subscription();

        self::assertTrue(method_exists($entity, 'getId'));
        self::assertTrue(method_exists($entity, 'getUserId'));
        self::assertTrue(method_exists($entity, 'setUserId'));
        self::assertTrue(method_exists($entity, 'getShippingAddress'));
        self::assertTrue(method_exists($entity, 'setShippingAddress'));
        self::assertTrue(method_exists($entity, 'getBillingAddress'));
        self::assertTrue(method_exists($entity, 'setBillingAddress'));
        self::assertTrue(method_exists($entity, 'getStatus'));
        self::assertTrue(method_exists($entity, 'setStatus'));
        self::assertTrue(method_exists($entity, 'getPack'));
        self::assertTrue(method_exists($entity, 'setPack'));
        self::assertTrue(method_exists($entity, 'getStartedAt'));
        self::assertTrue(method_exists($entity, 'setStartedAt'));
        self::assertTrue(method_exists($entity, 'getUpdatedAt'));
        self::assertTrue(method_exists($entity, 'setUpdatedAt'));
        self::assertTrue(method_exists($entity, 'getCreatedAt'));
        self::assertTrue(method_exists($entity, 'getPayments'));

        self::assertFalse(method_exists($entity, 'setId'));
        self::assertFalse(method_exists($entity, 'setCreatedAt'));
        self::assertNotNull($entity->getCreatedAt());

        self::assertInstanceOf(\Doctrine\Common\Collections\Collection::class, $entity->getPayments());
    }

    /**
     * Check whether `setStatus()` method has proper value limitations.
     *
     * @param string $statusValue
     * @param bool   $isValid
     * @dataProvider dataStatusSet
     */
    public function testStatusSet(string $statusValue, bool $isValid): void
    {
        if(false === $isValid) {
            $this->expectException(\InvalidArgumentException::class);
        }

        $entity = new Subscription();
        $entity->setStatus($statusValue);

        self::assertSame($entity->getStatus(), $statusValue);
    }

    /**
     * Data provider for `testStatusSet()` testing method.
     *
     * @return \Generator
     */
    public function dataStatusSet(): \Generator
    {
        yield ['new', true];
        yield ['active', true];
        yield ['cancelled', true];
        yield ['not_active', false];
        yield ['xyz', false];
    }

    /**
     * Test `Subscription` entity type metadata.
     *
     * @return void
     */
    public function testMetadata(): void
    {
        self::bootKernel();

        $manager     = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $meta        = $manager->getClassMetadata(Subscription::class);
        $fields      = $meta->getFieldNames();
        $assocations = $meta->getAssociationNames();

        self::assertContains('id', $fields);
        self::assertContains('userId', $fields);
        self::assertContains('shippingAddress', $fields);
        self::assertContains('billingAddress', $fields);
        self::assertContains('status', $fields);
        self::assertContains('pack', $fields);
        self::assertContains('startedAt', $fields);
        self::assertContains('updatedAt', $fields);
        self::assertContains('createdAt', $fields);
        self::assertCount(9, $fields);

        self::assertCount(1, $assocations);
        self::assertContains('payments', $assocations);
    }
}