<?php

namespace Speicher210\MonsumBundle\Event;

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
