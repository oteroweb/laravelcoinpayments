<?php
namespace oteroweb\LaravelCoinPayment;
use Illuminate\Support\ServiceProvider;
class LaravelCoinPaymentServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
	
		// Config
		$this->publishes([
			__DIR__ . '/../src/config/coinpayment.php' => config_path('coinpayment.php'),
		], 'config');
		
		
		// Views
		$this->loadViewsFrom(__DIR__.'/../src/views', 'laravelcoinpayment');
		
		$this->publishes([
			__DIR__.'/../src/views' => resource_path('views/vendor/laravelcoinpayment'),
		], 'views');
    }
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}