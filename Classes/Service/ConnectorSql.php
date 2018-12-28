<?php
namespace Cobweb\SvconnectorSql\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Cobweb\Svconnector\Service\ConnectorBase;
use Cobweb\SvconnectorSql\Database\DoctrineDbalConnection;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service "SQL connector" for the "svconnector_sql" extension.
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_svconnectorsql
 */
class ConnectorSql extends ConnectorBase
{
    public $prefixId = 'tx_svconnectorsql_sv1';        // Same as class name
    public $scriptRelPath = 'sv1/class.tx_svconnectorsql_sv1.php';    // Path to this script relative to the extension dir.
    public $extensionKey = 'svconnector_sql';    // The extension key.

    /**
     * Verifies that the connection is functional
     * In this case it always is, as the connection can really be tested only for specific configurations
     * @return boolean TRUE if the service is available
     */
    public function init(): bool
    {
        parent::init();
        $this->extConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConfiguration'][$this->extensionKey]);
        return true;
    }

    /**
     * This method calls the fetchArray() method and returns the result as is,
     * i.e. the SQL record set, but without any additional work performed on it
     *
     * @param array $parameters Parameters for the call
     * @return mixed Server response
     */
    public function fetchRaw($parameters)
    {
        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray($parameters);
        // Implement post-processing hook
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processRaw'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processRaw'] as $className) {
                $processor = GeneralUtility::getUserObj($className);
                $result = $processor->processRaw($result, $this);
            }
        }
        return $result;
    }

    /**
     * This method calls the query and returns the results from the response as an XML structure
     *
     * @param array $parameters Parameters for the call
     * @return string XML structure
     */
    public function fetchXML($parameters): string
    {
        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray($parameters);
        // Transform result to XML
        $xml = GeneralUtility::array2xml_cs($result);
        // Implement post-processing hook
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processXML'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processXML'] as $className) {
                $processor = GeneralUtility::getUserObj($className);
                $xml = $processor->processXML($xml, $this);
            }
        }
        return $xml;
    }

    /**
     * This method calls the query and returns the results from the response as a PHP array
     *
     * @param array $parameters Parameters for the call
     * @throws \Exception
     * @return array PHP array
     */
    public function fetchArray($parameters): array
    {
        try {
            $data = $this->query($parameters);
            if (TYPO3_DLOG || $this->extConfiguration['debug']) {
                GeneralUtility::devLog('Structured data', $this->extensionKey, -1, $data);
            }

            // Implement post-processing hook
            if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processArray'])) {
                foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processArray'] as $className) {
                    $processor = GeneralUtility::getUserObj($className);
                    $data = $processor->processArray($data, $this);
                }
            }
        } catch (\Exception $e) {
            // Log exception and throw it further
            if (TYPO3_DLOG || $this->extConfiguration['debug']) {
                GeneralUtility::devLog('An error occurred: ' . $e->getMessage(), 'svconnector_sql', 3);
            }
            throw $e;
        }
        return $data;
    }

    /**
     * This method connects to the designated database, executes the given query and returns the data an an array
     *
     * NOTE: this method does not implement the "processParameters" hook,
     *       as it does not make sense in this case
     *
     * @param array $parameters Parameters for the call
     * @throws \Cobweb\SvconnectorSql\Exception\DatabaseConnectionException
     * @throws \Cobweb\SvconnectorSql\Exception\QueryErrorException
     * @return mixed Result of the SQL query
     */
    protected function query($parameters)
    {
        // Connect to the database and execute the query
        // NOTE: this may throw exceptions, but we let them bubble up
        $databaseConnection = GeneralUtility::makeInstance(DoctrineDbalConnection::class);
        $databaseConnection->connect($parameters);
        $data = $databaseConnection->query($parameters['query']);

        // Process the result if any hook is registered
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processResponse'])) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processResponse'] as $className) {
                $processor = GeneralUtility::getUserObj($className);
                $data = $processor->processResponse($data, $this);
            }
        }
        // Return the result
        return $data;
    }
}
