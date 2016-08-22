<?php

namespace Speicher210\FastbillBundle\Event;

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
