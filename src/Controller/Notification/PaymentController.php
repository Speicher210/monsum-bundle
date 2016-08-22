<?php

namespace Speicher210\FastbillBundle\Controller\Notification;

use Speicher210\Fastbill\Api\Model\Notification\Payment\PaymentChargebackNotification;
use Speicher210\Fastbill\Api\Model\Notification\Payment\PaymentCreatedNotification;
use Speicher210\Fastbill\Api\Model\Notification\Payment\PaymentFailedNotification;
use Speicher210\Fastbill\Api\Model\Notification\Payment\PaymentRefundedNotification;
use Speicher210\FastbillBundle\Event\PaymentChargebackEvent;
use Speicher210\FastbillBundle\Event\PaymentCreatedEvent;
use Speicher210\FastbillBundle\Event\PaymentFailedEvent;
use Speicher210\FastbillBundle\Event\PaymentRefundedEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for payments notifications.
 */
class PaymentController extends AbstractController
{

    /**
     * Action when a payment is created.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function createdAction(Request $request)
    {
        $event = new PaymentCreatedEvent();

        return $this->handleNotification($request, $event, PaymentCreatedNotification::class);
    }

    /**
     * Action when a payment is chargebacked.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function chargebackAction(Request $request)
    {
        $event = new PaymentChargebackEvent();

        return $this->handleNotification($request, $event, PaymentChargebackNotification::class);
    }

    /**
     * Action when a payment failed.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function failedAction(Request $request)
    {
        $event = new PaymentFailedEvent();

        return $this->handleNotification($request, $event, PaymentFailedNotification::class);
    }

    /**
     * Action when a payment is refunded.
     *
     * @param Request $request The made request.
     * @return Response
     */
    public function refundedAction(Request $request)
    {
        $event = new PaymentRefundedEvent();

        return $this->handleNotification($request, $event, PaymentRefundedNotification::class);
    }
}
