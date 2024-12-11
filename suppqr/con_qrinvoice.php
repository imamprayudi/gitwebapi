<?php
	include 'adodb/adodb.inc.php';
	
	$db_qrinvoice = ADONewConnection('odbc_mssql');
	$dsn = "Driver={SQL Server};Server=136.198.117.48\JEINSQL2012;Database=QRINVOICE;";
	$db_qrinvoice->Connect($dsn,'sa','JvcSql@123');
?>



