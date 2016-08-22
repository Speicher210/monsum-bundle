<?php

namespace Speicher210\FastbillBundle\Controller\Notification;

use Speicher210\Fastbill\Api\Model\Notification\NotificationPayloadInterface;
use Speicher210\FastbillBundle\Event\NotificationEventInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

/**
 * Abstract controller for notification controllers.
 */
abstract class AbstractController extends Controller
{
    /**
     * Handle a notification.
     *
     * @param Request $request The incoming request.
     * @param NotificationEventInterface $event The event to raise when handling the notification.
     * @param string $payloadDataClass The class for the payload.
     * @return Response
     */
    protected function handleNotification(Request $request, NotificationEventInterface $event, $payloadDataClass)
    {
        $payloadData = $this->getPayload($request, $payloadDataClass);

        if ($event->getNotificationType() !== $payloadData->getType()) {
            $message = 'Invalid type in hook call. Expected hook type "%s", got "%s"';
            throw new BadRequestHttpException(sprintf($message, $event->getNotificationType(), $payloadData->getType()));
        }

        $event->setPayloadData($payloadData);

        $eventName = 'speicher210_fastbill.notification.incoming.' . $event->getNotificationType();
        $this->get('event_dispatcher')->dispatch($eventName, $event);

        if ($event->isPropagationStopped()) {
            return new Response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        } else {
            return new Response(null, Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Get the notification payload data.
     *
     * @param Request $request The request.
     * @param string $payloadDataClass The deserialization class.
     * @return NotificationPayloadInterface
     */
    protected function getPayload(Request $request, $payloadDataClass)
    {
        if ('json' !== $request->getContentType()) {
            throw new UnsupportedMediaTypeHttpException();
        }

        try {
            return $this
                ->get('speicher210_fastbill.serializer')
                ->deserialize(
                    $request->getContent(),
                    $payloadDataClass,
                    'json'
                );
        } catch (\Exception $e) {
            throw new BadRequestHttpException('Invalid hook payload.', $e);
        }
    }
}
