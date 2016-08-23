<?php

namespace Speicher210\MonsumBundle\Event;

/**
 * Event when a subscription is created.
 */
class SubscriptionCreatedEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'subscription.created';
    }
}
