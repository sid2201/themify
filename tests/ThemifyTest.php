<?php

use Mockery as M;
use Mpedrera\Themify\Themify;

class ThemifyTest extends PHPUnit_Framework_TestCase {

    protected $resolver;
    protected $finder;
    protected $events;
    protected $config;
    protected $t;

    public function setUp()
    {
        $this->mockResolver();
        $this->mockViewFinder();
        $this->mockDispatcher();
        $this->mockConfig();

        $this->t = new Themify(
            $this->resolver, 
            $this->finder,
            $this->events,
            $this->config
        );
    }

    public function tearDown()
    {
        M::close();
    }

    public function testThemeIsBeingSet()
    {
        $this->events->shouldReceive('fire')
            ->once();

        $this->t->setTheme('footheme');

        $this->assertEquals($this->t->getTheme(), 'footheme');
    }

    public function testReturnsResolvedThemeWhenOwnThemeIsNull()
    {
        $this->resolver->shouldReceive('resolve')
            ->once()
            ->andReturn('bartheme');

        $this->assertEquals($this->t->getTheme(), 'bartheme');
    }

    /**
     *
     */
    protected function mockResolver()
    {
        $this->resolver = M::mock('Mpedrera\Themify\Resolver\Resolver');
    }

    /**
     *
     */
    protected function mockViewFinder()
    {
        $this->finder = M::mock('Mpedrera\Themify\Finder\ThemeViewFinder');
    }

    /**
     *
     */
    protected function mockDispatcher()
    {
        $this->events = M::mock('Illuminate\Events\Dispatcher');
        $this->events->shouldReceive('listen')
            ->once();
    }

    /**
     *
     */
    protected function mockConfig()
    {
        $this->config = M::mock('Illuminate\Config\Repository');
    }

}