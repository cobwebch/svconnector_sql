.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

=============
Configuration
=============

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

.. _configuration-typo3-database:

Connect to TYPO3's own database
===============================

You can also connect to the database of your current TYPO3 installation. This might be useful to migrate data 
from one table format to another. You could for example migrate data from :sql:`tt_news`
to :sql:`tx_news_domain_model_news`:

.. code-block:: php
   :caption: EXT:my_extension/Configuration/TCA/Overrides/tx_news_domain_model_news.php
   
   
   $GLOBALS['TCA']['tx_news_domain_model_news'] = array_replace_recursive($GLOBALS['TCA']['tx_news_domain_model_news'],
   [
      'external' => [
         'general' => [
            0 => [
               'connector' => 'sql',
               'parameters' => [
                  'driver' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['driver'],
                  'server' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'],
                  'user' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'],
                  'password' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'],
                  'database' => $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'],
                  'query' => 'SELECT * FROM tt_news LIMIT 5'
               ],
               'data' => 'array',
               'referenceUid' => 'wco_research_shop_import',
               'priority' => 5000,
               'description' => 'News import from csv'
            ]
         ]
      ],
      'columns' => [
         // ...
      ],
   ]);

