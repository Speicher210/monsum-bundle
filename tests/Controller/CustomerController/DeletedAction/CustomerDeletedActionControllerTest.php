<?php

namespace Speicher210\MonsumBundle\Test\Controller\CustomerController\DeletedAction;

use Speicher210\Monsum\Api\Model\Notification\Customer\Customer;
use Speicher210\Monsum\Api\Model\Notification\Customer\CustomerDeletedNotification;
use Speicher210\MonsumBundle\Event\CustomerDeletedEvent;
use Speicher210\MonsumBundle\MonsumNotificationEvents;
use Speicher210\MonsumBundle\Test\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Test case for customer deleted notification.
 */
class CustomerDeletedActionControllerTest extends AbstractControllerTestCase
{
    public function testDeletedActionReturns204AndRaisesEventIfRequestIsValid()
    {
        $client = parent::createClient();

        $mock = $this->getMock('stdClass', array('eventHandlerCallback'));
        $mock->expects(static::once())->method('eventHandlerCallback')->with(
            static::callback(function (CustomerDeletedEvent $event) {
                $payloadData = $event->getPayloadData();
                static::assertNotNull($payloadData);

                $expectedPayloadData = new CustomerDeletedNotification();
                $expectedPayloadData
                    ->setId(398154)
                    ->setType('customer.deleted')
                    ->setCustomer(
                        (new Customer())
                            ->setCustomerId(578266)
                            ->setCustomerExternalId('id_007')
                            ->setHash('hash123')
                            ->setCustomerNumber('cn_77')
                            ->setCompanyName('Muster GmbH')
                            ->setTitle('Dr.')
                            ->setSalutation('Herr')
                            ->setFirstName('Martin')
                            ->setLastName('Muster')
                            ->setAddress('Am Musterhuegel 12')
                            ->setZipCode('01234')
                            ->setCity('Musterhausen')
                            ->setCountryCode('DE')
                            ->setPhone('+491234567')
                            ->setEmail('m.muster@email.de')
                            ->setPaymentDataUrl('https://app.monsum.com/accountdata/a1/payment_data_url')
                            ->setDashboardUrl('https://app.monsum.com/dashboard/a1/dashboard_url')
                    );

                static::assertEquals($expectedPayloadData, $payloadData);

                return true;
            })
        );
        $client
            ->getContainer()
            ->get('event_dispatcher')
            ->addListener(MonsumNotificationEvents::INCOMING_CUSTOMER_DELETED, array($mock, 'eventHandlerCallback'));

        $data = file_get_contents(__DIR__ . '/Fixtures/' . $this->getName() . '.json');
        $client = $this->makeRequest('speicher210_monsum_notification_customer_deleted', $data, $client);

        static::assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
