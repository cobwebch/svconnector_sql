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

$adodbPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('adodb');
require_once($adodbPath . 'adodb/adodb.inc.php');
require_once($adodbPath . 'adodb/adodb-exceptions.inc.php');

/**
 * Connects to a variety of DBMS using ADODB.
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_svconnectorsql
 */
class AdodbConnection implements DatabaseConnectionInterface
{
    /**
     * @var \ADOConnection Database connection object
     */
    protected $connection;

    /**
     * Connects to a database given connection parameters.
     *
     * @param array $parameters Parameters needed to connect to the database
     * @throws \Cobweb\SvconnectorSql\Exception\DatabaseConnectionException
     * @return void
     */
    public function connect($parameters)
    {
        try {
            $this->connection = ADONewConnection($parameters['driver']);
            $this->connection->NConnect(
                    $parameters['server'],
                    $parameters['user'],
                    $parameters['password'],
                    $parameters['database']
            );
        } catch (\Exception $e) {
            throw new DatabaseConnectionException(
                    sprintf(
                            'Database connection failed (%s)',
                            $e->getMessage()
                    ),
                    1491062456
            );
        }

        // Set ADODB fetch mode if defined
        if (!empty($parameters['fetchMode'])) {
            $fetchMode = (int)$parameters['fetchMode'];
            $this->connection->SetFetchMode($fetchMode);
        }

        // Execute connection initialization if defined
        if (!empty($parameters['init'])) {
            $res = $this->connection->Execute($parameters['init']);
            if (!$res) {
                throw new DatabaseConnectionException(
                        $this->connection->ErrorMsg(),
                        $this->connection->ErrorNo()
                );
            }
        }
    }

    /**
     * Executes a SQL query and returns an array of resulting records.
     *
     * @param string $sql SQL query to execute
     * @throws QueryErrorException
     * @return array
     */
    public function query($sql)
    {
        /** @var $res \ADORecordSet */
        $res = $this->connection->Execute($sql);
        if (!$res) {
            throw new QueryErrorException(
                    $this->connection->ErrorMsg(),
                    $this->connection->ErrorNo()
            );
        }
        return $res->GetRows();
    }
}