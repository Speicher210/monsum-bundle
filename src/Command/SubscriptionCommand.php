<?php

namespace Speicher210\FastbillBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for listing customers.
 */
class SubscriptionCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sp210:fastbill:subscription')
            ->setDescription('List information about the subscriptions.')
            ->addOption('customer-id', null, InputOption::VALUE_REQUIRED, 'Optional Fastbill customer ID')
            ->addOption('customer-ext-id', null, InputOption::VALUE_REQUIRED, 'Optional customer external ID')
            ->addOption('subscription-id', null, InputOption::VALUE_REQUIRED, 'Optional subscription ID')
            ->addOption('subscription-ext-id', null, InputOption::VALUE_REQUIRED, 'Optional subscription external ID');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Speicher210\Fastbill\Api\Service\Subscription\SubscriptionService $subscriptionService */
        $subscriptionService = $this->getContainer()->get('speicher210_fastbill.service.subscription');

        $apiResponse = $subscriptionService->getSubscriptions(
            $input->getOption('customer-id'),
            $input->getOption('customer-ext-id'),
            $input->getOption('subscription-ext-id'),
            $input->getOption('subscription-id')
        );
        $subscriptions = $apiResponse->getResponse()->getSubscriptions();

        $table = new Table($output);
        $table->setHeaders(
            array(
                'ID',
                'External ID',
                'Start data',
                'Expiration date',
                'Next event',
                'Status',
                'Article number',
                'Customer ID',
            )
        );

        foreach ($subscriptions as $subscription) {
            $table->addRow(
                array(
                    $subscription->getSubscriptionId(),
                    $subscription->getSubscriptionExternalId(),
                    $subscription->getSubscriptionStart()->format(\DateTime::W3C),
                    $subscription->getExpirationDate()->format(\DateTime::W3C),
                    $subscription->getNextEvent() ? $subscription->getNextEvent()->format(\DateTime::W3C) : null,
                    $subscription->getStatus(),
                    $subscription->getArticleNumber(),
                    $subscription->getCustomerId(),
                )
            );
        }

        $table->render();
    }
}
