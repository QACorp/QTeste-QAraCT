<?php

namespace App\Modules\QAraCasosTeste\Providers;

use App\Modules\Projetos\Business\ProjetoBusiness;
use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Controllers\CasoTesteController;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\QAraCasosTeste\Business\QAraCasosTesteBusiness;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class QAraServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'vendor/qacorp/qteste-qaract/QAraCasosTeste';
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
        $this->mergeConfigFrom(__DIR__.'/../Config/qara.php', $this->prefix);

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
