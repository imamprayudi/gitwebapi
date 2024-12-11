<?php
	include('../../adodb5/adodb.inc.php');
	include_once('../../adodb5/toexport.inc.php');
	include('../../adodb5/adodb-exceptions.inc.php');
	include('../../adodb5/adodb-errorpear.inc.php');
	
	
	/* koneksi ke MSSQL
	$db = ADONewConnection('odbc_mssql');
	$dsn = "Driver={SQL Server};Server=136.198.117.5;Database=edi;";
	$db->Connect($dsn,'sa','password');
	*/
	
/* koneksi ke MSSQL */
$db = ADONewConnection('odbc_mssql');
$dsn = "Driver={SQL Server};Server=136.198.117.80\JEINSQL2017S;Database=EDI;app=JKEI WEB";
$db->Connect($dsn,'sa','password');
    
    /* koneksi ke mysql 
    $db = ADONewConnection("mysql");
	$db->Connect('localhost', 'root', 'Jvc@123', 'ediweb');
    */
?>