<?php

namespace Tests\AppBundle\EventListener;

use AppBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Testing event listener which operates on entities dates.
 *
 * @package Tests\AppBundle\EventListener
 * @author  Krzysztof Trzos
 */
class DateEventListenerTest extends KernelTestCase
{
    /**
     * Test whether event listener is updating value of `updatedAt` field from
     * all types of entities.
     *
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function testUpdateDate(): void
    {
        self::bootKernel();

        $manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $subscription = new Subscription();
        $subscription->setPack(123);
        $subscription->setBillingAddress(1);
        $subscription->setShippingAddress(1);
        $subscription->setUserId(1);

        $subPayment = new \AppBundle\Entity\SubscriptionPayment();
        $subPayment->setSubscription($subscription);
        $subPayment->setDate(new \DateTime('2018-01-02'));
        $subPayment->setChargedAmount(12300);

        $manager->persist($subscription);
        $manager->persist($subPayment);

        $manager->flush();

        self::assertNull($subscription->getUpdatedAt());
        self::assertNull($subPayment->getUpdatedAt());

        $subscription->setPack(2);
        $subPayment->setChargedAmount(10020);

        $manager->flush();

        self::assertInstanceOf(\DateTime::class, $subscription->getUpdatedAt());
        self::assertInstanceOf(\DateTime::class, $subPayment->getUpdatedAt());
    }
}