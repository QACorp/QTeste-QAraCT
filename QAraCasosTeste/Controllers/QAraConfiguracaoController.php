<?php

namespace App\Modules\QAraCasosTeste\Controllers;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Enums\CasoTesteEnum;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteConfiguracaoBusinessContract;
use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use App\Modules\QAraCasosTeste\Enums\PermissionEnum;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\Authverification;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class QAraConfiguracaoController
{
    use EquipeTools;
    public function __construct(
        private readonly QAraCasosTesteConfiguracaoBusinessContract $QAraCasosTesteConfiguracaoBusiness
    )
    {
    }
    //Criar método index no controller
    public function index(Request $request)
    {
        Auth::user()->can(PermissionEnum::QARA_CASOS_TESTE_CONFIGURACAO->value);
        $token = $this->QAraCasosTesteConfiguracaoBusiness->buscar('OPENAPI_TOKEN')->valor;
        return view('qara::configuracao.index', compact('token'));
    }

    public function salvar(Request $request)
    {
        Auth::user()->can(PermissionEnum::QARA_CASOS_TESTE_CONFIGURACAO->value);
        try{
            $token = $this->QAraCasosTesteConfiguracaoBusiness->salvar('OPENAPI_TOKEN', $request->token);
            return redirect(route('caso-teste.qara.configuracao'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Configuração salva com sucesso']]);
        }catch (UnprocessableEntityException $e) {
            return redirect()->back()->withErrors($e->getMessages());
        }


        return view('qara::configuracao.index', compact('token'));
    }
}
