<?php

namespace Speicher210\FastbillBundle\Test\Controller\SubscriptionController\ReactivatedAction;

use Speicher210\Fastbill\Api\Model\Notification\Customer\Customer;
use Speicher210\Fastbill\Api\Model\Notification\Subscription\Subscription;
use Speicher210\Fastbill\Api\Model\Notification\Subscription\SubscriptionReactivatedNotification;
use Speicher210\FastbillBundle\Event\SubscriptionReactivatedEvent;
use Speicher210\FastbillBundle\FastbillNotificationEvents;
use Speicher210\FastbillBundle\Test\Controller\AbstractController\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionReactivatedActionControllerTest extends AbstractControllerTest
{
    public function testReactivatedActionReturns204AndRaisesEventIfRequestIsValid()
    {
        $client = parent::createClient();

        $mock = $this->getMock('stdClass', array('eventHandlerCallback'));
        $mock->expects($this->once())->method('eventHandlerCallback')->with(
            $this->callback(function (SubscriptionReactivatedEvent $event) {
                $payloadData = $event->getPayloadData();
                $this->assertNotNull($payloadData);

                $expectedPayloadData = new SubscriptionReactivatedNotification();
                $expectedPayloadData
                    ->setId(398154)
                    ->setType('subscription.reactivated')
                    ->setCreated(new \DateTime('2014-03-13T10:36:04', new \DateTimeZone('UTC')))
                    ->setCustomer(
                        (new Customer())
                            ->setCustomerId(578266)
                            ->setCustomerExternalId('id_007')
                            ->setCustomerNumber('cn_77')
                            ->setHash('hash123')
                            ->setCompanyName('Muster GmbH')
                            ->setTitle('Dr.')
                            ->setSalutation('Herr')
                            ->setFirstName('Martin')
                            ->setLastName('Muster')
                            ->setAddress('Am Musterhuegel 12')
                            ->setZipCode('01234')
                            ->setCity('Musterhausen')
                            ->setCountryCode('DE')
                            ->setEmail('m.muster@email.de')
                            ->setPaymentDataUrl('https://automatic.fastbill.com/accountdata/a1/payment_data_url')
                            ->setDashboardUrl('https://automatic.fastbill.com/dashboard/a1/dashboard_url')
                    )
                    ->setSubscription(
                        (new Subscription())
                            ->setStartDate(new \DateTime('2014-03-13T10:36:04', new \DateTimeZone('UTC')))
                            ->setLastEvent(new \DateTime('2014-03-13T10:36:04', new \DateTimeZone('UTC')))
                            ->setNextEvent(new \DateTime('2014-03-20T10:36:04', new \DateTimeZone('UTC')))
                            ->setCancellationDate(null)
                            ->setStatus('trial')
                            ->setExpirationDate(new \DateTime('2014-03-20T10:36:04', new \DateTimeZone('UTC')))
                            ->setSubscriptionId(216084)
                            ->setHash('hash123')
                            ->setArticleCode('PRODUCT_CODE')
                            ->setQuantity(1)
                    );

                $this->assertEquals($expectedPayloadData, $payloadData);

                return true;
            })
        );
        $client
            ->getContainer()
            ->get('event_dispatcher')
            ->addListener(FastbillNotificationEvents::INCOMING_SUBSCRIPTION_REACTIVATED, array($mock, 'eventHandlerCallback'));

        $data = file_get_contents(__DIR__ . '/Fixtures/' . $this->getName() . '.json');
        $client = $this->makeRequest('speicher210_fastbill_notification_subscription_reactivated', $data, $client);

        $this->assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
