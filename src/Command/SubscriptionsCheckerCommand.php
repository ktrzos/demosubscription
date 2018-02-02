<?php

namespace AppBundle\Command;

use AppBundle\Entity\Subscription;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @package AppBundle\Command
 * @author  Krzysztof Trzos
 */
class SubscriptionsCheckerCommand extends ContainerAwareCommand
{
    /** @inheritdoc */
    protected function configure(): void
    {
        $this
            ->setName('app:subscriptions:checker')
            ->setDescription('Check subscriptions.');
    }

    /** @inheritdoc */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $manager = $this->getContainer()->get('doctrine')->getManager();

        # get list of subscriptions
        /* @var $subscriptions Subscription[] */
        $subscriptions = $manager
            ->getRepository('AppBundle:Subscription')
            ->findWithPaymentLessThan7Days();

        # change status of each found subscription
        foreach($subscriptions as $subscription) {
            $subscription->setStatus(Subscription::STATUS_CANCELLED);
        }

        $manager->flush();

        # display result message
        $output->writeln(
            sprintf('Cancelled %s subscriptions.', \count($subscriptions))
        );
    }
}