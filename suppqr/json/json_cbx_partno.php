<?php
	include('../connection_odbc_mssql.php');
	$suppcode	= isset($_REQUEST['suppcode']) ? trim( str_replace("'", "#", $_REQUEST['suppcode']) ) : "";
	$partnumber	= isset($_REQUEST['partno']) ? trim( str_replace("'", "#", $_REQUEST['partno']) ) : "";
	
	$rs = $db->Execute("select distinct partnumber from ordbal where suppcode = '".$suppcode."' and partnumber like '%".$partnumber."%' order by partnumber asc");
	$return = array();

	for ($i = 0; !$rs->EOF; $i++) {
		
		$return[$i]['partno'] 		= trim($rs->fields['0']);
		
		$rs->MoveNext();
	}
	
	$o = array(
		"success"=>true,
		"rows"=>$return);
	
	echo json_encode($o);
		
	
	// Closing Database Connection
	$rs->Close();
	$db->Close();
?>