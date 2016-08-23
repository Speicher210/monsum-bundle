<?php

namespace Speicher210\MonsumBundle\Event;

/**
 * Event when a customer is created.
 */
class CustomerCreatedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'customer.created';
    }
}
