<?php

namespace Tests\Unit\Services;

use App\Services\InstagramService;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;

/**
 * Test class for InstagramService class
 */
class InstagramServiceTest extends TestCase
{
    /**
     * @var InstagramService
     */
    protected InstagramService $instagramService;

    /**
     * @var Client
     */
    protected Client $httpClient;

    public function setUp(): void
    {
        parent::setUp();

        // // Mock of Guzzle's HttpClient
        // $this->httpClient = $this->getMockBuilder(\GuzzleHttp\Client::class)
        //     ->disableOriginalConstructor()
        //     ->getMock();

        $this->instagramService = new InstagramService();

        Config::set('services.instagram.baseUrl', 'base_url');
        Config::set('services.instagram.token', 'token');
    }

    /**
     * Test function for getUserInfo methode.
     * 
     * @param array $result
     * @dataProvider getUserInfoProvider
     */
    public function testGetUserInfo(array $result, array $httpResponse): void
    {
        // $this->httpClient->method('get')
        //     ->willReturn(new Response($httpResponse['code'],$httpResponse['header'],$httpResponse['body']));


        $mock = new MockHandler([
            new Response($httpResponse['code'],$httpResponse['header'],$httpResponse['body'])
        ]);
    
            $handler = HandlerStack::create($mock);
            $client = new Client(['handler' => $handler]);

        $this->app->instance(Client::class, $client);    

        $actual = $this->instagramService::getUserInfo();

        $this->assertEquals($actual, $result);
    }

    /**
     * Data provider for testGetUserInfo fonction
     *
     * @return array
     */
    public function getUserInfoProvider(): array
    {
        return [
            [
                [
                    '1234567890',
                    'test_username'
                ],
                [
                    'code' =>200,
                    'header' => [],
                    'body' => '{"id":"1234567890","username":"test_username"}'
                ]
            ],
        ];
    }

    /**
     * Test function for getpicturesFromUser methode.
     *
     * @param string $userId
     * @param integer|null $limit
     * @param array $result
     * @return void
     */
    public function testGetPicturesFromUser(array $params, array $result, array $httpResponse): void
    {
        $this->httpClient->method('get')
            ->willReturn($httpResponse);

        $actual = $this->instagramService::getpicturesFromUser($params['userId'], $params['limit']);

        $this->assertEquals($actual, $result);
    }

    /**
     * Data provider for testGetPicturesFromUser fonction
     *
     * @return array
     */
    public function getpicturesFromUserProvider(): array
    {
        return [];
    }
}
