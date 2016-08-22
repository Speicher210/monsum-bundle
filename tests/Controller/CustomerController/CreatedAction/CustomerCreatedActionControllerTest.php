<?php

namespace Speicher210\FastbillBundle\Test\Controller\CustomerController\CreatedAction;

use Speicher210\Fastbill\Api\Model\Notification\Customer\Customer;
use Speicher210\Fastbill\Api\Model\Notification\Customer\CustomerCreatedNotification;
use Speicher210\FastbillBundle\Event\CustomerCreatedEvent;
use Speicher210\FastbillBundle\FastbillNotificationEvents;
use Speicher210\FastbillBundle\Test\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Test case for customer created notification.
 */
class CustomerCreatedActionControllerTest extends AbstractControllerTestCase
{
    public function testCreatedActionReturns204AndRaisesEventIfRequestIsValid()
    {
        $client = parent::createClient();

        $mock = $this->getMock('stdClass', array('eventHandlerCallback'));
        $mock->expects($this->once())->method('eventHandlerCallback')->with(
            $this->callback(function (CustomerCreatedEvent $event) {
                $payloadData = $event->getPayloadData();
                $this->assertNotNull($payloadData);

                $expectedPayloadData = new CustomerCreatedNotification();
                $expectedPayloadData
                    ->setId(398154)
                    ->setType('customer.created')
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
                            ->setPaymentDataUrl('https://automatic.fastbill.com/accountdata/a1/payment_data_url')
                            ->setDashboardUrl('https://automatic.fastbill.com/dashboard/a1/dashboard_url')
                    );

                $this->assertEquals($expectedPayloadData, $payloadData);

                return true;
            })
        );
        $client
            ->getContainer()
            ->get('event_dispatcher')
            ->addListener(FastbillNotificationEvents::INCOMING_CUSTOMER_CREATED, array($mock, 'eventHandlerCallback'));

        $data = file_get_contents(__DIR__ . '/Fixtures/' . $this->getName() . '.json');
        $client = $this->makeRequest('speicher210_fastbill_notification_customer_created', $data, $client);

        $this->assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
