<?php

namespace Speicher210\MonsumBundle\Event;

/**
 * Event when a payment is chargebacked.
 */
class PaymentChargebackEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'payment.chargeback';
    }
}
