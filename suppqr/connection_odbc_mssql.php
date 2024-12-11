<?php
		include 'adodb/adodb.inc.php';
	
		$db = ADONewConnection('odbc_mssql');
		// $dsn = "Driver={SQL Server};Server=136.198.117.5;Database=edi;";
		// $db->Connect($dsn,'sa','password');
		$dsn = "Driver={SQL Server};Server=136.198.117.80\jeinsql2017s;Database=edi;";
		$db->Connect($dsn,'sa','password');
?>



