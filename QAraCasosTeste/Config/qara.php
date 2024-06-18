<?php
return [
    'menu' => [
                'text' => 'QAra',
                'key' => 'qara_index',
                'icon'  => 'fas fa-robot',
                'submenu' => [
                    [
                        'text' => 'Configurações',
                        'key' => 'casos_teste_qara_configuracao',
                        'route'  => 'caso-teste.qara.configuracao',
                        'icon'  => 'fas fa-cogs',
                        'active' => ['qara/configuracao/*'],
                        'label' => 'Novo',
                        'label_color' => 'success',
                        'can'   => 'QARA_CASOS_TESTE_INSERIR',
                        'topnav_user' => true
                    ],
                    [
                        'text' => 'Casos de testes',
                        'key' => 'casos_teste_qara_index',
                        'route'  => 'caso-teste.qara.index',
                        'icon'  => 'fas fa-file-alt',
                        'active' => ['qara/casos-teste*'],
                        'label' => 'Novo',
                        'label_color' => 'success',
                        'can'   => 'QARA_CASOS_TESTE_INSERIR'
                    ]


            ]
        ]
];
