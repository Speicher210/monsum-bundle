<?php

namespace Speicher210\FastbillBundle\Event;

/**
 * Event when a payment failed.
 */
class PaymentFailedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'payment.failed';
    }
}
