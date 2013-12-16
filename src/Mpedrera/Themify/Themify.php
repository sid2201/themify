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
        // Return $currentTheme if not null, $resolver->resolve() otherwise
        return $this->currentTheme ?: $this->resolver->resolve();
    }

}