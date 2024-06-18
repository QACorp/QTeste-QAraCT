<?php

namespace App\Modules\QAraCasosTeste\Contracts\Business;

use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\Models\Empresa;
use Spatie\LaravelData\DataCollection;

interface QAraCasosTesteConfiguracaoBusinessContract
{
    public function salvar(string $nome, string $valor): EmpresaConfiguracaoDTO;
    public function alterar(string $nome, string $valor): EmpresaConfiguracaoDTO;
    public function buscar(string $nome): EmpresaConfiguracaoDTO;
}
