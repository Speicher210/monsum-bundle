<?php

namespace Speicher210\FastbillBundle\Event;

/**
 * Event when a subscription is closed.
 */
class SubscriptionClosedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'subscription.closed';
    }
}
