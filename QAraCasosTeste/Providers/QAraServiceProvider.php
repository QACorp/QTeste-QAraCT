<?php

namespace App\Modules\QAraCasosTeste\Providers;

use App\Modules\Projetos\Business\ProjetoBusiness;
use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Controllers\CasoTesteController;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\QAraCasosTeste\Business\QAraCasosTesteBusiness;
use App\Modules\QAraCasosTeste\Business\QAraCasosTesteConfiguracaoBusiness;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteConfiguracaoBusinessContract;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class QAraServiceProvider extends ServiceProviderAbstract
{
//    public static string $module_path = 'vendor/qacorp/qteste-qaract/QAraCasosTeste';
    public static string $module_path = __DIR__.'/..';
    public static string $prefix = 'qara';
    public static string $view_namespace = 'qara';
    public $bindings = [
        QAraCasosTesteBusinessContract::class => QAraCasosTesteBusiness::class,
        QAraCasosTesteConfiguracaoBusinessContract::class => QAraCasosTesteConfiguracaoBusiness::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../Config/qara.php', 'qara');

    }
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Config/qara.php' => config_path('qara.php'),
            ]);
        }

        $this->moduleExists(ProjetosServiceProvider::class);
        parent::boot();
    }


}
