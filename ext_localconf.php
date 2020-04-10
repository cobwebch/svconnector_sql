<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
		'svconnector_sql',
        // Service type
        'connector',
        // Service key
        'tx_svconnectorsql_sv1',
        [
            'title' => 'SQL connector',
            'description' => 'Connector service to issue SQL query to any database, via Doctrine DBAL',

            'subtype' => 'sql',

            'available' => true,
            'priority' => 50,
            'quality' => 50,

            'os' => '',
            'exec' => '',

            'className' => \Cobweb\SvconnectorSql\Service\ConnectorSql::class
        ]
);
