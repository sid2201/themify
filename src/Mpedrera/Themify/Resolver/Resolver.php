<?php namespace Mpedrera\Themify\Resolver;

use Illuminate\Container\Container;

class Resolver {

    /**
    * @var Illuminate\Container\Container $app
    */
    protected $app;

    /**
     * Constructor.
     * 
     * @param Illuminate\Container\Container $app
     * @return Mpedrera\Themify\Resolver\Resolver
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Resolve which theme has to be rendered in current request.
     * Order of preference is:
     *      - Controller theme
     *      - Default theme in package configuration
     * If no theme is found, return void.
     *
     * @return string|void
     */
    public function resolve()
    {
        // Try to find a $theme property in current controller
        if (($theme = $this->getControllerTheme()) !== null) {
            return $theme;
        }

        // Return default theme in configuration options
        if (($theme = $this->app['config']->get('themify::default_theme')) !== '') {
            return $theme;
        }
    }

    /**
     * Try to get $theme property from possible current controller being
     * executed for the current route.
     *
     * @return string|void
     */
    protected function getControllerTheme()
    {
        $controller = $this->getCurrentController();

        if (property_exists($controller, 'theme') && isset($controller->theme) && trim($controller->theme) !== '') {
            return $controller->theme;
        }
    }

    /**
     * Get an instance of the possible current controller
     * being executed for the current route.
     *
     * @return Illuminate\Routing\Controllers\Controller|void
     */
    protected function getCurrentController()
    {
        $route = $this->app['router']->currentRouteAction();
        
        if (($pos = strpos($route, '@')) !== false) {
            $controllerName = substr($route, 0, $pos);
            return $this->app->make($controllerName);
        }
    }

}