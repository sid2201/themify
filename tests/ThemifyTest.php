<?php

use Mockery as M;
use Mpedrera\Themify\Themify;

class ThemifyTest extends PHPUnit_Framework_TestCase {

    protected $resolver;
    protected $finder;
    protected $t;

    public function setUp()
    {
        $this->mockResolver();
        $this->mockViewFinder();

        $this->t = new Themify($this->resolver, $this->finder);
    }

    public function tearDown()
    {
        M::close();
    }

    public function testThemeIsBeingSet()
    {
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

}