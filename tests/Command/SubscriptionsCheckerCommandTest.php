<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\SubscriptionsCheckerCommand;
use AppBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Testing system command.
 *
 * @package Tests\AppBundle\Command
 * @author  Krzysztof Trzos
 */
class SubscriptionsCheckerCommandTest extends KernelTestCase
{
    /**
     * Test basic functionality of "SubscriptionsChecker" command.
     *
     * @return void
     */
    public function testBasicFunctionality(): void
    {
        $kernel  = self::bootKernel();
        $manager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        # get amount of "active" subscriptions
        $activeSubscriptions = $manager
            ->getRepository('AppBundle:Subscription')
            ->findBy(['status' => Subscription::STATUS_ACTIVE]);

        $application = new Application($kernel);
        $application->add(new SubscriptionsCheckerCommand());

        $command = $application->find('app:subscriptions:checker');
        $tester  = new CommandTester($command);
        $tester->execute(['command' => $command->getName()]);

        $output = $tester->getDisplay();
        $this->assertSame("Cancelled 2 subscriptions.\n", $output);

        # check if statuses changed
        $activeSubscriptions2 = $manager
            ->getRepository('AppBundle:Subscription')
            ->findBy(['status' => Subscription::STATUS_ACTIVE]);

        # assert that those 2 subscriptions changed
        self::assertCount(
            \count($activeSubscriptions) - 2,
            $activeSubscriptions2
        );
    }
}