﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: /Includes.rst.txt


.. _installation:

Installation
------------

Install this extension and you can start using its API for
issuing SQL queries to any database inside your own code.

It requires extension “svconnector” which provides the base
for all connector services.


.. _installation-update-500:

Updating to 5.0.0
^^^^^^^^^^^^^^^^^

Version 5.0.0 adds support for TYPO3 13 and PHP 8.4, while dropping support
for TYPO3 11 and PHP 7.4 and 8.0.

Events have been introduced to replace hooks. Existing hooks are still in place,
but are deprecated and events should now be used instead
(see the :ref:`svconnector manual <svconnector:developers-events>` for reference).


.. _installation-update-400:

Updating to 4.0.0
^^^^^^^^^^^^^^^^^

Version 4.0.0 adds support for TYPO3 12 and PHP 8.1, while dropping support
for TYPO3 10. It adapts to the new way of registering Connector Services.
The update process should be smooth with "svconnector" version 5.0.0.


.. _installation-update-300:

Updating to 3.0.0
^^^^^^^^^^^^^^^^^

Version 3.0.0 adds support for TYPO3 11 and PHP 8.0, while dropping support
for TYPO3 8 and 9. Apart from that it does not contain other changes and
the update process should be smooth.


.. _installation-updating:

Updating to 2.2.0
^^^^^^^^^^^^^^^^^

The old ADODB-based database abstraction layer was entirely removed in version 2.2.0.
This will affect your existing configuration if you used the :code:`uri` parameter
to define your database connections. **There is no backward compatibility**.
Please check the :ref:`Configuration chapter <configuration>` to check which
parameters can be used instead.

A smaller breaking change is that the `fetchMode` parameter now uses directly
a PHP constant (or its equivalent value). Before version 2.2.0, the constant
was used as a string and interpreted by the service using :code:`constant()`.
You need to adapt your configuration accordingly.
