<?php
session_start();
if (isset($_SESSION['dinew_smyid'])) {
	$myusername = $_SESSION["dinew_smyid"];
} else {
	echo "session time out";
?>
	<script>
		window.location.href = '../index.php';
	</script>
<?php
}

?>
<html>

<head>
	<TITLE>DELIVERY INSTRUCTIONS - DATE SELECTION</TITLE>
	<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
	<script src="../assets/js/jquery.js"></script>
</head>

<body bgcolor="#ffffff">
	<p>
		<?php
		// include("jmenucss.php");
		include('../contents_v2/layouts/header.php');

		// echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">';
		// echo 'PT.JVC ELECTRONICS INDONESIA ';
		// echo '<br />';
		// echo 'GET DELIVERY INSTRUCTIONS';
		// echo '<br /><br />';
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
		include 'koneksi.php';

		$sql	= "SELECT userid,suppcode,suppname FROM usersupp WHERE userid='{$myusername}' order by suppname";
		$result	= $db->execute($sql);
		// pesan error
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			$pesan = $_REQUEST['p'];
		}
		// echo "<br>";
		echo $pesan;
		// echo "<br><br>";
		?>
	<main id="main" class="main">

		<div class="pagetitle">
			<h1>Delivery - Get Delivery Instructions</h1>
			<nav>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
					<li class="breadcrumb-item"><a href="#">Delivery</a></li>
					<li class="breadcrumb-item"><a href="jverify.php">Delivery Instruction</a></li>
					<li class="breadcrumb-item active">Get Delivery Instruction</li>
				</ol>
			</nav>
		</div><!-- End Page Title -->

		<section class="section">
			<div class="row">
				<div class="card card-info">
					<div class="card-body">
						<form action="jdimake.php" method="post" id="frmdi" name="frmdi">
							<div class="col">
								<label class="col-form-label" for="idsupp">Supplier</label>
								<select class="form-select" name="supp" id="idsupp">
									<?php
									while (!$result->EOF) {
										echo '<option value="' . $result->fields[1] . '">' . $result->fields[2] . ' - ' . $result->fields[1] . '</option>';
										$result->MoveNext();
									}
									?>
								</select>
							</div>
							<div class="col">
								<label class="col-form-label" for="idsupp">Select Date</label>
								<select class="form-select" name="didate" id="didate">
									<?php
									for ($i = 1; $i <= 31; $i++) {
										if ($i == date("d")) {
											if ($i <= 9) {
												echo "<option value=$i selected>0$i</option>";
											} else {
												echo "<option value=$i selected>$i</option>";
											}
										} else {
											if ($i <= 9) {
												echo "<option value=$i>0$i</option>";
											} else {
												echo "<option value=$i>$i</option>";
											}
										}
									}
									?>

								</select>
							</div>
							<div class="col">
								<label class="col-form-label" for="idsupp">Month</label>
								<Select class="form-select" name="dimonth">
									<?php
									for ($i = 1; $i <= 12; $i++) {
										if ($i == date("m")) {
											if ($i <= 9) {
												echo "<option value=$i selected>0$i</option>";
											} else {
												echo "<option value=$i selected>$i</option>";
											}
										} else {
											if ($i <= 9) {
												echo "<option value=$i>0$i</option>";
											} else {
												echo "<option value=$i>$i</option>";
											}
										}
									}
									?>
								</select>
							</div>
							<div class="col">
								<label class="col-form-label" for="idsupp">Year</label>
								<Select class="form-select" name="diyear">
									<option value='2013' selected>2013</option>

									<?php
									$current = date("Y");
									$nextcurrent = (date("Y") + 2);
									for ($i = 2013; $i <= $nextcurrent; $i++) {
										if ($i == $current) {
											echo "<option value =$i selected>$i</option>";
										} else {
											echo "<option value =$i>$i</option>";
										}
									}
									?>

								</select>
							</div>
							<div class="col">
								<label class="col-form-label" for="disq">Sequence</label>
								<Select class="form-select" name="disq">
									<option value='1' selected>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
								</select>
							</div>
							<div class="col-2 mt-4">
								<input type="submit" value="Get DI" name="submit1" id="submit1" class="btn btn-info">
							</div>
						</form>
						<br>
						Petunjuk :<br>
						pilih sequence = 1 , untuk mendapatkan Delivery Instruction secara kondisi normal<br><br>

						Untuk Supplier dengan 1X delivery per hari follow Time Delivery Schedule, pertama pilih sequence 1 untuk mendapatkan delivery instruction dengan quantity sesuai Time Delivery Schedule<br>
						Setelah itu update data dengan input invoice,<br>
						Sesuaikan quantity dengan actual delivery <br>
						Upload data.....<br><br>

						Jika pada sequence 1 ada perubahan quantity , maka balance akan muncul pada Delivery Instruction sequence selanjutnya<br>
						maka perlu untuk Get Delivery Instruction sequence selanjutnya....<br><br>
						Pastikan data sequence 1 telah terupload semua !!! <br>
						kembali ke menu Get Delivery Instruction<br>
						pilih tanggal yg sama kemudian pilih sequence 2<br>
						maka Delivery Instruction akan muncul dengan balance quantity.<br>
						update data dengan input invoice dan upload......
						<?php
						$db->Close();
						?>
					</div>
				</div>
			</div>
		</section>

	</main><!-- End #main -->

	<?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>