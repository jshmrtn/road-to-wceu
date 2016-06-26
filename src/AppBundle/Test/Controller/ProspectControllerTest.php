<?php
namespace AppBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProspectControllerTest extends WebTestCase
{
    /**
     * @param array $data
     * @dataProvider invalidDataProvider
     */
    public function testCreateInvalid(array $data)
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            static::$kernel->getContainer()->get('router')->generate('app_prospect_create'),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($data)
        );

        static::assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public static function invalidDataProvider()
    {
        return [
            [
                [],
            ],
            [
                [
                    'first_name' => 'bla',
                    'last_name' => 'bla',
                ],
            ],
            [
                [
                    'last_name' => 'bla',
                    'email' => 'bla',
                ],
            ],
            [
                [
                    'first_name' => 'bla',
                    'email' => 'bla',
                ],
            ],
        ];
    }

    public function testCreateDuplicate()
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            static::$kernel->getContainer()->get('router')->generate('app_prospect_create'),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'first_name' => 'Max',
                'last_name' => 'Muster',
                'email' => 'max.muster@gmail.com',
            ])
        );
        $client->request(
            Request::METHOD_POST,
            static::$kernel->getContainer()->get('router')->generate('app_prospect_create'),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'first_name' => 'Max',
                'last_name' => 'Muster',
                'email' => 'max.muster@gmail.com',
            ])
        );

        static::assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCreateValid()
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            static::$kernel->getContainer()->get('router')->generate('app_prospect_create'),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'first_name' => 'Max',
                'last_name' => 'Muster',
                'email' => 'something@gmail.com',
            ])
        );

        static::assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}
