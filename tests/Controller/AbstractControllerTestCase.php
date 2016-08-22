<?php

namespace Speicher210\FastbillBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Abstract controller test case.
 */
abstract class AbstractControllerTestCase extends WebTestCase
{
    /**
     * Make a notification request.
     *
     * @param string $routeName The name of the route where to make the request.
     * @param string $data The data to send.
     * @param Client $client The client to use. If NULL then it will be created.
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function makeRequest($routeName, $data, Client $client = null)
    {
        $client = $client ? $client : parent::createClient();
        $url = $client->getContainer()->get('router')->generate($routeName);

        $client->request('POST', $url, array(), array(), array('CONTENT_TYPE' => 'application/json'), $data);

        return $client;
    }
}
