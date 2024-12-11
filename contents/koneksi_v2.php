<?php
	
/* koneksi ke MSSQL */
$db = ADONewConnection('odbc_mssql');
$dsn = "Driver={SQL Server};Server=136.198.117.80\jeinsql2017s;Database=edi;app=JEIN WEB";
$db->Connect($dsn,'sa','password');
    
    /* koneksi ke mysql 
    $db = ADONewConnection("mysql");
	$db->Connect('localhost', 'root', 'Jvc@123', 'ediweb');
    */

?>