<?php

namespace Speicher210\FastbillBundle\Command;

use Speicher210\Fastbill\Api\Service\Customer\Get\RequestData;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Command to reset the Fastbill account.
 */
class ResetAccountCommand extends ContainerAwareCommand
{
    /**
     * The input.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * The output.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sp210:fastbill:reset')
            ->setDescription('Reset (delete) the data from the Fastbill account')
            ->addOption(
                'reset-customers',
                null,
                InputOption::VALUE_NONE,
                'Flag if the customers should be reset'
            )
            ->addOption(
                'id',
                null,
                InputOption::VALUE_REQUIRED,
                'Customer ID to reset'
            )
            ->addOption(
                'ext-id',
                null,
                InputOption::VALUE_REQUIRED,
                'Optional external ID'
            )
            ->addOption(
                'skip-id',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Customer ID to skip'
            )
            ->addOption(
                'skip-ext-id',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Customer external ID to skip'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $noInteraction = $input->getOption('no-interaction');
        if ($noInteraction !== true) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion(
                '<question>Are you sure you want to reset the Fastbill data?</question> [N]: ',
                false
            );

            if (!$helper->ask($input, $output, $question)) {
                $output->writeln('Aborting.');

                return;
            }
        }

        if ($noInteraction === true || $input->getOption('reset-customers')) {
            $this->resetCustomers();
        }
    }

    /**
     * Reset all customers including subscriptions, but not invoices.
     */
    protected function resetCustomers()
    {
        /** @var \Speicher210\Fastbill\Api\Service\Customer\CustomerService $customerService */
        $customerService = $this->getContainer()->get('speicher210_fastbill.service.customer');
        $requestData = new RequestData();
        $requestData->setCustomerId($this->input->getOption('id'));
        $requestData->setCustomerExternalUid($this->input->getOption('ext-id'));
        $apiResponse = $customerService->getCustomers($requestData);
        $customers = $apiResponse->getResponse()->getCustomers();

        $idsToSkip = $this->input->getOption('skip-id');
        $externalIdsToSkip = $this->input->getOption('skip-ext-id');

        if (count($customers) === 0) {
            $this->output->writeln('<info>No customers to reset.</info>');

            return;
        }

        foreach ($customers as $customer) {
            if (in_array($customer->getCustomerId(), $idsToSkip)
                || in_array($customer->getCustomerExternalUid(), $externalIdsToSkip)
            ) {
                $infoMsg = sprintf(
                    '<info>Skipping resetting customer %s (ext. id: %s)</info>',
                    $customer->getCustomerId(),
                    $customer->getCustomerExternalUid()
                );
                $this->output->writeln($infoMsg);

                continue;
            }
            $infoMsg = sprintf(
                '<info>Deleting customer %s (ext. id: %s)</info>',
                $customer->getCustomerId(),
                $customer->getCustomerExternalUid()
            );
            $this->output->writeln($infoMsg);

            $customerService->deleteCustomer($customer->getCustomerId());
        }
    }
}
