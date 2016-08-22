<?php

namespace Speicher210\FastbillBundle\Test\Controller\CustomerController\ChangedAction;

use Speicher210\Fastbill\Api\Model\Notification\Customer\Customer;
use Speicher210\Fastbill\Api\Model\Notification\Customer\CustomerChangedNotification;
use Speicher210\FastbillBundle\Event\CustomerChangedEvent;
use Speicher210\FastbillBundle\FastbillNotificationEvents;
use Speicher210\FastbillBundle\Test\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Test case for customer changed notification.
 */
class CustomerChangedActionControllerTest extends AbstractControllerTestCase
{
    public function testChangedActionReturns204AndRaisesEventIfRequestIsValid()
    {
        $client = parent::createClient();

        $mock = $this->getMock('stdClass', array('eventHandlerCallback'));
        $mock->expects($this->once())->method('eventHandlerCallback')->with(
            $this->callback(function (CustomerChangedEvent $event) {
                $payloadData = $event->getPayloadData();
                $this->assertNotNull($payloadData);

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
            ->addListener(FastbillNotificationEvents::INCOMING_CUSTOMER_CHANGED, array($mock, 'eventHandlerCallback'));

        $data = file_get_contents(__DIR__ . '/Fixtures/' . $this->getName() . '.json');
        $client = $this->makeRequest('speicher210_fastbill_notification_customer_changed', $data, $client);

        $this->assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
