<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Connector service - SQL',
    'description' => 'Connector service for any SQL-based database via Doctrine DBAL.',
    'category' => 'services',
    'author' => 'Francois Suter (Idéative)',
    'author_email' => 'typo3@ideative.ch',
    'state' => 'stable',
    'author_company' => '',
    'version' => '5.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'php' => '8.2.0-8.5.99',
                    'typo3' => '13.4.0-14.1.99',
                    'svconnector' => '6.0.0-0.0.0',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
];

