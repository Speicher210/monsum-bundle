<?php

namespace Speicher210\FastbillBundle\EventListener;

use Speicher210\FastbillBundle\Event\CustomerChangedEvent;
use Speicher210\FastbillBundle\Event\CustomerCreatedEvent;
use Speicher210\FastbillBundle\Event\CustomerDeletedEvent;
use Speicher210\FastbillBundle\FastbillNotificationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener for incoming Fastbill customer notifications.
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
            FastbillNotificationEvents::INCOMING_CUSTOMER_CREATED => 'onCustomerCreated',
            FastbillNotificationEvents::INCOMING_CUSTOMER_CHANGED => 'onCustomerChanged',
            FastbillNotificationEvents::INCOMING_CUSTOMER_DELETED => 'onCustomerDeleted'
        );
    }
}
