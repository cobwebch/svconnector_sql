<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "svconnector_sql".
 *
 * Auto generated 24-01-2013 15:56
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Connector service - SQL',
	'description' => 'Connector service for any SQL-based database via ADODB.',
	'category' => 'services',
	'author' => 'Francois Suter (Cobweb)',
	'author_email' => 'typo3@cobweb.ch',
	'shy' => '',
	'dependencies' => 'adodb,svconnector',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.2.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-6.0.99',
			'adodb' => '',
			'svconnector' => '2.2.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:11:{s:9:"ChangeLog";s:4:"4924";s:16:"ext_autoload.php";s:4:"a3ed";s:21:"ext_conf_template.txt";s:4:"d058";s:12:"ext_icon.gif";s:4:"73a1";s:17:"ext_localconf.php";s:4:"4c93";s:13:"locallang.xml";s:4:"13e9";s:10:"README.txt";s:4:"945c";s:42:"Resources/Public/Samples/Configuration.txt";s:4:"74ed";s:14:"doc/manual.pdf";s:4:"07f8";s:14:"doc/manual.sxw";s:4:"f7e5";s:35:"sv1/class.tx_svconnectorsql_sv1.php";s:4:"bd74";}',
	'suggests' => array(
	),
);

?>