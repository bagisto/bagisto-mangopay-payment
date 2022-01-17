<?php

namespace Webkul\MangoPay\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\MangoPay\Http\Middleware\Mangopay;
use Illuminate\Routing\Router;

class MangoPayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->app->register(ModuleServiceProvider::class);
        
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'mangopay');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'mangopay');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views/admin/sales' => resource_path('views/vendor/admin/sales'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/customers/account/partials/sidemenu.blade.php' => 
               resource_path('themes/velocity/views/customers/account/partials/sidemenu.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/customers/account/partials/sidemenu.blade.php' => 
               resource_path('themes/default/views/customers/account/partials/sidemenu.blade.php'),
        ]);     

        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('mangopay::admin.layouts.style');
        });

        Event::listen('bagisto.shop.layout.head', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('mangopay::shop.layouts.style');
        });

        $router->aliasMiddleware('mangopay', Mangopay::class);

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/admin-menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php', 'paymentmethods'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/shop-menu.php',
            'menu.customer'
        );
    }
}