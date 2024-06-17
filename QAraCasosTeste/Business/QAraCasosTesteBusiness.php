<?php

namespace App\Modules\QAraCasosTeste\Business;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use App\Modules\QAraCasosTeste\Enums\PermissionEnum;
use App\Modules\QAraCasosTeste\Services\QAra\QAraCasosTesteModel;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Services\Qara\DTOs\QAraMessageDTO;
use App\System\Services\Qara\QAraRoleEnum;

use App\System\Traits\Authverification;
use App\System\Traits\TransactionDatabase;
use App\System\Traits\Validation;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class QAraCasosTesteBusiness extends BusinessAbstract implements QAraCasosTesteBusinessContract
{
    use TransactionDatabase, Authverification, Validation;
    public function __construct(
        private readonly AplicacaoBusinessContract $aplicacaoBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness
    )
    {
    }

    public function gerarTextoIA(QAraCasosTesteDTO $qaraCasosTesteDTO, int $idEquipe): DataCollection
    {
        $aplicacao = $this->aplicacaoBusiness->buscarPorId($qaraCasosTesteDTO->idAplicacao,$idEquipe);
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($qaraCasosTesteDTO->idProjeto, $idEquipe);
        $casosTeste = QAraCasosTesteModel::gerarTexto(
            QAraMessageDTO::collection([
                QAraMessageDTO::from([
                    'role' => QAraRoleEnum::USER->value,
                    'content' => 'Aqui está uma descrição da aplicação: '.$aplicacao->descricao
                ]),
                QAraMessageDTO::from([
                    'role' => QAraRoleEnum::USER->value,
                    'content' => 'Aqui está uma descrição do projeto que será desenvolvido: '.$projeto->descricao
                ]),
                QAraMessageDTO::from([
                    'role' => QAraRoleEnum::USER->value,
                    'content' => $qaraCasosTesteDTO->requisitos
                ]),
            ])
        );
        return $casosTeste;
    }

    public function salvarCasosTeste(DataCollection $qaraCasosTesteDTO, int $idEquipe): DataCollection
    {
        $this->can(PermissionEnum::QARA_CASOS_TESTE_INSERIR->value);
        $insertedCasos = Collection::empty();
        try{
            $this->startTransaction();
            $qaraCasosTesteDTO->each(function($item, $key) use($idEquipe, $insertedCasos){
                $insertedCasos->add($this->casoTesteBusiness->inserirCasoTeste($item, $idEquipe));
            });
            $this->commit();
            return CasoTesteDTO::collection($insertedCasos);
        }catch (UnprocessableEntityException $e){
            $this->rollback();
            throw $e;
        }

    }
}
