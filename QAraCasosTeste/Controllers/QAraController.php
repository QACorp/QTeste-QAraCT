<?php

namespace App\Modules\QAraCasosTeste\Controllers;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Enums\CasoTesteEnum;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use App\Modules\QAraCasosTeste\Enums\PermissionEnum;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class QAraController
{
    use EquipeTools;
    public function __construct(
        private readonly QAraCasosTesteBusinessContract $qaraCasosTesteBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {
    }

    public function gerarTexto(QAraCasosTesteDTO $qaraCasosTesteDTO){
        try{
            $this->qaraCasosTesteBusiness->can(PermissionEnum::QARA_CASOS_TESTE_INSERIR->value);
            $casosTeste = $this->qaraCasosTesteBusiness->gerarTextoIA($qaraCasosTesteDTO, EquipeUtils::equipeUsuarioLogado());
            return view('qara::qara.casos-teste', compact(
                    'casosTeste'
                )
            );
        }catch (NotFoundException $e){
            return redirect(route('caso-teste.qara.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado.']]);
        }catch (UnauthorizedException $e){
            return redirect(route('caso-teste.qara.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Você não pode fazer isso.']]);
        }
    }


    public function salvar(Request $request)
    {
        $casosTeste = Collection::empty();
        foreach ($request->get('titulo') as $key => $item) {
            $casosTeste->add(CasoTesteDTO::from([
                'titulo' => $item,
                'requisito' => $request->get('requisito')[$key],
                'cenario' => $request->get('cenario')[$key],
                'teste' => $request->get('teste')[$key],
                'resultado_esperado' => $request->get('resultado_esperado')[$key],
                'equipes' => EquipeDTO::collection(
                    [['id' => EquipeUtils::equipeUsuarioLogado()]]
                ),
                'status' => CasoTesteEnum::CONCLUIDO->value
            ]));
        }
        $casosTesteDTO = CasoTesteDTO::collection($casosTeste);
        try{
            $casosTeste = $this->qaraCasosTesteBusiness->salvarCasosTeste($casosTesteDTO, EquipeUtils::equipeUsuarioLogado());
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Casos de teste salvos com sucesso.']]);

        }catch (NotFoundException $e) {
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado.']]);
        }catch (UnprocessableEntityException $e) {
            return redirect(route('caso-teste.qara.gerar-texto'))
                ->withErrors($e->getValidator())
                ->withInput()
                ->with([Controller::MESSAGE_KEY_ERROR => ['Todos os campos são obrigatórios.']]);
        }


    }
    public function index(Request $request)
    {
        $this->qaraCasosTesteBusiness->can(PermissionEnum::QARA_CASOS_TESTE_INSERIR->value);
        $idAplicacao = $request->get('idAplicacao');
        $idProjeto = $request->get('idProjeto');
        $aplicacoes = $this->aplicacaoBusiness->buscarTodos(EquipeUtils::equipeUsuarioLogado());
        $projetos = Collection::empty();
        if($idAplicacao){
            $projetos = $this->projetoBusiness->buscarTodosPorAplicacao($idAplicacao, EquipeUtils::equipeUsuarioLogado());
        }
        return view('qara::qara.index', compact(
                    'aplicacoes', 'idAplicacao', 'idProjeto', 'projetos'
            )
        );
    }
}
