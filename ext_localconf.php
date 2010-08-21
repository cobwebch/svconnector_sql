<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addService($_EXTKEY, 'connector',  'tx_svconnectorsql_sv1',
	array(
		'title' => 'SQL connector',
		'description' => 'Connector service to issue SQL query to any database, via ADODB',

		'subtype' => 'sql',

		'available' => TRUE,
		'priority' => 50,
		'quality' => 50,

		'os' => '',
		'exec' => '',

		'classFile' => t3lib_extMgm::extPath($_EXTKEY).'sv1/class.tx_svconnectorsql_sv1.php',
		'className' => 'tx_svconnectorsql_sv1',
	)
);
?>