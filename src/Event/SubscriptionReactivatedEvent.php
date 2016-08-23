<?php

namespace Speicher210\MonsumBundle\Event;

/**
 * Event when a subscription is reactivated.
 */
class SubscriptionReactivatedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'subscription.reactivated';
    }
}
