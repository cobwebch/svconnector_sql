.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _developer:

Developer's manual
------------------

Getting data from another database using the SQL connector service is a really
easy task. The first step is to get the proper service object:

.. code-block:: php

	$services = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::findService('connector', 'sql');
	if ($services === FALSE) {
		// Issue an error
	} else {
		$connector = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService('connector', 'sql');
	}

On the first line, you get a list of all services that are of type
“connector” and subtype “sql”. If the result if false, it means no
appropriate services were found and you probably want to issue an
error message.

On the contrary you are assured that there's at least one valid
service and you can get an instance of it by calling
:code:`\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstanceService()` .

The next step is simply to call the appropriate method from the API –
with the right parameters – depending on which format you want to have
in return. For a PHP array:

.. code-block:: php

	$parameters = array(
		'driver' => 'postgres',
		'server' => '127.0.0.1',
		'user' => 'some_user',
		'password' => 'some_password',
		'database' => 'some_db',
		'query' => 'SELECT * FROM foo ORDER BY bar'
	);
	$data = $connector->fetchXML($parameters);

Obviously this is not limited to issuing SELECT queries,
although it is what it was designed for, since connector services
are really about getting data from some source.
However other types of queries have not been tested.

The :code:`fetchRaw()` method returns the same array as
:code:`fetchArray()`. The :code:`fetchXML()` method returns
the array created by :code:`fetchArray()` transformed to XML
using :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::array2xml_cs()`.

Note that the connection is neither permanent, nor stored in the connector object
(as one could imagine the object being called several times but for different connections),
so it may not be ideal to use if you need to perform many queries on the same database
in a given code execution run.
