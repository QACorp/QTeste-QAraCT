<?php

namespace App\Modules\QAraCasosTeste\Business;


use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteConfiguracaoBusinessContract;
use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use App\Modules\QAraCasosTeste\Enums\PermissionEnum;
use App\Modules\QAraCasosTeste\Providers\QAraServiceProvider;
use App\Modules\QAraCasosTeste\Services\QAra\QAraCasosTesteModel;
use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Services\Qara\DTOs\QAraMessageDTO;
use App\System\Services\Qara\QAraRoleEnum;

use App\System\Traits\Authverification;
use App\System\Traits\Configuracao;


class QAraCasosTesteConfiguracaoBusiness extends BusinessAbstract implements QAraCasosTesteConfiguracaoBusinessContract
{
    use Configuracao;
    public function __construct()
    {
    }

    public function salvar(string $nome, string $valor): EmpresaConfiguracaoDTO
    {
        $this->can(PermissionEnum::QARA_CASOS_TESTE_CONFIGURACAO->value);
        return $this->salvarConfiguracao(QAraServiceProvider::$prefix, $nome, $valor, criptografado: true);
    }

    public function alterar(string $nome, string $valor): EmpresaConfiguracaoDTO
    {
    }

    public function buscar(string $nome): EmpresaConfiguracaoDTO
    {
        try{
            $configuracao =  $this->buscarConfiguracao(QAraServiceProvider::$prefix, $nome);
        }catch (NotFoundException $e){
            $configuracao = $this->salvar($nome,'');
        }


        return $configuracao;
    }
}
