.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration
-------------

The various "fetch" methods of the SQL connector take the same
parameters:

+-----------------+---------------+------------------------------------------------------------------------+
| Parameter       | Data type     | Description                                                            |
+=================+===============+========================================================================+
| driver          | string        | Name of the database system to connect to, taken from the list of      |
|                 |               | available ADODB drivers.                                               |
|                 |               |                                                                        |
|                 |               | |                                                                      |
|                 |               |                                                                        |
|                 |               | See http://phplens.com/adodb/supported.databases.html                  |
+-----------------+---------------+------------------------------------------------------------------------+
| server          | string        | Address of the server to connect to.                                   |
+-----------------+---------------+------------------------------------------------------------------------+
| user            | string        | User name to use to connect to the database.                           |
+-----------------+---------------+------------------------------------------------------------------------+
| password        | string        | Password to use for the given user.                                    |
+-----------------+---------------+------------------------------------------------------------------------+
| database        | string        | Name of the database to connect to.                                    |
+-----------------+---------------+------------------------------------------------------------------------+
| query           | string        | The actual query to execute.                                           |
+-----------------+---------------+------------------------------------------------------------------------+
| init            | string        | SQL queries to be sent before the actual query (defined in             |
|                 |               | parameter :code:`query`) is executed. This is typically used to        |
|                 |               | temporarily change the encoding.                                       |
|                 |               |                                                                        |
|                 |               | |                                                                      |
|                 |               |                                                                        |
|                 |               | **Example:**                                                           |
|                 |               |                                                                        |
|                 |               | .. code-block:: sql                                                    |
|                 |               |                                                                        |
|                 |               |    SET NAMES 'UTF8';                                                   |
+-----------------+---------------+------------------------------------------------------------------------+
| fetchMode       | string        | *(available since version 1.1.0)*                                      |
|                 |               |                                                                        |
|                 |               | Used to choose ADODB's fetch mode, which influences the type of        |
|                 |               | array returned by the recordset. Set to:                               |
|                 |               |                                                                        |
|                 |               | |                                                                      |
|                 |               |                                                                        |
|                 |               | - **1** for a numerical array                                          |
|                 |               | - **2** for an associative array                                       |
|                 |               | - **3** for both                                                       |
|                 |               |                                                                        |
|                 |               | Not setting this value will fall back on the default behavior, which   |
|                 |               | is unpredictable as it depends on each driver. For more information    |
|                 |               | refer to http://phplens.com/lens/adodb/docs-adodb.htm#adodb_fetch_mode |
+-----------------+---------------+------------------------------------------------------------------------+


.. _configuration-connection:

Connection methods
^^^^^^^^^^^^^^^^^^

The current implementation of the SQL Connector only uses the classic way of setting up a connection:

.. code-block:: php

	$adodbObject = ADONewConnection($parameters['driver']);
	$adodbObject->Connect(
		$parameters['server'],
		$parameters['user'],
		$parameters['password'],
		$parameters['database']
	);

that is, with the four standard parameters: server, user, password and database.
This does not work for all database systems, but I currently had no use for more,
nor a proper setup to test with other database system.
The current version of the SQL connector was tested only with MySQL and PostgreSQL.

If you encounter problems connecting to some database system,
please report an issue in the
`dedicated bug tracker <http://forge.typo3.org/projects/extension-svconnector_sql/issues>`_
indicating as clearly as possible what connection syntax you would need.
