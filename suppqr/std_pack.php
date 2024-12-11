<?php
	session_start();
	$session_userid = $_SESSION['s_userid'];
	
	include('connection_odbc_mssql.php');
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> JEIN - Barcode Receiving Online </title>
		<link rel="shortcut icon" href= "icons/receiving.ico"/>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	</head>
	
	<body>
		<div id="wrapper">
			<div id="header"> 
				<table height="100px" width="100%">
					<tr> 
						<td valign="bottom"> <img class="logo" src="img/jvc-logo.png"> </td>
						<td valign="bottom">
							<div class="description">
								<p> PT. JVC ELECTRONICS INDONESIA </p>
								<p> JL.SURYA LESTARI KAV.I-16B </p>
								<p> KOTA INDUSTRI SURYA CIPTA, </p>
								<p> TELUK JAMBE KARAWANG, </p>
								<p> 41361 - INDONESIA. TELP : (0267)440520 </p>
							</div>
						</td>
					</tr>
				</table> 
			</div>
			
			<div id="nav">
				<div class="menu">
					<?php include "1menu.php"; ?>
				</div>
			</div>
			
			<div id="section">
<?php
			// tampilkan data
			echo '<form method="post" action="std_pack_list.php">';
				echo '<table border=0 cellpadding=0 cellspacing=0 width=55%>';
				echo '<tr>';
					echo '<td width="250px" valign="top">Select Supplier</td>';
					echo '<td> <select name="suppcode">';
						$rs_cb_suppcode = $db->Execute("select [UserId]
														,[SuppCode]
														,[SuppName]
														,[scold]
														,[scnew] 
														from usersupp where userid = '" .$session_userid. "' order by suppname asc");
						while (!$rs_cb_suppcode->EOF)
						{
							echo '<option value="' . $rs_cb_suppcode->fields[1] . '">' . $rs_cb_suppcode->fields[1] . ' - ' . $rs_cb_suppcode->fields[2] . '</option>';
							$rs_cb_suppcode->MoveNext();
						}
					echo '</select></td>';
				echo '</tr>';
				echo '<tr><td>&nbsp;</td></tr>';
				echo '<tr>';
					echo '<td colspan=2>';
						echo '<input type="submit" value="Get Part List" id="subpart" name="subpart">';
					echo '</td>';
				echo '</tr>';
				echo '</table>';
			echo '</form>';
			
			$rs_cb_suppcode->Close(); $db->Close();
?>
			</div>
		</div>		
	</body>
</html>