<?php

namespace App\Modules\QAraCasosTeste\Services\QAra;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\QAraCasosTeste\Providers\QAraServiceProvider;
use App\System\Impl\QAraModelAbstract;
use App\System\Services\Qara\DTOs\QAraMessageDTO;
use App\System\Services\Qara\QAra;
use App\System\Services\Qara\QAraRoleEnum;
use App\System\Traits\Configuracao;
use Illuminate\Support\Facades\App;
use Spatie\LaravelData\DataCollection;

class QAraCasosTesteModel extends QAraModelAbstract
{
    use Configuracao;
    public static function gerarTexto(DataCollection $message): DataCollection
    {
        $classCasosTesteModel = App::make(QAraCasosTesteModel::class);
        $qara = QAra::factory(
            $classCasosTesteModel->buscarConfiguracao(QAraServiceProvider::$prefix, 'OPENAPI_TOKEN')->valor
        );
        $content =  $qara->getChat(QAraMessageDTO::collection([
            QAraMessageDTO::from([
                'role' => QAraRoleEnum::SYSTEM->value,
                'content' => 'Você responderá como se fosse um profissional de qualidade de software com conhecimento sobre TDD e elaboração de casos de testes.
                               Deve retornar uma lista com, no minimo, 10 casos de testes para os requisitos abaixo.
                               Escreva os casos de testes em JSON com o seguinte formato:{casos_teste:[
                                {
                                    requisito: "decricao do requisito",
                                    titulo: "Título do requisito testado",
                                    cenario: "Cenário em que o teste está sendo executado",
                                    teste: "Os passos do teste",
                                    resultado_esperado: "Resultado esperado ao final do teste"
                                    }
                            ]}'
            ]),
            ...$message
        ]));

        $casosTestes = json_decode($content->choices[0]->message->content);
        return CasoTesteDTO::collection($casosTestes->casos_teste);
    }
}
