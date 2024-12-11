<!DOCTYPE HTML>
<html>
	<head>
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
					<a href="#"> Home </a>
					<a href="#" class="drop"> Product </a>
					<a href="home.php?page=page2"> About </a>
					<a href="#"> Contact </a>
				</div>
			</div>
		</div>
		<div id="section">
			<?php
		if(!empty($_GET['page'])){
			$page_dir = 'php';
			$PSOpages = scandir($page_dir, 0);
			unset($PSOpages[0], $PSOpages[1]);
			
			$page = $_GET['page'];
			if(in_array($page.'.php', $PSOpages)){
			 include_once('php/'.$page.'.php');
			} else {
				//echo 'Halaman Javasript tidak ditemukan! :(';
			}
		}
		?>
		</div>
	</body>
</html>