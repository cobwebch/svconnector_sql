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

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Connector service - SQL',
  'description' => 'Connector service for any SQL-based database via ADODB/Doctrine DBAL.',
  'category' => 'services',
  'author' => 'Francois Suter (Cobweb)',
  'author_email' => 'typo3@cobweb.ch',
  'state' => 'stable',
  'uploadfolder' => 0,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'author_company' => '',
  'version' => '2.1.0',
  'constraints' =>
  array (
    'depends' =>
    array (
      'typo3' => '8.7.0-8.99.99',
      'svconnector' => '3.1.0-0.0.0',
    ),
    'conflicts' =>
    array (
    ),
    'suggests' =>
    array (
    ),
  ),
  '_md5_values_when_last_written' => 'a:24:{s:9:"ChangeLog";s:4:"2c7d";s:11:"LICENSE.txt";s:4:"6404";s:9:"README.md";s:4:"6493";s:13:"composer.json";s:4:"d251";s:21:"ext_conf_template.txt";s:4:"3fd7";s:12:"ext_icon.png";s:4:"0a7d";s:17:"ext_localconf.php";s:4:"4ac2";s:36:"Classes/Database/AdodbConnection.php";s:4:"e42d";s:46:"Classes/Database/DatabaseConnectionFactory.php";s:4:"3d8a";s:48:"Classes/Database/DatabaseConnectionInterface.php";s:4:"df44";s:43:"Classes/Database/DoctrineDbalConnection.php";s:4:"27ea";s:49:"Classes/Exception/DatabaseConnectionException.php";s:4:"57a3";s:41:"Classes/Exception/QueryErrorException.php";s:4:"b9cf";s:32:"Classes/Service/ConnectorSql.php";s:4:"06f7";s:26:"Documentation/Includes.txt";s:4:"c83c";s:23:"Documentation/Index.rst";s:4:"a2be";s:26:"Documentation/Settings.yml";s:4:"0319";s:25:"Documentation/Targets.rst";s:4:"cc7b";s:37:"Documentation/Configuration/Index.rst";s:4:"ad41";s:33:"Documentation/Developer/Index.rst";s:4:"1462";s:36:"Documentation/Installation/Index.rst";s:4:"f366";s:36:"Documentation/Introduction/Index.rst";s:4:"fa78";s:40:"Resources/Private/Language/locallang.xlf";s:4:"d004";s:42:"Resources/Public/Samples/Configuration.txt";s:4:"7d89";}',
);

