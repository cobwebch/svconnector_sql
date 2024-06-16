<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Connector service - SQL',
    'description' => 'Connector service for any SQL-based database via Doctrine DBAL.',
    'category' => 'services',
    'author' => 'Francois Suter (Idéative)',
    'author_email' => 'typo3@ideative.ch',
    'state' => 'stable',
    'author_company' => '',
    'version' => '4.1.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '12.4.0-13.1.99',
                    'svconnector' => '5.0.0-0.0.0',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
];

