<?php

namespace App\Modules\QAraCasosTeste\Providers;

use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\QAraCasosTeste\Business\QAraCasosTesteBusiness;
use App\Modules\QAraCasosTeste\Config\MenuConfig;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\System\Impl\ServiceProviderAbstract;

class QAraServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/QAraCasosTeste';
    protected string $prefix = 'qara';
    protected string $view_namespace = 'qara';
    public $bindings = [
        QAraCasosTesteBusinessContract::class => QAraCasosTesteBusiness::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {

    }
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Config/qara.php' => config_path('qara.php'),
            ]);
        }
        $this->moduleExists(ProjetosServiceProvider::class);

        MenuConfig::configureMenuModule();

        parent::boot();
    }


}
