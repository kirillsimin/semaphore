<?php

namespace Tests\Unit;

use \Tests\TestCase;
use VersionedRoute;

class VersionedRouteTest extends TestCase
{
    /** @test */
    public function can_get_action_from_post()
    {
        $route = VersionedRoute::post('Examples', 'Api\ExampleController@index');
        $this->assertEquals('Api\ExampleController\ExampleController_v0@index', $route->getAction('controller'));
    }

    /** @test */
    public function can_get_action_from_get()
    {
        $route = VersionedRoute::get('Examples', 'Api\ExampleController@index');
        $this->assertEquals('Api\ExampleController\ExampleController_v0@index', $route->getAction('controller'));
    }

    /** @test */
    public function can_get_action_from_api_resource()
    {
        $returnValue = '__the-right-return-value__';

        $mock = VersionedRoute::fake();
        $mock->shouldReceive('apiResource')->with('Examples', 'Api\ExampleController\ExampleController_v0')->andReturn($returnValue);

        $resource = VersionedRoute::apiResource('Examples', 'Api\ExampleController');
        $this->assertEquals($resource, $returnValue);

        VersionedRoute::restoreFake();
    }

    /** @test */
    public function can_get_action_from_api_resource_with_only()
    {
        $returnValue = '__the-right-return-value__';
        $resourceMock = \Mockery::mock('foo');


        $mock = VersionedRoute::fake();
        $mock
            ->shouldReceive('apiResource')
            ->with('Examples', 'Api\ExampleController\ExampleController_v0')
            ->andReturn($resourceMock);

        $resourceMock
            ->shouldReceive('only')
            ->with('index')
            ->andReturn($returnValue);

        $resource = VersionedRoute::apiResource('Examples', 'Api\ExampleController')->only('index');
        $this->assertEquals($resource, $returnValue);

        VersionedRoute::restoreFake();
    }
}
