<?php

namespace Speicher210\MonsumBundle\EventListener;

use Speicher210\MonsumBundle\Event\CustomerChangedEvent;
use Speicher210\MonsumBundle\Event\CustomerCreatedEvent;
use Speicher210\MonsumBundle\Event\CustomerDeletedEvent;
use Speicher210\MonsumBundle\MonsumNotificationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener for incoming Monsum customer notifications.
 */
abstract class AbstractCustomerListener implements EventSubscriberInterface
{

    /**
     * Handle creating a customer.
     *
     * @param CustomerCreatedEvent $event The raised event.
     */
    abstract public function onCustomerCreated(CustomerCreatedEvent $event);

    /**
     * Handle changing a customer.
     *
     * @param CustomerChangedEvent $event The raised event.
     */
    abstract public function onCustomerChanged(CustomerChangedEvent $event);

    /**
     * Handle deleting a customer.
     *
     * @param CustomerDeletedEvent $event The raised event.
     */
    abstract public function onCustomerDeleted(CustomerDeletedEvent $event);

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            MonsumNotificationEvents::INCOMING_CUSTOMER_CREATED => 'onCustomerCreated',
            MonsumNotificationEvents::INCOMING_CUSTOMER_CHANGED => 'onCustomerChanged',
            MonsumNotificationEvents::INCOMING_CUSTOMER_DELETED => 'onCustomerDeleted'
        );
    }
}
