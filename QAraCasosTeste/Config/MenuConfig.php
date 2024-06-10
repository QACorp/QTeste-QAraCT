<?php

namespace App\Modules\QAraCasosTeste\Config;

use App\System\Impl\MenuConfigAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuConfig extends MenuConfigAbstract
{

    public static function configureMenuModule()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {


            $event->menu->addIn('casos_teste_index',[

                                    'text' => 'QAra',
                                    'key' => 'casos_teste_qara_index',
                                    'route'  => 'caso-teste.qara.index',
                                    'classes' => 'ml-4',
                                    'icon'  => 'fas fa-file-alt',
                                    'active' => ['projetos/qara/casos-teste/*'],
                                    'label' => 'Novo',
                                    'label_color' => 'success',
                                    'can'   => 'QARA_CASOS_TESTE_INSERIR'

            ]);
        });
    }
}
