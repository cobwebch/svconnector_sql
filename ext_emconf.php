<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "svconnector_sql".
 *
 * Auto generated 05-04-2017 18:09
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

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
        'version' => '2.3.1',
        'constraints' =>
                [
                        'depends' =>
                                [
                                        'typo3' => '10.4.99-11.99.99',
                                        'svconnector' => '3.4.0-0.0.0',
                                ],
                        'conflicts' =>
                                [
                                ],
                        'suggests' =>
                                [
                                ],
                ],
];

