<?php

########################################################################
# Extension Manager/Repository config file for ext "svconnector_sql".
#
# Auto generated 21-08-2010 22:05
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
	'dependencies' => 'adodb',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'adodb' => '',
			'svconnector' => '1.1.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:7:{s:9:"ChangeLog";s:4:"6ec1";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"4c93";s:19:"doc/wizard_form.dat";s:4:"3356";s:20:"doc/wizard_form.html";s:4:"4056";s:35:"sv1/class.tx_svconnectorsql_sv1.php";s:4:"bf92";}',
);

?>