<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use App\Services\InstagramService;
use App\Http\Controllers\HomeController;

/**
 * Test class for HomeController class
 */
class HomeControllerTest extends TestCase
{
    /**
     * @var HomeController
     */
    protected HomeController $homeController;

    public function setUp(): void
    {
        parent::setUp();

        $this->homeController = new HomeController();
    }

    /**
     * Test function for index method
     *
     * @param array $mockedData
     * @param array $expected
     * @return void
     * @dataProvider indexProvider
     */
    public function testIndex(array $mockedData, array $expected): void
    {
        $mock = \Mockery::mock('alias:' . InstagramService::class);

        $mock->shouldReceive('getUserInfo')
            ->andReturn($mockedData['userInfo']);

        $mock->shouldReceive('getPicturesFromUser')
            ->andReturn($mockedData['userInfo']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas(
            'userInfo',
            $expected['userInfo']
        );
        $response->assertViewHas(
            'pictures',
            $expected['pictures']
        );
        $response->assertViewHas(
            'errors',
            $expected['errors']
        );
    }

    /**
     * Data provider for testIndex fonction
     *
     * @return array
     */
    public function indexProvider(): array
    {
        return [
            [
                [
                    'userInfo' => [
                        '1234567890',
                        'test_username'
                    ],
                    'pictures' => []
                ],
                [
                    'userInfo' => [
                        '1234567890',
                        'test_username'
                    ],
                    'pictures' => [],
                    'errors' => null
                ]
            ],
        ];
    }
}
