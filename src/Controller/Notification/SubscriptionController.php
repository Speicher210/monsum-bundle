<?php

namespace Speicher210\FastbillBundle\Controller\Notification;

use Speicher210\Fastbill\Api\Model\Notification\Subscription\SubscriptionCanceledNotification;
use Speicher210\Fastbill\Api\Model\Notification\Subscription\SubscriptionChangedNotification;
use Speicher210\Fastbill\Api\Model\Notification\Subscription\SubscriptionClosedNotification;
use Speicher210\Fastbill\Api\Model\Notification\Subscription\SubscriptionCreatedNotification;
use Speicher210\Fastbill\Api\Model\Notification\Subscription\SubscriptionReactivatedNotification;
use Speicher210\FastbillBundle\Event\SubscriptionCanceledEvent;
use Speicher210\FastbillBundle\Event\SubscriptionChangedEvent;
use Speicher210\FastbillBundle\Event\SubscriptionClosedEvent;
use Speicher210\FastbillBundle\Event\SubscriptionCreatedEvent;
use Speicher210\FastbillBundle\Event\SubscriptionReactivatedEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for subscriptions notifications.
 */
class SubscriptionController extends AbstractController
{
    /**
     * Action when a subscription is created.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function createdAction(Request $request)
    {
        $event = new SubscriptionCreatedEvent();

        return $this->handleNotification($request, $event, SubscriptionCreatedNotification::class);
    }

    /**
     * Action when a subscription is changed.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function changedAction(Request $request)
    {
        $event = new SubscriptionChangedEvent();

        return $this->handleNotification($request, $event, SubscriptionChangedNotification::class);
    }

    /**
     * Action when a subscription is canceled.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function canceledAction(Request $request)
    {
        $event = new SubscriptionCanceledEvent();

        return $this->handleNotification($request, $event, SubscriptionCanceledNotification::class);
    }

    /**
     * Action when a subscription is closed.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function closedAction(Request $request)
    {
        $event = new SubscriptionClosedEvent();

        return $this->handleNotification($request, $event, SubscriptionClosedNotification::class);
    }

    /**
     * Action when a subscription is reactivated.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function reactivatedAction(Request $request)
    {
        $event = new SubscriptionReactivatedEvent();

        return $this->handleNotification($request, $event, SubscriptionReactivatedNotification::class);
    }
}
