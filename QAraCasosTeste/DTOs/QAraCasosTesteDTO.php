<?php

namespace App\Modules\QAraCasosTeste\DTOs;

use App\System\Utils\DTO;
use Spatie\LaravelData\Attributes\Validation\Required;

class QAraCasosTesteDTO extends DTO
{
    #[Required]
    public int $idProjeto;
    #[Required]
    public int $idAplicacao;
    #[Required]
    public string $requisitos;
}
