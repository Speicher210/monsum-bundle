<?php

namespace Speicher210\FastbillBundle\EventListener;

use Speicher210\FastbillBundle\Event\PaymentChargebackEvent;
use Speicher210\FastbillBundle\Event\PaymentCreatedEvent;
use Speicher210\FastbillBundle\Event\PaymentFailedEvent;
use Speicher210\FastbillBundle\Event\PaymentRefundedEvent;
use Speicher210\FastbillBundle\FastbillNotificationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener for incoming Fastbill payment notifications.
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
        return array(
            FastbillNotificationEvents::INCOMING_PAYMENT_CREATED => 'onPaymentCreated',
            FastbillNotificationEvents::INCOMING_PAYMENT_CHARGEBACK => 'onPaymentChargeback',
            FastbillNotificationEvents::INCOMING_PAYMENT_FAILED => 'onPaymentFailed',
            FastbillNotificationEvents::INCOMING_PAYMENT_REFUNDED => 'onPaymentRefundedEvent'
        );
    }
}
