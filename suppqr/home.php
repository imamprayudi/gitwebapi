<?php
	session_start();
	$vuserid 	= $_POST['userid'];
	$_SESSION['s_userid'] = $vuserid;
	
	
	
	$session_userid = $_SESSION['s_userid'];
	
	if (!isset($_SESSION['s_userid']))
	{
		echo '<script language="javascript"> location.href = "http://www.jvc-jein.co.id"; </script>'; 
	}
	else
	{
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
								<p> PT. JVCKENWOOD ELECTRONICS INDONESIA </p>
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
			
			<div id="section" align="center">
				<img height="450" src="img/home.png" />
			</div>
		</div>		
	</body>
</html>
<?php
	}
?>