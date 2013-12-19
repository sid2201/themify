<?php namespace Mpedrera\Themify\Filter;

use Illuminate\Events\Dispatcher as EventDispatcher;
use Mpedrera\Themify\Themify;
use Mpedrera\Themify\Finder\ThemeViewFinder;

class ThemeFilter {

    /**
     * @var Mpedrera\Themify\Themify
     */
    protected $themify;

    /**
     * @var Illuminate\Events\Dispatcher
     */
    protected $events;

    public function __construct(Themify $themify, EventDispatcher $events)
    {
        $this->themify = $themify;
        $this->events = $events;
    }

    public function filter()
    {
        if (($theme = $this->themify->get()) !== null) {
            $this->events->fire('theme.set', array($theme, 5));
        }
    }

}