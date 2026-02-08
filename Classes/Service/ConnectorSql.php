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
use Doctrine\DBAL\Exception;
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
     * @throws \Exception
     */
    public function fetchRaw(): mixed
    {
        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray();
        $event = $this->eventDispatcher->dispatch(
            new ProcessRawDataEvent($result, $this)
        );
        return $event->getData();
    }

    /**
     * This method calls the query and returns the results from the response as an XML structure
     *
     * @throws \Exception
     */
    public function fetchXML(): string
    {
        // Get the data as an array
        // NOTE: this may throw an exception, but we let it bubble up
        $result = $this->fetchArray();
        // Transform result to XML
        $xml = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . "\n" . GeneralUtility::array2xml($result);
        $event = $this->eventDispatcher->dispatch(
            new ProcessXmlDataEvent($xml, $this)
        );

        return $event->getData();
    }

    /**
     * This method calls the query and returns the results from the response as a PHP array
     *
     * @return array PHP array
     * @throws DatabaseConnectionException
     * @throws QueryErrorException
     */
    public function fetchArray(): array
    {
        try {
            $data = $this->query();
            $this->logger->info('Structured data', $data);
        } catch (\Exception $e) {
            // Log exception and throw it further
            $this->logger->error('An error occurred: ' . $e->getMessage());
            throw $e;
        }
        $event = $this->eventDispatcher->dispatch(
            new ProcessArrayDataEvent($data, $this)
        );
        return $event->getData();
    }

    /**
     * This method connects to the designated database, executes the given query and returns the data an an array
     *
     * @return mixed Result of the SQL query
     * @throws DatabaseConnectionException
     * @throws QueryErrorException
     * @throws Exception
     */
    protected function query(): mixed
    {
        // Connect to the database and execute the query
        // NOTE: this may throw exceptions, but we let them bubble up
        $databaseConnection = GeneralUtility::makeInstance(DoctrineDbalConnection::class);
        $databaseConnection->connect($this->parameters);
        $data = $databaseConnection->query(
            $this->parameters['query'],
            (int)($this->parameters['fetchMode'] ?? 0)
        );

        $event = $this->eventDispatcher->dispatch(
            new ProcessResponseEvent($data, $this)
        );

        // Return the result
        return $event->getResponse();
    }
}
