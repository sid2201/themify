<?php namespace Mpedrera\Themify\Filter;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Mpedrera\Themify\Finder\ThemeViewFinder;

class ThemeFilter {

    public function __construct(Container $app, EventDispatcher $events)
    {
        $this->app = $app;
        $this->events = $events;
    }

    public function filter()
    {
        $themify = $this->app->make('themify');
            
        if (($theme = $themify->getTheme()) !== null) {
           $this->events->fire('theme.set', array($theme, 5));
        }
    }

}