<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Connector service - SQL',
    'description' => 'Connector service for any SQL-based database via Doctrine DBAL.',
    'category' => 'services',
    'author' => 'Francois Suter (Idéative)',
    'author_email' => 'typo3@ideative.ch',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author_company' => '',
    'version' => '3.1.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '11.5.0-12.1.99',
                    'svconnector' => '4.0.0-0.0.0',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
];

