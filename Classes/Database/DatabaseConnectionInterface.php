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

interface DatabaseConnectionInterface
{
    /**
     * Connects to a database given connection parameters.
     *
     * @param array $parameters Parameters needed to connect to the database
     * @throws \Cobweb\SvconnectorSql\Exception\DatabaseConnectionException
     * @return void
     */
    public function connect($parameters);

    /**
     * Executes a SQL query and returns an array of resulting records.
     *
     * @param string $sql SQL query to execute
     * @throws \Cobweb\SvconnectorSql\Exception\QueryErrorException
     * @return array
     */
    public function query($sql);
}