<?php

namespace Speicher210\FastbillBundle\Command;

use Speicher210\Fastbill\Api\Service\Customer\Get\RequestData;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for listing customers.
 */
class CustomerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('sp210:fastbill:customer')
            ->setDescription('List information about the customers.')
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'Optional Fastbill customer ID')
            ->addOption('ext-id', null, InputOption::VALUE_REQUIRED, 'Optional external ID');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Speicher210\Fastbill\Api\Service\Customer\CustomerService $customerService */
        $customerService = $this->getContainer()->get('speicher210_fastbill.service.customer');

        $requestData = new RequestData();
        $requestData->setCustomerId($input->getOption('id'));
        $requestData->setCustomerExternalUid($input->getOption('ext-id'));
        $apiResponse = $customerService->getCustomers($requestData);
        $customers = $apiResponse->getResponse()->getCustomers();

        $table = new Table($output);
        $table->setHeaders(
            array(
                'ID',
                'External ID',
                'Create data',
                'Name',
                'Organization',
                'Email',
                'Phone',
                'Comment',
                'Last update',
            )
        );

        foreach ($customers as $customer) {
            $table->addRow(
                array(
                    $customer->getCustomerId(),
                    $customer->getCustomerExternalUid(),
                    $customer->getCreated() ? $customer->getCreated()->format(\DateTime::W3C) : null,
                    $customer->getFirstName().' '.$customer->getLastName(),
                    $customer->getOrganization(),
                    $customer->getEmail(),
                    $customer->getPhone(),
                    $customer->getComment(),
                    $customer->getLastUpdate() ? $customer->getLastUpdate()->format(\DateTime::W3C) : null,
                )
            );
        }

        $table->render();
    }
}
