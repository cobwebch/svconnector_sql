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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Returns the proper connection object, depending on TYPO3 version.
 *
 * @package Cobweb\SvconnectorSql\Database
 */
class DatabaseConnectionFactory
{
    /**
     * Returns a database connection object, depending on TYPO3 version.
     *
     * @return DatabaseConnectionInterface
     */
    static public function getDatabaseConnection()
    {
        // If using TYPO3 v8, return a Doctrine DBAL connection object
        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) >= VersionNumberUtility::convertVersionNumberToInteger('8.0.0')) {
            return GeneralUtility::makeInstance(DoctrineDbalConnection::class);

        // Otherwise, return an ADODB connection object
        } else {
            return GeneralUtility::makeInstance(AdodbConnection::class);
        }
    }
}