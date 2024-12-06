<?php

declare(strict_types=1);

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

namespace Cobweb\SvconnectorSql\Service;

use Cobweb\Svconnector\Attribute\AsConnectorService;
use Cobweb\Svconnector\Event\ProcessArrayDataEvent;
use Cobweb\Svconnector\Event\ProcessRawDataEvent;
use Cobweb\Svconnector\Event\ProcessResponseEvent;
use Cobweb\Svconnector\Event\ProcessXmlDataEvent;
use Cobweb\Svconnector\Service\ConnectorBase;
use Cobweb\SvconnectorSql\Database\DoctrineDbalConnection;
use Cobweb\SvconnectorSql\Exception\DatabaseConnectionException;
use Cobweb\SvconnectorSql\Exception\QueryErrorException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service "SQL connector" for the "svconnector_sql" extension.
 */
#[AsConnectorService(type: 'sql', name: 'SQL feed connector')]
class ConnectorSql extends ConnectorBase
{
    protected string $extensionKey = 'svconnector_sql';

    /**
     * Verifies that the connection is functional
     * In this case it always is, as the connection can really be tested only for specific configurations
     * @return bool TRUE if the service is available
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
        // Call to parent is used only to raise flag about argument deprecation
        // TODO: remove once method signature is changed in next major version
        parent::fetchRaw(...func_get_args());

        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray();
        // Implement post-processing hook
        $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processRaw'] ?? null;
        if (is_array($hooks) && count($hooks) > 0) {
            trigger_error(
                'Using the processRaw hook is deprecated. Use the ProcessRawDataEvent instead',
                E_USER_DEPRECATED
            );
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processRaw'] as $className) {
                $processor = GeneralUtility::makeInstance($className);
                $result = $processor->processRaw($result, $this);
            }
        }
        /** @var ProcessRawDataEvent $event */
        $event = $this->eventDispatcher->dispatch(
            new ProcessRawDataEvent($result, $this)
        );
        return $event->getData();
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
        // Call to parent is used only to raise flag about argument deprecation
        // TODO: remove once method signature is changed in next major version
        parent::fetchXML(...func_get_args());

        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray();
        // Transform result to XML
        $xml = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . "\n" . GeneralUtility::array2xml($result);
        // Implement post-processing hook
        $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processXML'] ?? null;
        if (is_array($hooks) && count($hooks) > 0) {
            trigger_error(
                'Using the processXML hook is deprecated. Use the ProcessXmlDataEvent instead',
                E_USER_DEPRECATED
            );
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processXML'] as $className) {
                $processor = GeneralUtility::makeInstance($className);
                $xml = $processor->processXML($xml, $this);
            }
        }
        /** @var ProcessXmlDataEvent $event */
        $event = $this->eventDispatcher->dispatch(
            new ProcessXmlDataEvent($xml, $this)
        );

        return $event->getData();
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
        // Call to parent is used only to raise flag about argument deprecation
        // TODO: remove once method signature is changed in next major version
        parent::fetchArray(...func_get_args());

        try {
            $data = $this->query();
            $this->logger->info('Structured data', $data);

            // Implement post-processing hook
            $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processArray'] ?? null;
            if (is_array($hooks) && count($hooks) > 0) {
                trigger_error(
                    'Using the processArray hook is deprecated. Use the ProcessArrayDataEvent instead',
                    E_USER_DEPRECATED
                );
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
        /** @var ProcessArrayDataEvent $event */
        $event = $this->eventDispatcher->dispatch(
            new ProcessArrayDataEvent($data, $this)
        );
        return $event->getData();
    }

    /**
     * This method connects to the designated database, executes the given query and returns the data an an array
     *
     * NOTE: this method does not implement the "processParameters" hook,
     *       as it does not make sense in this case
     *
     * @param array $parameters Parameters for the call
     * @throws DatabaseConnectionException
     * @throws QueryErrorException
     * @return mixed Result of the SQL query
     */
    protected function query(array $parameters = [])
    {
        // Call to parent is used only to raise flag about argument deprecation
        // TODO: remove once method signature is changed in next major version
        parent::query(...func_get_args());

        // Connect to the database and execute the query
        // NOTE: this may throw exceptions, but we let them bubble up
        $databaseConnection = GeneralUtility::makeInstance(DoctrineDbalConnection::class);
        $databaseConnection->connect($this->parameters);
        $data = $databaseConnection->query(
            $this->parameters['query'],
            (int)($this->parameters['fetchMode'] ?? 0)
        );

        // Process the result if any hook is registered
        $hooks = $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processResponse'] ?? null;
        if (is_array($hooks) && count($hooks) > 0) {
            trigger_error(
                'Using the processResponse hook is deprecated. Use the ProcessResponseEvent instead',
                E_USER_DEPRECATED
            );
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extensionKey]['processResponse'] as $className) {
                $processor = GeneralUtility::makeInstance($className);
                $data = $processor->processResponse($data, $this);
            }
        }
        /** @var ProcessResponseEvent $event */
        $event = $this->eventDispatcher->dispatch(
            new ProcessResponseEvent($data, $this)
        );

        // Return the result
        return $event->getResponse();
    }
}
