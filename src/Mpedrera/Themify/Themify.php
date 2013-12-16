<?php namespace Mpedrera\Themify;

use \InvalidArgumentException;
use Mpedrera\Themify\Resolver\Resolver;

class Themify {

    /**
     * @var string $currentTheme
     */
    protected $currentTheme;

    /**
     * Constructor.
     *
     * @param Mpedrera\Themify\Resolver\Resolver $resolver
     * @return Mpedrera\Themify\Themify
     */
    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
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
    }

    /**
     * Get the theme that is going to be loaded.
     * First, check if a theme has been defined explicitly.
     * If not, try to resolve using $resolver.
     *
     * @return string|void
     */
    public function getTheme()
    {
        // Check if a specific theme has been defined
        if ($this->currentTheme !== null) {
            return $this->currentTheme;
        }

        return $this->resolver->resolve();
    }

}