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
     * @var Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param Mpedrera\Themify\Resolver\Resolver $resolver
     * @return Mpedrera\Themify\Themify
     */
    public function __construct(Resolver $resolver, Finder $finder, EventDispatcher $events, Config $config)
    {
        $this->resolver = $resolver;
        $this->finder = $finder;
        $this->events = $events;
        $this->config = $config;

        // TODO: Move to a proper place
        $this->events->listen('theme.set', function($theme, $priority)
        {
            $themePath = $this->buildThemePath($theme);
            $this->finder->addThemeLocation($themePath, $priority);
        });
    }

    /**
     * Change the current theme property.
     *
     * @param string $theme
     * @return void
     */
    public function setTheme($theme)
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
    public function getTheme()
    {
        // Return $currentTheme if not null, $resolver->resolve() otherwise
        return $this->currentTheme ?: $this->resolver->resolve();
    }

    /**
     * Prepend a location to the finder, instead of 
     * appending. This way, theme views have priority.
     *
     * @param string $location
     * @return void
     */
    public function addThemeLocation($location)
    {
        return $this->finder->addThemeLocation($location);
    }

    /**
     * 
     */
    protected function buildThemePath($theme)
    {
        $themePath = $this->config['themify::themes_path'];
        $themePath .= DIRECTORY_SEPARATOR . $theme;
        $themePath .= DIRECTORY_SEPARATOR . 'views';

        return $themePath;
    }

}