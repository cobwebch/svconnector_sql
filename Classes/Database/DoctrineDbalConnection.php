<?php
namespace Cobweb\SvconnectorSql\Database;

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

use Cobweb\SvconnectorSql\Exception\DatabaseConnectionException;
use Cobweb\SvconnectorSql\Exception\QueryErrorException;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\FetchMode;

/**
 * Connects to a variety of DBMS using Doctrine DBAL.
 */
class DoctrineDbalConnection
{
    protected Connection $connection;

    /**
     * Connects to a database given connection parameters.
     *
     * @param array $parameters Parameters needed to connect to the database
     * @throws \Cobweb\SvconnectorSql\Exception\DatabaseConnectionException
     * @return void
     * @throws \Cobweb\SvconnectorSql\Exception\QueryErrorException
     */
    public function connect(array $parameters = []): void
    {
        $configuration = new Configuration();
        if (array_key_exists('uri', $parameters)) {
            $connectionParameters = array(
                    'url' => $parameters['uri']
            );
        } else {
            $connectionParameters = array(
                    'dbname' => $parameters['database'],
                    'user' => $parameters['user'],
                    'password' => $parameters['password'],
                    'host' => $parameters['server'],
                    'driver' => $parameters['driver'] ?? null,
                    'driverClass' => $parameters['driverClass'] ?? null
            );
        }
        try {
            $this->connection = DriverManager::getConnection(
                    $connectionParameters,
                    $configuration
            );
        } catch (\Exception $e) {
            // Throw unified exception
            throw new DatabaseConnectionException(
                    sprintf(
                            'Database connection failed (%s)',
                            $e->getMessage()
                    ),
                    1491062456
            );
        }

        // Execute connection initialization if defined
        if (!empty($parameters['init'])) {
            try {
                $this->connection->executeQuery($parameters['init']);
            }
            catch (\Exception $e) {
                throw new QueryErrorException(
                        sprintf(
                            'Failled executing "init" statement (%s)',
                            $e->getMessage()
                        ),
                        1491379532
                );
            }
        }
    }

    /**
     * Executes a SQL query and returns an array of resulting records.
     *
     * @param string $sql SQL query to execute
     * @param int $fetchMode
     * @return array
     * @throws QueryErrorException
     * @throws \Doctrine\DBAL\Exception
     */
    public function query(string $sql, int $fetchMode = FetchMode::ASSOCIATIVE): array
    {
        try {
            $result = $this->connection->executeQuery($sql);
        }
        catch (\Exception $e) {
            throw new QueryErrorException(
                    sprintf(
                        'Failled executing query (%s)',
                        $e->getMessage()
                    ),
                    1491379701
            );
        }

        switch ($fetchMode) {
            case FetchMode::NUMERIC:
                return $result->fetchAllNumeric();
            case FetchMode::COLUMN:
                return $result->fetchFirstColumn();
            default:
                return $result->fetchAllAssociative();
        }
    }
}