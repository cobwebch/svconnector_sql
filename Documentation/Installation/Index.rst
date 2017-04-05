.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _installation:

Installation
------------

Install this extension and you can start using it's API for
issuing SQL queries to any database inside your own code
(although please see the limitations discussed in chapter
:ref:`Configuration <configuration>`).

It requires extension “svconnector” which provides the base
for all connector services. With TYPO3 v7, it also requires
system extension "adodb" to load the ADODB library. With
TYPO3 v8, the Doctrine DBAL library is anyway loaded via the
base Composer configuration.

.. important::

   Which abstraction layer is used is determined automatically
   depending on TYPO3 version. However this means that "adodb"
   does not appear explicitely as a dependency anymore. Running
   "svconnector_sql" in TYPO3 v7 without "adodb" loaded will
   result in the SQL connector service being flagged as unavailable.

.. note::

   The whole compatibility layer which makes it possible to use both
   ADODB and Doctrine DBAL and thus ensures compatibility across
   TYPO3 version 7 and 8 will be removed in a future release.
