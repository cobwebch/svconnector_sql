.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _installation:

Installation
------------

Install this extension and you can start using its API for
issuing SQL queries to any database inside your own code.

It requires extension “svconnector” which provides the base
for all connector services.


.. _installation-updating:

Updating to 2.2.0
^^^^^^^^^^^^^^^^^

The old ADODB-based database abstraction layer was entirely removed in version 2.2.0.
This will affect your existing configuration if you used the :code:`uri` parameter
to define your database connections. **There is no backward compatibility**.
Please check the :ref:`Configuration chapter <configuration>` to check which
parameters can be used instead.
