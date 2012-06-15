<?php

########################################################################
# Extension Manager/Repository config file for ext "svconnector_sql".
#
# Auto generated 15-06-2012 15:15
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

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
	'version' => '1.0.1',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.3.0-0.0.0',
			'adodb' => '',
			'svconnector' => '2.0.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:10:{s:9:"ChangeLog";s:4:"f74b";s:10:"README.txt";s:4:"945c";s:16:"ext_autoload.php";s:4:"a3ed";s:21:"ext_conf_template.txt";s:4:"d058";s:12:"ext_icon.gif";s:4:"73a1";s:17:"ext_localconf.php";s:4:"4c93";s:13:"locallang.xml";s:4:"13e9";s:14:"doc/manual.pdf";s:4:"1ee0";s:14:"doc/manual.sxw";s:4:"c653";s:35:"sv1/class.tx_svconnectorsql_sv1.php";s:4:"e409";}',
	'suggests' => array(
	),
);

?>