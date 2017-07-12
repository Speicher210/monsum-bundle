<?php

namespace Speicher210\MonsumBundle\EventListener;

use Speicher210\MonsumBundle\Event\PaymentChargebackEvent;
use Speicher210\MonsumBundle\Event\PaymentCreatedEvent;
use Speicher210\MonsumBundle\Event\PaymentFailedEvent;
use Speicher210\MonsumBundle\Event\PaymentRefundedEvent;
use Speicher210\MonsumBundle\MonsumNotificationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener for incoming Monsum payment notifications.
 */
abstract class AbstractPaymentListener implements EventSubscriberInterface
{

    /**
     * Handle creating a payment.
     *
     * @param PaymentCreatedEvent $event The raised event.
     */
    abstract public function onPaymentCreated(PaymentCreatedEvent $event);

    /**
     * Handle payment chargeback.
     *
     * @param PaymentChargebackEvent $event The raised event.
     */
    abstract public function onPaymentChargeback(PaymentChargebackEvent $event);

    /**
     * Handle failed payment.
     *
     * @param PaymentFailedEvent $event The raised event.
     */
    abstract public function onPaymentFailed(PaymentFailedEvent $event);

    /**
     * Handle refunded payment.
     *
     * @param PaymentRefundedEvent $event The raised event.
     */
    abstract public function onPaymentRefundedEvent(PaymentRefundedEvent $event);

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            MonsumNotificationEvents::INCOMING_PAYMENT_CREATED => 'onPaymentCreated',
            MonsumNotificationEvents::INCOMING_PAYMENT_CHARGEBACK => 'onPaymentChargeback',
            MonsumNotificationEvents::INCOMING_PAYMENT_FAILED => 'onPaymentFailed',
            MonsumNotificationEvents::INCOMING_PAYMENT_REFUNDED => 'onPaymentRefundedEvent'
        ];
    }
}
