<?php

namespace Speicher210\MonsumBundle\EventListener;

use Speicher210\MonsumBundle\Event\SubscriptionCanceledEvent;
use Speicher210\MonsumBundle\Event\SubscriptionChangedEvent;
use Speicher210\MonsumBundle\Event\SubscriptionClosedEvent;
use Speicher210\MonsumBundle\Event\SubscriptionCreatedEvent;
use Speicher210\MonsumBundle\Event\SubscriptionReactivatedEvent;
use Speicher210\MonsumBundle\MonsumNotificationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener for incoming Monsum subscription notifications.
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
        return [
            MonsumNotificationEvents::INCOMING_SUBSCRIPTION_CREATED => 'onSubscriptionCreated',
            MonsumNotificationEvents::INCOMING_SUBSCRIPTION_CHANGED => 'onSubscriptionChanged',
            MonsumNotificationEvents::INCOMING_SUBSCRIPTION_CANCELED => 'onSubscriptionCanceled',
            MonsumNotificationEvents::INCOMING_SUBSCRIPTION_CLOSED => 'onSubscriptionClosed',
            MonsumNotificationEvents::INCOMING_SUBSCRIPTION_REACTIVATED => 'onSubscriptionReactivated'
        ];
    }
}
