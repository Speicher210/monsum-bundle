<?php

namespace Speicher210\MonsumBundle\DataCollector;

use Speicher210\Monsum\Api\ApiCredentials;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/**
 * Data collector for Monsum API.
 */
class MonsumDataCollector extends DataCollector
{
    /**
     * The API credentials.
     *
     * @var ApiCredentials
     */
    protected $apiCredentials;

    /**
     * The transport collector.
     *
     * @var TransportCollector
     */
    protected $transportCollector;

    /**
     * Constructor.
     *
     * @param ApiCredentials $apiCredentials The Monsum API credentials.
     * @param TransportCollector $transportCollector The transport collector.
     */
    public function __construct(ApiCredentials $apiCredentials, TransportCollector $transportCollector)
    {
        $this->apiCredentials = $apiCredentials;
        $this->transportCollector = $transportCollector;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = [
            'credentials' => $this->collectApiCredentials(),
            'requests' => $this->collectRequests()
        ];
    }

    /**
     * Collect the API credentials.
     *
     * @return array
     */
    protected function collectApiCredentials()
    {
        return [
            'email' => $this->apiCredentials->getEmail(),
            'key' => $this->apiCredentials->getApiKey(),
            'account_hash' => $this->varToString($this->apiCredentials->getAccountHash())
        ];
    }

    /**
     * Collect the requests.
     *
     * @return array
     */
    protected function collectRequests()
    {
        $requests = array_fill_keys(
            ['article', 'coupon', 'customer', 'invoice', 'subscription'],
            [
                'calls' => 0,
                'time' => 0,
                'requests' => []
            ]
        );

        $transportRequests = $this->transportCollector->getRequests();
        foreach ($transportRequests as $transportRequest) {
            $request = array_change_key_case($transportRequest['request'], CASE_LOWER);
            list($service, $method) = explode('.', $request['service'], 2);

            $requests[$service]['calls']++;
            $requests[$service]['time'] += $transportRequest['time'];
            $requests[$service]['requests'][] = [
                'request' => $transportRequest['request'],
                'response' => $transportRequest['response'],
                'method' => $method,
                'time' => $transportRequest['time']
            ];
        }

        return $requests;
    }

    /**
     * Get the credentials.
     *
     * @return array
     */
    public function getCredentials()
    {
        return $this->data['credentials'];
    }

    /**
     * Get the requests.
     *
     * @return array
     */
    public function getRequests()
    {
        return $this->data['requests'];
    }

    /**
     * Get the total calls.
     *
     * @return integer
     */
    public function getTotalCalls()
    {
        $totalCalls = 0;
        foreach ($this->data['requests'] as $services) {
            $totalCalls += $services['calls'];
        }

        return $totalCalls;
    }

    /**
     * Get the total time.
     *
     * @return integer
     */
    public function getTotalTime()
    {
        $totalTime = 0;
        foreach ($this->data['requests'] as $services) {
            $totalTime += $services['time'];
        }

        return $totalTime;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'speicher210_monsum';
    }
}
