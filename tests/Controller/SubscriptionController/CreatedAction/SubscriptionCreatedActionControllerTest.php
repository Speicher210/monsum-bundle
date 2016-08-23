<?php

namespace Speicher210\MonsumBundle\Test\Controller\SubscriptionController\CreatedAction;

use Speicher210\Monsum\Api\Model\Notification\Customer\Customer;
use Speicher210\Monsum\Api\Model\Notification\Subscription\Subscription;
use Speicher210\Monsum\Api\Model\Notification\Subscription\SubscriptionCreatedNotification;
use Speicher210\MonsumBundle\Event\SubscriptionCreatedEvent;
use Speicher210\MonsumBundle\MonsumNotificationEvents;
use Speicher210\MonsumBundle\Test\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Test case for subscription created notification.
 */
class SubscriptionCreatedActionControllerTest extends AbstractControllerTestCase
{
    public function testCreatedActionReturns204AndRaisesEventIfRequestIsValid()
    {
        $client = parent::createClient();

        $mock = $this->getMock('stdClass', array('eventHandlerCallback'));
        $mock->expects(static::once())->method('eventHandlerCallback')->with(
            static::callback(function (SubscriptionCreatedEvent $event) {
                $payloadData = $event->getPayloadData();
                static::assertNotNull($payloadData);

                $expectedPayloadData = new SubscriptionCreatedNotification();
                $expectedPayloadData
                    ->setId(398154)
                    ->setType('subscription.created')
                    ->setCreated(new \DateTime('2014-03-13T10:36:04+0000'))
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
                            ->setStartDate(new \DateTime('2014-03-13T10:36:04+0000'))
                            ->setLastEvent(new \DateTime('2014-03-13T10:36:04+0000'))
                            ->setNextEvent(new \DateTime('2014-03-20T10:36:04+0000'))
                            ->setCancellationDate(null)
                            ->setStatus('trial')
                            ->setExpirationDate(new \DateTime('2014-03-20T10:36:04+0000'))
                            ->setSubscriptionId(216084)
                            ->setHash('hash123')
                            ->setArticleCode('PRODUCT_CODE')
                            ->setQuantity(1)
                    );

                static::assertEquals($expectedPayloadData, $payloadData);

                return true;
            })
        );
        $client
            ->getContainer()
            ->get('event_dispatcher')
            ->addListener(MonsumNotificationEvents::INCOMING_SUBSCRIPTION_CREATED, array($mock, 'eventHandlerCallback'));

        $data = file_get_contents(__DIR__ . '/Fixtures/' . $this->getName() . '.json');
        $client = $this->makeRequest('speicher210_monsum_notification_subscription_created', $data, $client);

        static::assertSame(Response::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode());
    }
}
