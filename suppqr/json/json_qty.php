<?php
	include('../connection_odbc_mssql.php');
	$suppcode	= isset($_REQUEST['suppcode']) ? trim( str_replace("'", "#", $_REQUEST['suppcode']) ) : "";
	$partnumber	= isset($_REQUEST['partno']) ? trim( str_replace("'", "#", $_REQUEST['partno']) ) : "";
	$ponumber	= isset($_REQUEST['pono']) ? trim( str_replace("'", "#", $_REQUEST['pono']) ) : "";
	
	
	$rs = $db->Execute("select orderbalance from ordbal 
						where 	suppcode 	= '".$suppcode."' and 
								partnumber 	= '".$partnumber."' and 
								ponumber 	= '".$ponumber."'
						order by orderbalance asc");
	$return = array();

	for ($i = 0; !$rs->EOF; $i++) {
		
		$return[$i]['qty'] 		= trim($rs->fields['0']);
		
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