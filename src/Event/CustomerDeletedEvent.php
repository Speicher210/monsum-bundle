<?php

namespace Speicher210\MonsumBundle\Event;

/**
 * Event when a customer is deleted.
 */
class CustomerDeletedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'customer.deleted';
    }
}
