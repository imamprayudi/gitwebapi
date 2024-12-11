<?php
	include('../con_svrdbn.php');
		
	
	
	/**	select search **/
	$supp		 = isset($_REQUEST['supp']) ? trim( str_replace("'", "#", $_REQUEST['supp']) ) : "xx";
	$partnumber  = isset($_REQUEST['partnumber']) ? trim( str_replace("'", "#", $_REQUEST['partnumber']) ) : "";
	
	
	$rs = $db->execute("select	partnumber, partname, stdpack_supp, replikasi
						from  	stdpack
						where	suppcode = '" .$supp."' and partnumber like '%".$partnumber."%'
						order by partnumber asc");
						$totalcount = $rs->PO_RecordCount("	select	partnumber, partname, stdpack_supp, replikasi
						from  	stdpack	where	suppcode = '".$supp."' and partnumber like '%".$partnumber."%'");
	$return = array();
	/** end of **/
	

	for ($i = 0; !$rs->EOF; $i++) {
		
		$return[$i]['partnumber'] 	= $rs->fields['0'];
		$return[$i]['partname'] 	= $rs->fields['1'];
		$return[$i]['stdpack_supp'] = intval($rs->fields['2']);
		$return[$i]['replikasi'] 	= $rs->fields['3'];
		
		$rs->MoveNext();
	}
	
	$o = array(
		"success"=>true,
		"totalCount"=>$totalcount,
		"rows"=>$return);
	
	echo json_encode($o);
	
	// Closing Database Connection
	$rs->Close();
	$db->Close();
?>