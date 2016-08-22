<?php

namespace Speicher210\FastbillBundle\DataCollector;

use Speicher210\Fastbill\Api\ApiCredentials;
use Speicher210\Fastbill\Api\Transport\TransportInterface;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * Transport data collector.
 */
class TransportCollector implements TransportInterface
{
    /**
     * The inner service.
     *
     * @var TransportInterface
     */
    protected $service;

    /**
     * The stopwatch.
     *
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * The made requests.
     *
     * @var array
     */
    protected $requests = array();

    /**
     * Constructor.
     *
     * @param TransportInterface $service The inner transport.
     * @param Stopwatch $stopwatch The stopwatch.
     */
    public function __construct(TransportInterface $service, Stopwatch $stopwatch)
    {
        $this->service = $service;
        $this->stopwatch = $stopwatch;
    }

    /**
     * {@inheritdoc}
     */
    public function setCredentials(ApiCredentials $credentials)
    {
        $this->service->setCredentials($credentials);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->service->getCredentials();
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest($body)
    {
        $stopwatchId = uniqid('speicher210_fastbill.collector.transport.');
        $this->stopwatch->start($stopwatchId);

        $return = $this->service->sendRequest($body);

        $stop = $this->stopwatch->stop($stopwatchId);

        $this->requests[] = array(
            'time' => $stop->getDuration(),
            'request' => json_decode($body, true),
            'response' => json_decode($return, true),
        );

        return $return;
    }

    /**
     * Get the requests.
     *
     * @return array
     */
    public function getRequests()
    {
        return $this->requests;
    }
}
