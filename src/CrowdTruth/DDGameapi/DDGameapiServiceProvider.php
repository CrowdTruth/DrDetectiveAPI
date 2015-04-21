<?php namespace CrowdTruth\DDGameapi;

use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider registers the Dr. Detective Game API in the CrowdTruth platform.
 * 
 * @author carlosm
 */
class DdgameapiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('crowdtruth/ddgameapi');
		\Route::controller('game/detective/', 'CrowdTruth\DDGameapi\DDGameAPIController');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
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
