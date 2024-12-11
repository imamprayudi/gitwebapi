<?php
session_start();
if (isset($_SESSION['usr'])) {
	$session_userid = $_SESSION['usr'];
} else {
	echo "session time out";
?>
	<script>
		window.location.href = '../index.php';
	</script>
<?php
}

include('con_svrdbn.php');
?>
<!DOCTYPE HTML>
<html>

<head>
	<title> JEIN - Barcode Receiving Online </title>
	<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
	<script src="../assets/js/jquery.js"></script>
	<link rel="shortcut icon" href="../assets/gambar/icons/receiving.ico" />
	<link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body>

	<?php
	// tampilkan data
	// include("jmenusuppcss.php");
	include('../contents_v2/layouts/header.php');

	?>
	<main id="main" class="main">

		<div class="pagetitle">
			<h1>Standard Packing Maintenance</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Delivery</a></li>
					<li class="breadcrumb-item active">Standard Packing Maintenance</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section">
			<div class="row">
				<div class="card card-info">
					<div class="card-body">
						<?php
						// echo '<div id="section">';
						// echo '<br />';
						// echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">';
						// echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA ';
						// echo '<br />';
						// echo 'STANDARD PACKING MAINTENANCE';
						// echo '<br /><br />';
						?>
						<form method="post" action="jstd_pack_list.php" class="row gx-3 gy-2 align-items-center">
							<div class="col-7">
								<label class="col-form-label" for="suppcode">Supplier</label>
								<select class="form-select" name="suppcode" id="suppcode">
									<?php
									$rs_cb_suppcode = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp inner join Supplier on usersupp.SuppCode = Supplier.SuppCode where UserId = '" . $session_userid . "' order by suppname asc");
									while (!$rs_cb_suppcode->EOF) {
										echo '<option value="' . $rs_cb_suppcode->fields[1] . '">' . $rs_cb_suppcode->fields[1] .
											' - ' . $rs_cb_suppcode->fields[2] . '</option>';
										$rs_cb_suppcode->MoveNext();
									}
									?>
								</select>
							</div>
							<div class="col-2 mt-4">
								<input type="submit" value="Get Part List" name="subpart" id="subpart" class="btn btn-info">
							</div>
							<!-- <table border=0 cellpadding=0 cellspacing=0 width=55%>
								<tr>
									<td width="250px" valign="top">Select Supplier</td>
									<td> <select name="suppcode">


										</select></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan=2>
										<input type="submit" value="Get Part List" id="subpart" name="subpart">
									</td>
								</tr>
							</table> -->
						</form>
						<?php
						$rs_cb_suppcode->Close();
						$db->Close();
						?>
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->

	<?php include('../contents_v2/layouts/footer.php'); ?>
</body>
</body>

</html>