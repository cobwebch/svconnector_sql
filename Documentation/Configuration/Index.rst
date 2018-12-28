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

+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| Parameter       | Data type     | Description                                                                                                                  |
+=================+===============+==============================================================================================================================+
| driver          | string        | Name of the database system to connect to, taken from the list of                                                            |
|                 |               | available drivers.                                                                                                           |
|                 |               |                                                                                                                              |
|                 |               | See http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#driver                    |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| server          | string        | Address of the server to connect to.                                                                                         |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| user            | string        | User name to use to connect to the database.                                                                                 |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| password        | string        | Password to use for the given user.                                                                                          |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| database        | string        | Name of the database to connect to.                                                                                          |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| query           | string        | The actual query to execute.                                                                                                 |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| init            | string        | SQL queries to be sent before the actual query (defined in                                                                   |
|                 |               | parameter :code:`query`) is executed. This is typically used to                                                              |
|                 |               | temporarily change the encoding.                                                                                             |
|                 |               |                                                                                                                              |
|                 |               | **Example:**                                                                                                                 |
|                 |               |                                                                                                                              |
|                 |               | .. code-block:: sql                                                                                                          |
|                 |               |                                                                                                                              |
|                 |               |    SET NAMES 'UTF8';                                                                                                         |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
| fetchMode       | string        | Used to choose the fetch mode, which influences the type of                                                                  |
|                 |               | array returned by the recordset (numerical, associative or both)                                                             |
|                 |               |                                                                                                                              |
|                 |               | Use the name of the constants from the PDO drivers.                                                                          |
|                 |               | Reference: http://php.net/manual/en/pdostatement.fetch.php                                                                   |
+-----------------+---------------+------------------------------------------------------------------------------------------------------------------------------+
