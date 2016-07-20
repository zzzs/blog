<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Log;
class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		DB::listen(function($sql, $bindings, $time) {
			Log::info([
				'sql' => $sql,
				'bindings' => $bindings,
				'time' => $time,
				]);
		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
