<?php

namespace Speicher210\FastbillBundle\Event;

use Speicher210\Fastbill\Api\Model\Notification\NotificationPayloadInterface;

/**
 * Interface for Fastbill incoming notification events.
 */
interface NotificationEventInterface
{

    /**
     * Get the type of the Fastbill notification.
     *
     * @return string
     */
    public static function getNotificationType();

    /**
     * Get the notification payload data from the request.
     *
     * @return NotificationPayloadInterface
     */
    public function getPayloadData();

    /**
     * Set the notification payload data from the request.
     *
     * @param NotificationPayloadInterface $data The payload data.
     * @return NotificationEventInterface
     */
    public function setPayloadData(NotificationPayloadInterface $data);

    /**
     * Returns whether further event listeners should be triggered.
     *
     * @return boolean Whether propagation was already stopped for this event.
     */
    public function isPropagationStopped();
}
