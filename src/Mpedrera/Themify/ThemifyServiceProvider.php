<?php namespace Mpedrera\Themify;

use Illuminate\Support\ServiceProvider;

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

		$app = $this->app;

		$this->app['themify'] = $this->app->share(function($app)
		{
			return new Themify($app);
		});
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

}