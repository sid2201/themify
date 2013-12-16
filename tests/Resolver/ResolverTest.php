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
        // Make app return router, and router return an action
        $this->mockAppRouter();
        $this->router->shouldReceive('currentRouteAction')
            ->andReturn('FooController@action');

        // Mock corresponding controller for the router action
        // and assign a theme property
        $this->mockAppController('FooController', 'footheme');
        
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
     * Create a mocked controller and return it
     * using the given name, with a given $theme property.
     *
     * @param string $name Name of the controller
     * @param string $theme
     */
    protected function mockAppController($name, $theme)
    {
        $controller = M::mock($name);
        $controller->theme = $theme;

        $this->app->shouldReceive('make')
            ->with($name)
            ->once()
            ->andReturn($controller);
    }

}