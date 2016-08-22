<?php

namespace Speicher210\FastbillBundle\Test\Controller\AbstractController;

use Speicher210\FastbillBundle\Test\Controller\AbstractControllerTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

/**
 * Test the abstract controller.
 */
class AbstractControllerTest extends AbstractControllerTestCase
{
    public function testCreatedActionReturns415IfContentTypeIsNotValid()
    {
        $this->setExpectedException(UnsupportedMediaTypeHttpException::class);

        $client = parent::createClient();
        $url = $client->getContainer()->get('router')->generate(
            'speicher210_fastbill_notification_subscription_created'
        );

        $client->request('POST', $url, array(), array(), array('CONTENT_TYPE' => 'application/x-www-form-urlencoded'));

        $this->assertSame(Response::HTTP_UNSUPPORTED_MEDIA_TYPE, $client->getResponse()->getStatusCode());
    }

    public function testCreatedActionReturns400IfDataIsNotValidJSON()
    {
        $this->setExpectedException(
            BadRequestHttpException::class,
            'Invalid hook payload.'
        );

        $client = $this->makeRequest('speicher210_fastbill_notification_subscription_created', 'bad json');
        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCreatedActionReturns400IfNotificationTypeIsWrong()
    {
        $this->setExpectedException(
            BadRequestHttpException::class,
            'Invalid type in hook call. Expected hook type "subscription.created", got "unknown.type"'
        );

        $data = json_encode(array('type' => 'unknown.type'));
        $client = $this->makeRequest('speicher210_fastbill_notification_subscription_created', $data);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
