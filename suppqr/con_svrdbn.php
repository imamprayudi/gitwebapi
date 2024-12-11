<?php
	include 'adodb/adodb.inc.php';
	
	$db = ADONewConnection('odbc_mssql');
	$dsn = "Driver={SQL Server};Server=136.198.117.48\JEINSQL2012;Database=edi;";
	$db->Connect($dsn,'sa','JvcSql@123');
?>



