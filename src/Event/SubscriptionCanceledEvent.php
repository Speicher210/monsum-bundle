<?php

namespace Speicher210\MonsumBundle\Event;

/**
 * Event when a subscription is canceled.
 */
class SubscriptionCanceledEvent extends AbstractNotificationEvent
{
    /**
     * {@inheritdoc}
     */
    public static function getNotificationType()
    {
        return 'subscription.canceled';
    }
}
