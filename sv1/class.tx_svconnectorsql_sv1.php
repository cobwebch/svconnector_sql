<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010-2012 Francois Suter (Cobweb) <typo3@cobweb.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('adodb', 'adodb/adodb.inc.php'));
require_once(t3lib_extMgm::extPath('adodb', 'adodb/adodb-exceptions.inc.php'));

/**
 * Service "SQL connector" for the "svconnector_sql" extension.
 *
 * Uses ADODB to connect to a variety of DBMS
 *
 * @author		Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package		TYPO3
 * @subpackage	tx_svconnectorsql
 *
 * $Id$
 */
class tx_svconnectorsql_sv1 extends tx_svconnector_base {
	public $prefixId = 'tx_svconnectorsql_sv1';		// Same as class name
	public $scriptRelPath = 'sv1/class.tx_svconnectorsql_sv1.php';	// Path to this script relative to the extension dir.
	public $extKey = 'svconnector_sql';	// The extension key.

	/**
	 * Verifies that the connection is functional
	 * In this case it always is, as the connection can really be tested only for specific configurations
	 * @return	boolean		TRUE if the service is available
	 */
	public function init() {
		parent::init();
		$this->extConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConfiguration'][$this->extKey]);
		return TRUE;
	}

	/**
	 * This method calls the fetchArray() method and returns the result as is,
	 * i.e. the SQL record set, but without any additional work performed on it
	 *
	 * @param	array	$parameters: parameters for the call
	 * @return	mixed	server response
	 */
	public function fetchRaw($parameters) {
			// Get the data as an array
			// NOTE: this may throw an exception, but we let it bubble up
		$result = $this->fetchArray($parameters);
			// Implement post-processing hook
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processRaw'])) {
			foreach($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processRaw'] as $className) {
				$processor = &t3lib_div::getUserObj($className);
				$result = $processor->processRaw($result, $this);
			}
		}
		return $result;
	}

	/**
	 * This method calls the query and returns the results from the response as an XML structure
	 *
	 * @param	array	$parameters: parameters for the call
	 * @return	string	XML structure
	 */
	public function fetchXML($parameters) {
			// Get the data as an array
			// NOTE: this may throw an exception, but we let it bubble up
		$result = $this->fetchArray($parameters);
			// Transform result to XML
		$xml = t3lib_div::array2xml_cs($result);
			// Implement post-processing hook
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processXML'])) {
			foreach($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processXML'] as $className) {
				$processor = &t3lib_div::getUserObj($className);
				$xml = $processor->processXML($xml, $this);
			}
		}
		return $xml;
	}

	/**
	 * This method calls the query and returns the results from the response as a PHP array
	 *
	 * @param array $parameters Parameters for the call
	 * @throws Exception
	 * @return array PHP array
	 */
	public function fetchArray($parameters) {
		try {
			$data = $this->query($parameters);
			if (TYPO3_DLOG || $this->extConfiguration['debug']) {
				t3lib_div::devLog('Structured data', $this->extKey, -1, $data);
			}

				// Implement post-processing hook
			if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processArray'])) {
				foreach($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processArray'] as $className) {
					$processor = &t3lib_div::getUserObj($className);
					$data = $processor->processArray($data, $this);
				}
			}
		}
		catch (Exception $e) {
				// Log exception and throw it further
			if (TYPO3_DLOG || $this->extConfiguration['debug']) {
				t3lib_div::devLog('An error occurred: ' . $e->getMessage(), 'svconnector_sql', 3);
			}
			throw $e;
		}
		return $data;
	}

	/**
	 * This method connects to the designated database, executes the given query and returns the data an an array
	 *
	 * NOTE:    this method does not implement the "processParameters" hook,
	 *            as it does not make sense in this case
	 *
	 * @param array $parameters Parameters for the call
	 * @return array|mixed Result of the SQL query
	 */
	protected function query($parameters) {
			// Connect to the database and execute the query
			// NOTE: this may throw exceptions, but we let them bubble up
			/** @var $adodbObject ADOConnection */
		$adodbObject = ADONewConnection($parameters['driver']);
		$adodbObject->NConnect($parameters['server'], $parameters['user'], $parameters['password'], $parameters['database']);

			// Set ADODB fetch mode if defined
		if (!empty($parameters['fetchMode'])) {
			$fetchMode = intval($parameters['fetchMode']);
			$adodbObject->SetFetchMode($fetchMode);
		}

			// Execute connection initialization if defined
		if (!empty($parameters['init'])) {
			$res = $adodbObject->Execute($parameters['init']);
		}
			/** @var $res ADORecordSet */
		$res = $adodbObject->Execute($parameters['query']);
		$data = $res->GetRows();

			// Process the result if any hook is registered
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processResponse'])) {
			foreach($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][$this->extKey]['processResponse'] as $className) {
				$processor = &t3lib_div::getUserObj($className);
				$data = $processor->processResponse($data, $this);
			}
		}
			// Return the result
		return $data;
	}
}



if (defined('TYPO3_MODE') && isset($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/svconnector_sql/sv1/class.tx_svconnectorsql_sv1.php'])) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/svconnector_sql/sv1/class.tx_svconnectorsql_sv1.php']);
}

?>