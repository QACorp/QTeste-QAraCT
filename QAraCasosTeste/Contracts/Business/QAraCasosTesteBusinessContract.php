<?php

namespace App\Modules\QAraCasosTeste\Contracts\Business;

use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use Spatie\LaravelData\DataCollection;

interface QAraCasosTesteBusinessContract
{
    public function gerarTextoIA(QAraCasosTesteDTO $qaraCasosTesteDTO, int $idEquipe): DataCollection;
    public function salvarCasosTeste(DataCollection $qaraCasosTesteDTO, int $idEquipe): DataCollection;
}
