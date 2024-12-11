<?php
	/*
	****	create by Mohamad Yunus
	****	on 27 Agustus 2017
	****	remark: hasil json ini dikirim ke http://112.78.139.51/edi/ordbalnew.asp
	*/
	
	//CORS 
	header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Headers: X-Requested-With'); 

	include('../../adodb5/adodb.inc.php');
	include('../../adodb5/adodb-exceptions.inc.php');
	include('../../adodb5/adodb-errorpear.inc.php');
	
	//	JEINID
	$db = ADONewConnection('odbc_mssql');
	$dsn = "Driver={SQL Server};Server=136.198.117.80\jeinsql2017s;Database=edi;";
	$db->Connect($dsn,'sa','password');
	
	//	get paramater
	$stdate		= trim(@$_REQUEST["valstdate"]);
	$endate		= trim(@$_REQUEST["valendate"]);
	$supp		= trim(@$_REQUEST["valsuppcode"]);
	
	//	execute query
	$sql 		= "exec downOrdbal '{$stdate}', '{$endate}', '{$supp}'";
    $rs 		= $db->Execute($sql);
	
	//	save file
	$fname = "DataOrdbal-{$supp}-{$stdate}sd{$endate}.csv";
	
	//	input data in file
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=$fname");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$fp = fopen("php://output", "w");
	$headers = 'PART_NO, PART_NAME, ORDER_QTY, REQ_DATE, PO_NO, SQ, ORDER_BALANCE, SUPP_REST, MODEL, ISSUE_DATE, PO_TYPE, READ_STATUS' . "\n";
	fwrite($fp,$headers);
	
	while(!$rs->EOF)
	{
		fputcsv($fp, array(	$rs->fields['0'], $rs->fields['1'], $rs->fields['2'], 
							$rs->fields['3'], $rs->fields['4'], $rs->fields['5'], 
							$rs->fields['6'], $rs->fields['7'], $rs->fields['8'],
							$rs->fields['9'], $rs->fields['10'], $rs->fields['11']));
	   
		$rs->MoveNext();
	}
	
	//	connection close
	fclose($fp);
	$rs->Close();
    $db->Close();
?>
