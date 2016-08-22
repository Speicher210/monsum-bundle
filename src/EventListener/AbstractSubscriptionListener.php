<?php

namespace Speicher210\FastbillBundle\EventListener;

use Speicher210\FastbillBundle\Event\SubscriptionCanceledEvent;
use Speicher210\FastbillBundle\Event\SubscriptionChangedEvent;
use Speicher210\FastbillBundle\Event\SubscriptionClosedEvent;
use Speicher210\FastbillBundle\Event\SubscriptionCreatedEvent;
use Speicher210\FastbillBundle\Event\SubscriptionReactivatedEvent;
use Speicher210\FastbillBundle\FastbillNotificationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener for incoming Fastbill subscription notifications.
 */
abstract class AbstractSubscriptionListener implements EventSubscriberInterface
{
    /**
     * Handle creating a subscription.
     *
     * @param SubscriptionCreatedEvent $event The raised event.
     */
    abstract public function onSubscriptionCreated(SubscriptionCreatedEvent $event);

    /**
     * Handle changing a subscription.
     *
     * @param SubscriptionChangedEvent $event The raised event.
     */
    abstract public function onSubscriptionChanged(SubscriptionChangedEvent $event);

    /**
     * Handle canceling a subscription.
     *
     * @param SubscriptionCanceledEvent $event The raised event.
     */
    abstract public function onSubscriptionCanceled(SubscriptionCanceledEvent $event);

    /**
     * Handle closing a subscription.
     *
     * @param SubscriptionClosedEvent $event The raised event.
     */
    abstract public function onSubscriptionClosed(SubscriptionClosedEvent $event);

    /**
     * Handle reactivating a subscription.
     *
     * @param SubscriptionReactivatedEvent $event The raised event.
     */
    abstract public function onSubscriptionReactivated(SubscriptionReactivatedEvent $event);

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FastbillNotificationEvents::INCOMING_SUBSCRIPTION_CREATED => 'onSubscriptionCreated',
            FastbillNotificationEvents::INCOMING_SUBSCRIPTION_CHANGED => 'onSubscriptionChanged',
            FastbillNotificationEvents::INCOMING_SUBSCRIPTION_CANCELED => 'onSubscriptionCanceled',
            FastbillNotificationEvents::INCOMING_SUBSCRIPTION_CLOSED => 'onSubscriptionClosed',
            FastbillNotificationEvents::INCOMING_SUBSCRIPTION_REACTIVATED => 'onSubscriptionReactivated'
        );
    }
}
