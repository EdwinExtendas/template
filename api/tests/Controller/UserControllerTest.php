<?php

namespace App\Tests\Controller;

/**
 * Class UserControllerTest.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class UserControllerTest extends BaseFunctionalTestController
{
    public function testUserRegistration()
    {
        $this->apiRequest(
            'POST',
            '/user/register',
            [],
            [],
            [],
            json_encode([
                'api_code' => 'VIS',
                'email' => $this->randomString(8) . '@test.nl',
                'phone_number' => $this->randomString(8),
                'pan' => $this->randomString(14),
                'card_number' => $this->randomString(6),
            ])
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertNotNull($response);
        $this->assertContains('Successfully', $response['message']);
    }
}
