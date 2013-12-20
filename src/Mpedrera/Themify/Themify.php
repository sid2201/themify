<?php namespace Mpedrera\Themify;

use Mpedrera\Themify\Resolver\Resolver;
use Mpedrera\Themify\Finder\ThemeViewFinder as Finder;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Illuminate\Config\Repository as Config;
use \InvalidArgumentException;

class Themify {

    /**
     * @var string $currentTheme
     */
    protected $currentTheme;

    /**
     * @var Mpedrera\Themify\Resolver\Resolver
     */
    protected $resolver;

    /**
     * @var Mpedrera\Themify\Finder\ThemeViewFinder
     */
    protected $finder;

    /**
     * @var Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param Mpedrera\Themify\Resolver\Resolver $resolver
     * @param Mpedrera\Themify\Finder\Finder
     * @param Illuminate\Events\Dispatcher
     * @param Illuminate\Config\Repository
     * @return Mpedrera\Themify\Themify
     */
    public function __construct(Resolver $resolver, Finder $finder, EventDispatcher $events, Config $config)
    {
        $this->resolver = $resolver;
        $this->finder = $finder;
        $this->events = $events;
        $this->config = $config;

        $this->addThemeSetListener();
    }

    /**
     * Change the current theme property.
     *
     * @param string $theme
     * @return void
     */
    public function set($theme)
    {
        if ( ! is_string($theme)) {
            throw new InvalidArgumentException('$theme parameter must be a string.');
        }

        $this->currentTheme = $theme;

        $this->events->fire('theme.set', array($theme, 1));
    }

    /**
     * Get the theme that is going to be loaded.
     * First, check if a theme has been defined explicitly.
     * If not, try to resolve using $resolver.
     *
     * @return mixed
     */
    public function get()
    {
        // Return $currentTheme if not null, resolve otherwise
        return $this->currentTheme ?: $this->resolver->resolve();
    }

    /**
     *
     */
    public function assetsPath()
    {
        $themeAssetsDir = $this->config->get('themify::themes_assets_path');
        $theme = $this->get();
        
        return $themeAssetsDir . '/' . $theme;
    }

    /**
     * Add an event listener to 'theme.set'.
     * When fired, it should tell the finder to try
     * to add the location of the theme that's been set.
     *
     * @return void
     */
    protected function addThemeSetListener()
    {
        $this->events->listen('theme.set', function($theme, $priority)
        {
            $themePath = $this->buildThemePath($theme);
            $this->finder->addThemeLocation($themePath, $priority);
        });
    }

    /**
     * Build theme path for a given theme name.
     *
     * @param string $theme
     * @return string
     */
    protected function buildThemePath($theme)
    {
        $segments = array($this->config['themify::themes_path'], $theme, 'views');

        return implode(DIRECTORY_SEPARATOR, $segments);
    }

}