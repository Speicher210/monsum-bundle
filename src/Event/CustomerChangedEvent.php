<?php

namespace Speicher210\FastbillBundle\Event;

/**
 * Event when a customer is changed.
 */
class CustomerChangedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'customer.changed';
    }
}
