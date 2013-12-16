<?php

use Mockery as M;
use Mpedrera\Themify\Themify;

class ThemifyTest extends PHPUnit_Framework_TestCase {

    protected $resolver;

    public function setUp()
    {
        $this->mockResolver();
    }

    public function tearDown()
    {
        M::close();
    }

    public function testThemeIsBeingSet()
    {
        $t = new Themify($this->resolver);
        $t->setTheme('footheme');

        $this->assertEquals($t->getTheme(), 'footheme');
    }

    public function testReturnsResolvedThemeWhenOwnThemeIsNull()
    {
        $this->resolver->shouldReceive('resolve')
            ->once()
            ->andReturn('bartheme');

        $t = new Themify($this->resolver);

        $this->assertEquals($t->getTheme(), 'bartheme');
    }

    /**
     *
     */
    protected function mockResolver()
    {
        $this->resolver = M::mock('Mpedrera\Themify\Resolver\Resolver');
    }

}