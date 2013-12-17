<?php namespace Mpedrera\Themify\Filter;

use Illuminate\Events\Dispatcher as EventDispatcher;
use Mpedrera\Themify\Themify;
use Mpedrera\Themify\Finder\ThemeViewFinder;

class ThemeFilter {

    public function __construct(Themify $themify, EventDispatcher $events)
    {
        $this->themify = $themify;
        $this->events = $events;
    }

    public function filter()
    {
        if (($theme = $this->themify->getTheme()) !== null) {
            $this->events->fire('theme.set', array($theme, 5));
        }
    }

}