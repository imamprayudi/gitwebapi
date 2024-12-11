<?php
	session_start();
	$session_userid = $_SESSION['s_userid'];
	
	include('../con_svrdbn.php');
	
	
	
	$replikasi		= $_REQUEST['replikasi'];
	$stdpack_supp	= isset($_REQUEST['stdpack_supp']) ? $_REQUEST['stdpack_supp'] : '0';

	//	action
	try
		{
			$rs 	= $db->Execute("update 	stdpack set		stdpack_supp = '{$stdpack_supp}', input_user = '{$session_userid }', input_date = (select convert(varchar(20), getdate(), 120))
									where 	replikasi = '{$replikasi}'");
			$rs->Close();
		
			$var_msg = 1;
		}
	catch (exception $e)
		{
			$var_msg = $db->ErrorNo();
		}
		
	//	Message
	switch ($var_msg)
		{
			case $db->ErrorNo():
				$err		= $db->ErrorMsg();
				$error 		= str_replace( "'", "`", $err);
				$error_msg 	= str_replace( "[Microsoft][ODBC SQL Server Driver][SQL Server]", "", $error);
				
				echo "{
					'success': false,
					'msg': '$error_msg'
				}";
				break;
			
			case 1:
				echo "{
					'success': true,
					'msg': 'Data has been updated.'
				}";
				break;
		}
	//	end of message
	
	
	// Closing Database Connection
	$db->Close();
?>