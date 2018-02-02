<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Main application fixtures.
 *
 * @package AppBundle\DataFixtures\ORM
 * @author  Krzysztof Trzos
 */
class LoadFixtures extends AbstractFixture implements FixtureInterface
{
    /** @inheritdoc */
    public function load(ObjectManager $manager): void
    {
        # create subscriptions
        $subscription1 = new Entity\Subscription();
        $subscription1->setUserId(1);
        $subscription1->setShippingAddress(1);
        $subscription1->setBillingAddress(1);
        $subscription1->setStatus(Entity\Subscription::STATUS_NEW);
        $subscription1->setPack(1);

        $subscription2 = new Entity\Subscription();
        $subscription2->setUserId(2);
        $subscription2->setShippingAddress(2);
        $subscription2->setBillingAddress(2);
        $subscription2->setStatus(Entity\Subscription::STATUS_ACTIVE);
        $subscription2->setPack(2);
        $subscription2->setStartedAt(new \DateTime('2017-04-01'));

        $subscription3 = new Entity\Subscription();
        $subscription3->setUserId(3);
        $subscription3->setShippingAddress(3);
        $subscription3->setBillingAddress(3);
        $subscription3->setStatus(Entity\Subscription::STATUS_ACTIVE);
        $subscription3->setPack(7);
        $subscription3->setStartedAt(new \DateTime('2017-04-15'));

        $manager->persist($subscription1);
        $manager->persist($subscription2);
        $manager->persist($subscription3);

        # create subscriptions payments
        $payment1 = new Entity\SubscriptionPayment();
        $payment1->setSubscription($subscription2);
        $payment1->setChargedAmount(2400);
        $payment1->setDate(new \DateTime('2017-04-01'));

        $payment2 = new Entity\SubscriptionPayment();
        $payment2->setSubscription($subscription2);
        $payment2->setChargedAmount(1700);
        $payment2->setDate(new \DateTime('2017-05-01'));

        $payment3 = new Entity\SubscriptionPayment();
        $payment3->setSubscription($subscription3);
        $payment3->setChargedAmount(3600);
        $payment3->setDate(new \DateTime('2017-04-15'));

        $manager->persist($payment1);
        $manager->persist($payment2);
        $manager->persist($payment3);

        # flush all data
        $manager->flush();
    }
}