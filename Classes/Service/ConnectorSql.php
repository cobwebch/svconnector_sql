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
 */
class ConnectorSql extends ConnectorBase
{
    protected string $extensionKey = 'svconnector_sql';

    protected string $type = 'sql';

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return 'SQL connector';
    }

    /**
     * Verifies that the connection is functional
     * In this case it always is, as the connection can really be tested only for specific configurations
     * @return boolean TRUE if the service is available
     */
    public function isAvailable(): bool
    {
        return true;
    }

    /**
     * This method calls the fetchArray() method and returns the result as is,
     * i.e. the SQL record set, but without any additional work performed on it
     *
     * @param array $parameters Parameters for the call
     * @return mixed Server response
     * @throws \Exception
     */
    public function fetchRaw(array $parameters = [])
    {
        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray($parameters);
        // Implement post-processing hook
        $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processRaw'] ?? null;
        if (is_array($hooks)) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processRaw'] as $className) {
                $processor = GeneralUtility::makeInstance($className);
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
     * @throws \Exception
     */
    public function fetchXML(array $parameters = []): string
    {
        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray($parameters);
        // Transform result to XML
        $xml = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . "\n" . GeneralUtility::array2xml($result);
        // Implement post-processing hook
        $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processXML'] ?? null;
        if (is_array($hooks)) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processXML'] as $className) {
                $processor = GeneralUtility::makeInstance($className);
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
    public function fetchArray(array $parameters = []): array
    {
        try {
            $data = $this->query($parameters);
            $this->logger->info('Structured data', $data);

            // Implement post-processing hook
            $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processArray'] ?? null;
            if (is_array($hooks)) {
                foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processArray'] as $className) {
                    $processor = GeneralUtility::makeInstance($className);
                    $data = $processor->processArray($data, $this);
                }
            }
        } catch (\Exception $e) {
            // Log exception and throw it further
            $this->logger->error('An error occurred: ' . $e->getMessage());
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
    protected function query(array $parameters = [])
    {
        // Connect to the database and execute the query
        // NOTE: this may throw exceptions, but we let them bubble up
        $databaseConnection = GeneralUtility::makeInstance(DoctrineDbalConnection::class);
        $databaseConnection->connect($parameters);
        $data = $databaseConnection->query($parameters['query'], (int)($parameters['fetchMode'] ?? 0));

        // Process the result if any hook is registered
        $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processResponse'] ?? null;
        if (is_array($hooks)) {
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processResponse'] as $className) {
                $processor = GeneralUtility::makeInstance($className);
                $data = $processor->processResponse($data, $this);
            }
        }
        // Return the result
        return $data;
    }
}
