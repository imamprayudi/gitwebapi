<!DOCTYPE HTML>
<html>

<head>
	<title>DELIVERY INSTRUCTIONS</title>
	<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
	<script src="../assets/js/jquery.js"></script>

</head>

<body>

	<?php
	session_start();
	if (isset($_SESSION['usr'])) {
		$myid = $_SESSION["usr"];
	} else {
		echo "session time out";
	?>
		<script>
			window.location.href = '../index.php';
		</script>
	<?php
	}

	include("koneksi.php");
	$sql 	= "select userid,userpass,usersecure,usergroup,username,
  useremail,useremail1,useremail2 from usertbl where UserId = '" . $myid . "'";
	$rs 	= $db->execute($sql);
	$hitung = $rs->PO_RecordCount($sql);
	$usrlevel = $rs->fields[2];
	if ($hitung == 1) {
		$_SESSION['dinew_smyid'] = $myid;
		$_SESSION['dinew_suserlevel'] = $usrlevel;
		// include("jmenucss.php");
		include('../contents_v2/layouts/header.php');

	?>
		<main id="main" class="main">

			<div class="pagetitle">
				<h1>Delivery Instruction</h1>
				<nav>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Delivery</a></li>
						<li class="breadcrumb-item active">Delivery Instruction</li>
					</ol>
				</nav>
			</div><!-- End Page Title -->

			<section class="section">
				<div class="row">
					<div class="card card-info">
						<div class="card-body mt-2">
							<a href="jdimaketgl.php">Get Delivery Instructions</a>
							<p> Gunakan pilihan ini hanya 1 kali per tanggal Delivery untuk mendapatkan Delivery Instruction ( Jika anda memilih lagi menu ini setelah anda mengedit Delivery Instruction seperti edit invoice namun status data belum upload, maka data akan direset ulang)</p>
						</div>
					</div>
					<div class="card card-info">
						<div class="card-body mt-2">
							<a href="jditgl.php">Edit Delivery Instructions</a>
							<p> Gunakan pilihan ini untuk melanjutkan pengeditan</p>
						</div>
					</div>
					<div class="card card-info">
						<div class="card-body mt-2">
							<a href="jdiviewtgl.php">View Delivery Instructions</a>
						</div>
					</div>
				<?php

				$sqlob 	= "select top 1 TransDate from ordbal";
				$rsob 	= $db->execute($sqlob);

				while (!$rsob->EOF) {
					echo '<br>';
					$rsob->MoveNext();
				}
				$rsob->Close();
			} else {
				echo "Wrong Username or Password";
			}

			$rs->Close();
			$db->Close();
				?>
				</div>

			</section>

		</main><!-- End #main -->

		<?php include('../contents_v2/layouts/footer.php'); ?>