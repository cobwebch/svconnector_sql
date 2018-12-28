<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
		$_EXTKEY,
        // Service type
        'connector',
        // Service key
        'tx_svconnectorsql_sv1',
        [
            'title' => 'SQL connector',
            'description' => 'Connector service to issue SQL query to any database, via ADODB',

            'subtype' => 'sql',

            'available' => true,
            'priority' => 50,
            'quality' => 50,

            'os' => '',
            'exec' => '',

            'className' => \Cobweb\SvconnectorSql\Service\ConnectorSql::class
        ]
);
