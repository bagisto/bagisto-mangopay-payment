<?php

namespace Webkul\MangoPay\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Webkul\MangoPay\Console\Commands\Install;
use Webkul\MangoPay\Http\Middleware\Mangopay;
use Webkul\MangoPay\Listeners\Admin;

class MangoPayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__.'/../Routes/admin-routes.php');

        $this->loadRoutesFrom(__DIR__.'/../Routes/shop-routes.php');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'mangopay');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'mangopay');

        $this->app->register(ModuleServiceProvider::class);

        $this->registerCommands();

        $this->publishAssets();

        $this->registerEvents();

        $this->mergeConfig();

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
            dirname(__DIR__).'/Config/paymentmethods.php', 'payment_methods'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php', 'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/seller/acl.php',
            'marketplace_acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/acl.php',
            'acl'
        );
    }

    /**
     * Publish the assets.
     */
    protected function publishAssets(): void
    {
        $this->publishes([
            dirname(__DIR__).'/Resources/assets/images' => public_path('themes/mangopay/images'),
        ], 'public');
    }

    /**
     * Register the commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }
    }

    /**
     * Inject the escrow refund button into the admin order view, and keep the store wallet's records
     * when the admin who created them is deleted.
     */
    protected function registerEvents(): void
    {
        Event::listen('bagisto.admin.sales.order.page_action.after', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('mangopay::admin.sales.orders.refund-button');
        });

        Event::listen('user.admin.delete.before', [Admin::class, 'beforeDelete']);
    }

    /**
     * Merge the seller menu while the marketplace is on, and the admin menu and ACL once the payment
     * method is active, so sellers can onboard before the gateway goes live.
     */
    protected function mergeConfig(): void
    {
        if (! Schema::hasTable('core_config')) {
            return;
        }

        if (! core()->getConfigData('marketplace.general.general.status')) {
            return;
        }

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/shop-menu.php',
            'marketplace_menu.seller'
        );

        if (core()->getConfigData('sales.payment_methods.mangopay_standard.active')) {
            $this->mergeConfigFrom(
                dirname(__DIR__).'/Config/admin-menu.php',
                'menu.admin'
            );

        }
    }
}
