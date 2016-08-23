<?php

namespace Speicher210\MonsumBundle\Event;

use Speicher210\Monsum\Api\Model\Notification\NotificationPayloadInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract notification event.
 */
abstract class AbstractNotificationEvent extends Event implements NotificationEventInterface
{

    /**
     * The notification request payload data.
     *
     * @var NotificationPayloadInterface
     */
    protected $payloadData;

    /**
     * {@inheritdoc}
     */
    public function getPayloadData()
    {
        return $this->payloadData;
    }

    /**
     * {@inheritdoc}
     */
    public function setPayloadData(NotificationPayloadInterface $data)
    {
        $this->payloadData = $data;

        return $this;
    }
}
