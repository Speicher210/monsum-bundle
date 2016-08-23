<?php

namespace Speicher210\MonsumBundle\Event;

/**
 * Event when a payment is being refunded.
 */
class PaymentRefundedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'payment.refunded';
    }
}
