<?php

namespace Speicher210\FastbillBundle\Event;

/**
 * Event when a payment is created.
 */
class PaymentCreatedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'payment.created';
    }
}
