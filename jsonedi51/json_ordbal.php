<?php
	/*
	****	create by Mohamad Yunus
	****	on 25 Agustus 2017
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
    $page		= @$_REQUEST["page"];
	$limit		= @$_REQUEST["limit"];
	$start		= (($page*$limit)-$limit)+1;
	
	//	execute query
	$sql 		= "declare @totalcount as int; exec dispOrdbal $start, $limit, '{$stdate}', '{$endate}', '{$supp}', @totalcount=@totalcount out";
    $rs 		= $db->Execute($sql);
    $totalcount = $rs->fields[12];
	
	//	array data
	$return = array();
	
	for ($i = 0; !$rs->EOF; $i++) {
		$return[$i]['partnumber'] 	= $rs->fields[0];
		$return[$i]['partname'] 	= $rs->fields[1];
		$return[$i]['orderqty'] 	= $rs->fields[2];
		$return[$i]['reqdate'] 		= $rs->fields[3];
		$return[$i]['ponumber'] 	= $rs->fields[4];
		$return[$i]['posq'] 		= $rs->fields[5];
		$return[$i]['orderbalance'] = $rs->fields[6];
		$return[$i]['supprest'] 	= $rs->fields[7];
		$return[$i]['model'] 		= $rs->fields[8];
		$return[$i]['issuedate'] 	= $rs->fields[9];
		$return[$i]['potype'] 		= $rs->fields[10];
		$return[$i]['statusread'] 	= $rs->fields[11];
		$rs->MoveNext();
	}
	
	$o = array(
		"success"=>true,
		"totalcount"=>$totalcount,
		"rows"=>$return);
		
	echo json_encode($o);
	
	//	connection close
	$rs->Close();
	$db->Close();
?>
