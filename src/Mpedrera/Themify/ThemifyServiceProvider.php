<?php namespace Mpedrera\Themify;

use Illuminate\Support\ServiceProvider;
use Mpedrera\Themify\Resolver\Resolver;

class ThemifyServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('mpedrera/themify', 'themify');

		$this->registerResolver();
		$this->registerMainClass();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Register Themify class in IoC container.
	 * 
	 * @return void
	 */
	protected function registerMainClass()
	{
		$this->app['themify'] = $this->app->share(function($app)
		{
			return new Themify($app['themify.resolver']);
		});
	}

	/**
	 * Register Mpedrera\Themify\Resolver\Resolver in IoC container.
	 * 
	 * @return void
	 */
	protected function registerResolver()
	{
		$this->app['themify.resolver'] = $this->app->share(function($app)
		{
			return new Resolver($app);
		});
	}

}