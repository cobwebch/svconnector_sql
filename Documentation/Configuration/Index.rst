.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Includes.rst.txt


.. _configuration:

Configuration
-------------

This chapter describes the parameters that can be used to configure the SQL connector service.


.. _configuration-driver:

driver
^^^^^^

Type
  string

Description
  Name of the database system to connect to, taken from the list of available drivers.

  See https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#driver


.. _configuration-driver-class:

driverClass
^^^^^^^^^^^

Type
  string

Description
  Fully-qualified name of a custom driver class.


.. _configuration-server:

server
^^^^^^

Type
  string

Description
  Address of the server to connect to.


.. _configuration-user:

user
^^^^

Type
  string

Description
  User name to use to connect to the database.


.. _configuration-password:

password
^^^^^^^^^^^

Type
  string

Description
  Password to use for the given user.


.. _configuration-database:

database
^^^^^^^^

Type
  string

Description
  Name of the database to connect to.


.. _configuration-query:

query
^^^^^

Type
  string

Description
  The actual query to execute.


.. _configuration-init:

init
^^^^

Type
  string

Description
  SQL queries to be sent before the actual query (defined in parameter :code:`query`) is executed.
  This is typically used to temporarily change the encoding.

  **Example:**

  .. code-block:: sql

     SET NAMES 'utf8mb4';


.. _configuration-fetch-mode:

fetchMode
^^^^^^^^^

Type
  int

Description
  Used to choose the fetch mode, which influences the type of array
  returned by the recordset (only numerical, associative or first column are supported).

  Use the name of the constants from the PDO drivers or the numerical values
  (numerical = 3, associative = 2, first column = 7)

  Reference: https://www.php.net/manual/en/pdostatement.fetch.php

Default
  2 (associative)
