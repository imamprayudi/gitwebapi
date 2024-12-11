<!DOCTYPE HTML>
<html>

<head>
	<title>SOA</title>
	<style type="text/css">
		@import "../assets/css/jquery.datepick.css";

		.form-control {
			height: 48px;
			border-radius: 25px;
		}

		.form-control:focus {
			color: #495057;
			background-color: #fff;
			border-color: #35b69f;
			outline: 0;
			box-shadow: none;
			text-indent: 10px;
		}

		.c-badge {
			background-color: #35b69f;
			color: white;
			height: 20px;
			font-size: 11px;
			width: 92px;
			border-radius: 5px;
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 2px;
		}

		.comment-text {
			font-size: 13px;
		}

		.wish {

			color: #35b69f;
		}
	</style>
	<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
	<script src="../assets/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.datepick.js"></script>
</head>

<body>
	<?php
	session_start();
	if (isset($_SESSION['usr'])) {
		$myid = $_SESSION["usr"];
		$mysecure = $_SESSION["usrsecure"];
	} else {
		echo "session time out";

	?>
		<script>
			window.location.href = '../index.php';
		</script>
	<?php
	}

	include("koneksi.php");
	if (isset($_GET['supp'])) {
		$suppid = $_GET['supp'];
	}

	if (isset($_GET['tgl'])) {
		$tgl = $_GET['tgl'];
	}

	$tahunsoa = substr($tgl, 0, 4);
	$tablesoa = 'soa' . $tahunsoa;
	if ($tahunsoa < 2020) {
		$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
	invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,vat,
	salesvat,payment,balance from " . $tablesoa . " where (hd = 'H') and (suppcode = '" . $suppid . "') 
	and (transdate = '" . $tgl . "')");
	} else {
		$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
	invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,vat,
	salesvat,payment,balance from soa where (hd = 'H') and (suppcode = '" . $suppid . "') 
	and (transdate = '" . $tgl . "')");
	}

	$ada = $rs->RecordCount();
	if ($ada == 0) {
		// echo 'Data Nothing ....';
	?>
		<div class="mt-4 container col-12 text-center text-danger">
			<h2>Data Nothing ....</h2>
		</div>
	<?php
		die();
	}
	$query = "select suppcom,jeincom from soacom where blnthn = '" . $rs->fields[3] . "' and
	  suppcode = '" . $rs->fields[4] . "'";
	$rc = $db->Execute($query);
	$supp = intval($suppid) * 14102703;
	// print_r($rs->fields);
	// print_r($rc->fields);
	?>
	
	<form id="frmcom" action="jsoacom.php" method="post">
		<?php
		if ($mysecure == '3') {
			if (isset($rc->fields[1])) {
			?>
			<article class="card bg-light">
				<header class="card-header border-0 bg-transparent d-flex align-items-center">
					<div>
						<img src="../assets_v2/img/person.png" class="rounded-circle me-2" width="50px" /><a class="fw-semibold text-decoration-none">JKEI</a>
						<span class="ms-3 small text-muted">comment</span>
					</div>
					<div class="dropdown ms-auto">
						<button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="bi bi-three-dots-vertical"></i>
						</button>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">Report</a></li>
						</ul>
					</div>
				</header>
				<div class="card-body py-2 px-3">
					<?= $rc->fields[1] ?>
				</div>
				<footer class="card-footer bg-white border-0 py-1 px-3">
				</footer>
			</article>
			<?php
			}
			if (isset($rc->fields[0])) {
			?>
				<article class="card bg-light">
					<header class="card-header border-0 bg-transparent d-flex align-items-center">
						<div>
							<img src="../assets_v2/img/person.png" class="rounded-circle me-2" width="50px" /><a class="fw-semibold text-decoration-none">Supplier</a>
							<span class="ms-3 small text-muted">comment</span>
						</div>
						<div class="dropdown ms-auto">
							<button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-three-dots-vertical"></i>
							</button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#">Report</a></li>
							</ul>
						</div>
					</header>
					<div class="card-body py-2 px-3">
						<?= $rc->fields[0] ?>
					</div>
					<footer class="card-footer bg-white border-0 py-1 px-3">
					</footer>
				</article>
			<?php
			}
			?>
			<div class="card bg-light">
				<header class="card-header border-0 bg-transparent">
					<img src="../assets_v2/img/person.png" class="rounded-circle me-2" width="50px" /><a class="fw-semibold text-decoration-none">Supplier</a>
					<span class="ms-3 small text-muted">comment</span>
				</header>
				<div class="card-body py-1">
					<form>
						<div>
							<label for="exampleFormControlTextarea1" class="visually-hidden">
								Comment</label>
							<textarea class="form-control form-control-sm border border-2 rounded-1" id="txtcom" name="txtcom" style="height: 50px" placeholder="Add a comment..." minlength="3" maxlength="255" required></textarea>
							<input type="hidden" id="hcom" name="hcom" value="jeincom">
							<input type="hidden" id="hsupp" name="hsupp" value="<?= $rs->fields[4] ?>">
							<input type="hidden" id="hblnthn" name="hblnthn" value="<?= $rs->fields[3] ?>">
						</div>
					</form>
				</div>
				<footer class="card-footer bg-transparent border-0 text-end">
					<button type="reset" class="btn btn-link btn-sm me-2 text-decoration-none">
						Cancel
					</button>
					<button type="submit" id="submit" class="btn btn-primary btn-sm">
						Submit
					</button>
				</footer>
			</div>
		<?php

			// echo 'JKEI COMMENT : ' . $rc->fields[1] . '<hr><br /><br />';
			// echo 'SUPPLIER COMMENT : <br />';
			// echo '<textarea id="txtcom" name="txtcom" rows="5" cols="80">' . $rc->fields[0] . '</textarea>';
			// echo '<input type="hidden" id="hcom" name="hcom" value="suppcom">';
			// echo '<input type="hidden" id="hsupp" name="hsupp" value="' . $rs->fields[4] . '">';
			// echo '<input type="hidden" id="hblnthn" name="hblnthn" value="' . $rs->fields[3] . '">';
		} else {
			if (isset($rc->fields[0])) {
		?>
			<article class="card bg-light">
				<header class="card-header border-0 bg-transparent d-flex align-items-center">
					<div>
						<img src="../assets_v2/img/person.png" class="rounded-circle me-2" width="50px" /><a class="fw-semibold text-decoration-none">Supplier</a>
						<span class="ms-3 small text-muted">comment</span>
					</div>
					<div class="dropdown ms-auto">
						<button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="bi bi-three-dots-vertical"></i>
						</button>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="#">Report</a></li>
						</ul>
					</div>
				</header>
				<div class="card-body py-2 px-3">
					<?= $rc->fields[0] ?>
				</div>
				<footer class="card-footer bg-white border-0 py-1 px-3">
				</footer>
			</article>
			<?php
			}
			if (isset($rc->fields[1])) {
			?>
				<article class="card bg-light">
					<header class="card-header border-0 bg-transparent d-flex align-items-center">
						<div>
							<img src="../assets_v2/img/person.png" class="rounded-circle me-2" width="50px" /><a class="fw-semibold text-decoration-none">JKEI</a>
							<span class="ms-3 small text-muted">comment</span>
						</div>
						<div class="dropdown ms-auto">
							<button class="btn btn-link text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="bi bi-three-dots-vertical"></i>
							</button>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="#">Report</a></li>
							</ul>
						</div>
					</header>
					<div class="card-body py-2 px-3">
						<?= $rc->fields[1] ?>
					</div>
					<footer class="card-footer bg-white border-0 py-1 px-3">
					</footer>
				</article>
			<?php
			}
			?>
			<div class="card bg-light">
				<header class="card-header border-0 bg-transparent">
					<img src="../assets_v2/img/person.png" class="rounded-circle me-2" width="50px" /><a class="fw-semibold text-decoration-none">JKEI</a>
					<span class="ms-3 small text-muted">comment</span>
				</header>
				<div class="card-body py-1">
					<form>
						<div>
							<label for="exampleFormControlTextarea1" class="visually-hidden">
								Comment</label>
							<textarea class="form-control form-control-sm border border-2 rounded-1" id="txtcom" name="txtcom" style="height: 50px" placeholder="Add a comment..." minlength="3" maxlength="255" required></textarea>
							<input type="hidden" id="hcom" name="hcom" value="jeincom">
							<input type="hidden" id="hsupp" name="hsupp" value="<?= $rs->fields[4] ?>">
							<input type="hidden" id="hblnthn" name="hblnthn" value="<?= $rs->fields[3] ?>">
						</div>
					</form>
				</div>
				<footer class="card-footer bg-transparent border-0 text-end">
					<button type="reset" class="btn btn-link btn-sm me-2 text-decoration-none">
						Cancel
					</button>
					<button type="submit" id="submit" class="btn btn-primary btn-sm">
						Submit
					</button>
				</footer>
			</div>
	

	<!-- echo 'SUPPLIER COMMENT : ' . $rc->fields[0] . ' -->
	<!-- <hr><br /><br />';
			echo 'JKEI COMMENT : <br />';
			echo '<textarea id="txtcom" name="txtcom" rows="5" cols="80">' . $rc->fields[1] . '</textarea>';
			echo '<input type="hidden" id="hcom" name="hcom" value="jeincom">';
			echo '<input type="hidden" id="hsupp" name="hsupp" value="' . $rs->fields[4] . '">';
			echo '<input type="hidden" id="hblnthn" name="hblnthn" value="' . $rs->fields[3] . '">'; -->
<?php
		}
		// echo '<br /><button type="submit" id="submit">Update Comment</button>';
		echo '</form>';
		// echo '<br />&nbsp;&nbsp;&nbsp;';
		echo '<a target="_blank" class="btn btn-info text-center mb-2"  href="jsoadl.php?sid=' . $supp . '&tglid=' . $tgl .
			'">DOWNLOAD DATA TO CSV FORMAT</a>';
