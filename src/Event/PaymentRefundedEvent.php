<?php

namespace Speicher210\FastbillBundle\Event;

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
