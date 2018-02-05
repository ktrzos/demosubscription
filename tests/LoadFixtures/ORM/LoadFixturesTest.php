<?php

namespace Tests\AppBundle\LoadFixtures\ORM;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test basic fixtures.
 *
 * @package Tests\AppBundle\LoadFixtures\ORM
 * @author  Krzysztof Trzos
 */
class LoadFixturesTest extends KernelTestCase
{
    /**
     * Test whether proper amount of entities were added by fixtures.
     *
     * @return void
     */
    public function testAmount(): void
    {
        self::bootKernel();

        $manager = self::$kernel
            ->getContainer()
            ->get('doctrine.orm.entity_manager');

        self::assertCount(3, $manager->getRepository('AppBundle:Subscription')->findAll());
        self::assertCount(3, $manager->getRepository('AppBundle:SubscriptionPayment')->findAll());
    }
}