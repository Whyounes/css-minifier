<?php 
namespace Rafie\Cssminifier;

use Illuminate\Support\ServiceProvider;

class CssminifierServiceProvider extends ServiceProvider {

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
		App::bind( 'CssMin', function(){
			return new CssMin;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array( 'cssmin' );
	}

}
