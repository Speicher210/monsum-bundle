<?php

namespace Speicher210\MonsumBundle\Test\Controller\CustomerController\ChangedAction;

use Speicher210\Monsum\Api\Model\Notification\Customer\Customer;
use Speicher210\Monsum\Api\Model\Notification\Customer\CustomerChangedNotification;
use Speicher210\MonsumBundle\Event\CustomerChangedEvent;
use Speicher210\MonsumBundle\MonsumNotificationEvents;
use Speicher210\MonsumBundle\Test\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Test case for customer changed notification.
 */
class CustomerChangedActionControllerTest extends AbstractControllerTestCase
{
    public function testChangedActionReturns204AndRaisesEventIfRequestIsValid()
    {
        $client = parent::createClient();

        $mock = $this->createPartialMock('stdClass', array('eventHandlerCallback'));
        $mock->expects(static::once())->method('eventHandlerCallback')->with(
            static::callback(function (CustomerChangedEvent $event) {
                $payloadData = $event->getPayloadData();
                static::assertNotNull($payloadData);

                $expectedPayloadData = new CustomerChangedNotification();
                $expectedPayloadData
                    ->setId(398154)
                    ->setType('customer.changed')
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
            ->addListener(MonsumNotificationEvents::INCOMING_CUSTOMER_CHANGED, array($mock, 'eventHandlerCallback'));

        $data = file_get_contents(__DIR__ . '/Fixtures/' . $this->getName() . '.json');
        $client = $this->makeRequest('speicher210_monsum_notification_customer_changed', $data, $client);

        static::assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
