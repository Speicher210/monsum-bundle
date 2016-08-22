<?php

namespace Speicher210\FastbillBundle\Controller\Notification;

use Speicher210\Fastbill\Api\Model\Notification\Customer\CustomerChangedNotification;
use Speicher210\Fastbill\Api\Model\Notification\Customer\CustomerCreatedNotification;
use Speicher210\Fastbill\Api\Model\Notification\Customer\CustomerDeletedNotification;
use Speicher210\FastbillBundle\Event\CustomerChangedEvent;
use Speicher210\FastbillBundle\Event\CustomerCreatedEvent;
use Speicher210\FastbillBundle\Event\CustomerDeletedEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for customers notifications.
 */
class CustomerController extends AbstractController
{
    /**
     * Action when a customer is created.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function createdAction(Request $request)
    {
        $event = new CustomerCreatedEvent();

        return $this->handleNotification($request, $event, CustomerCreatedNotification::class);
    }

    /**
     * Action when a customer is changed.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function changedAction(Request $request)
    {
        $event = new CustomerChangedEvent();

        return $this->handleNotification($request, $event, CustomerChangedNotification::class);
    }

    /**
     * Action when a customer is changed.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function deletedAction(Request $request)
    {
        $event = new CustomerDeletedEvent();

        return $this->handleNotification($request, $event, CustomerDeletedNotification::class);
    }
}
