.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Includes.rst.txt


.. _special-considerations:

Special considerations
----------------------


.. _configuration-typo3-database:
.. _special-considerations-typo3-database:

Connect to TYPO3's own database
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

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
               'referenceUid' => 'import_id',
               'priority' => 5000,
               'description' => 'News import from own database'
            ]
         ]
      ],
      'columns' => [
         // ...
      ],
   ]);