?>
<div class="mt-2">
	<table id="tblsum" class="table table-responsive table-bordered table-striped font-monospace">
		<thead class="table-primary">
			<th>LAST PAYMENT</th>
			<th>PURCHASE</th>
			<th>ROG-C</th>
			<th>NET PURCHASE</th>
			<th>VAT</th>
			<th>DN CN (PUR)</th>
			<th>PAYMENT</th>
			<th>THIS BALANCE</th>
		</thead>
		<tbody>
			<?php
			while (!$rs->EOF) {
				echo '<tr>';
				echo '<td align="right">' . $rs->fields[16] . '</td>';
				echo '<td align="right">' . $rs->fields[17] . '</td>';
				echo '<td align="right">' . $rs->fields[18] . '</td>';
				echo '<td align="right">' . $rs->fields[19] . '</td>';
				echo '<td align="right">' . $rs->fields[20] . '</td>';
				echo '<td align="right">' . $rs->fields[21] . '</td>';
				echo '<td align="right">' . $rs->fields[22] . '</td>';
				echo '<td align="right">' . $rs->fields[23] . '</td>';
				echo '</tr>';
				$rs->MoveNext();
			}
			?>
		</tbody>
	</table>
</div>
<div class="mt-2">
	<table id="tbldtl" class="table table-responsive table-bordered table-striped font-monospace">
		<thead class="table-primary">
			<th>NO</th>
			<th>DATE</th>
			<th>PO NUMBER<br>SO NUMBER</th>
			<th>SQ</th>
			<th>INVOICE NUMBER<br>ROG SLIP NO.</th>
			<th>PARTS NUMBER</th>
			<th>DESCRIPTION</th>
			<th>QTY</th>
			<th>UNIT PRICE</th>
			<th>AMOUNT</th>
			<th>OUR DN CN</th>
		</thead>
		<tbody>
			<?php
			$nomor = 0;

			if ($tahunsoa < 2020) {
				$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
	  invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,vat,
	  salesvat,payment,balance from " .  $tablesoa . " where (hd = 'D') and (suppcode = '" . $suppid . "') 
	  and (transdate = '" . $tgl . "') order by INVOICE, OK");
			} else {
				$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
		invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,vat,
		salesvat,payment,balance from SOA where (hd = 'D') and (suppcode = '" . $suppid . "') 
		and (transdate = '" . $tgl . "') order by INVOICE, OK");
			}

			while (!$rs->EOF) {
				$nomor++;
				echo '<tr>';
				echo '<td align="right">' . $nomor . '</td>';
				echo '<td >' . $rs->fields[6] . '</td>';
				echo '<td>' . $rs->fields[7] . '</td>';
				echo '<td>' . $rs->fields[8] . '</td>';
				echo '<td>' . $rs->fields[9] . '</td>';
				echo '<td><pre>' . trim($rs->fields[10]) . '</pre></td>';
				echo '<td>' . $rs->fields[11] . '</td>';
				echo '<td align="right">' . $rs->fields[12] . '</td>';
				echo '<td align="right">' . $rs->fields[13] . '</td>';
				echo '<td align="right">' . $rs->fields[14] . '</td>';
				echo '<td align="right">' . $rs->fields[15] . '</td>';
				echo '</tr>';
				$rs->MoveNext();
			}
			?>
		</tbody>
	</table>
</div>
<?php
$rs->Close();
$db->Close();
?>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		alert('test');
		$("#submit").click(function(e) {
			e.preventDefault();

			var komentar = $("#txtcom").val();
			var yangkomen = $("#hcom").val();
			alert(komentar + yangkomen);
		})

	})
</script>

</html>