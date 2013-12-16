<?php

use Mockery as M;
use Mpedrera\Themify\Resolver\Resolver;
use \ArrayAccess;

class ResolverTest extends PHPUnit_Framework_TestCase {

    protected $app;
    protected $router;
    protected $config;

    public function setUp()
    {
        $this->mockApp();
        $this->mockRouter();
        $this->mockConfig();
    }

    public function tearDown()
    {
        M::close();
    }

    public function testResolvesControllerTheme()
    {
        // Mock a controller with a $theme property
        $controller = M::mock('Illuminate\Routing\Controllers\Controller');
        $controller->theme = 'footheme';

        // Make app return router, and router return an action
        $this->mockAppRouter();
        $this->router->shouldReceive('currentRouteAction')
            ->andReturn('Foo@action');

        $this->mockAppController($controller);
        
        $resolver = new Resolver($this->app);
        $this->assertEquals('footheme', $resolver->resolve());
    }

    /**
     * Mock Laravel router instance.
     * 
     * @return void
     */
    protected function mockRouter()
    {
        $this->router = M::mock('Illuminate\Routing\Router');
    }

    /**
     * Mock Laravel config instance.
     */
    protected function mockConfig()
    {
        $this->config = M::mock('Illuminate\Config\Repository');
    }

    /**
     * Mock Laravel application instance.
     */
    protected function mockApp()
    {
        $this->app = Mockery::mock('Illuminate\Foundation\Application');
    }

    /**
     * Make the $app object return mocked router
     * when needed.
     */
    protected function mockAppRouter()
    {
        $this->app->shouldReceive('make')
            ->with('router')
            ->once()
            ->andReturn($this->router);
    }

    /**
     * Make $app object return mocked config 
     * when needed.
     */
    protected function mockAppConfig()
    {
        $this->app->shouldReceive('make')
            ->with('config')
            ->once()
            ->andReturn($this->config);
    }

    /**
     * Make the $app object return a given
     * $controller object.
     *
     * @param stdClass $controller
     */
    protected function mockAppController($controller)
    {
        $this->app->shouldReceive('make')
            ->once()
            ->andReturn($controller);
    }

}