.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Includes.rst.txt


.. _developer:

Developer's manual
------------------

Getting data from another database using the SQL connector service is a really
easy task. The first step is to get the proper service object, with the desired parameters:

.. code-block:: php

   $parameters = [
      'driver' => 'postgres',
      'driverClass' => 'Vendor\DBAL\Driver\PDODblib\Driver',
      'server' => '127.0.0.1',
      'user' => 'some_user',
      'password' => 'some_password',
      'database' => 'some_db',
      'query' => 'SELECT * FROM foo ORDER BY bar'
   ];
   $registry = GeneralUtility::makeInstance(\Cobweb\Svconnector\Registry\ConnectorRegistry::class);
   $connector = $registry->getServiceForType('sql', $parameters);

An additional step could be to check if the service is indeed available,
by calling :php:`$connector->isAvailable()`, although - in this particular
case - the SQL connector service is always available.

The next step is simply to call the appropriate method from the API
depending on which format you want to have in return. For a PHP array:

.. code-block:: php

   $data = $connector->fetchArray();

Obviously this is not limited to issuing SELECT queries,
although it is what it was designed for, since connector services
are really about getting data from some source.
Other types of queries have not been tested.

The :code:`fetchRaw()` method returns the same array as
:code:`fetchArray()`. The :code:`fetchXML()` method returns
the array created by :code:`fetchArray()` transformed to XML
using :code:`\TYPO3\CMS\Core\Utility\GeneralUtility::array2xml`.

Note that the connection is neither permanent, nor stored in the connector object
(as one could imagine the object being called several times but for different connections),
so it may not be ideal to use if you need to perform many queries on the same database
in a given code execution run.
