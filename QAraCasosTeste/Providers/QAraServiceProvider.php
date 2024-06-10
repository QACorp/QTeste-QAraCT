<?php

namespace App\Modules\QAraCasosTeste\Providers;

use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\QAraCasosTeste\Business\QAraCasosTesteBusiness;
use App\Modules\QAraCasosTeste\Config\MenuConfig;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\Controllers\QAraController;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Contracts\Support\DeferrableProvider;

class QAraServiceProvider extends ServiceProviderAbstract implements DeferrableProvider
{
    protected string $module_path = 'vendor/malf88/qa-kit-qara-caso-teste/QAraCasosTeste';
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
    public function provides()
    {
        return [
            CasoTesteBusinessContract::class,
            QAraCasosTesteBusinessContract::class
        ];
    }

}
