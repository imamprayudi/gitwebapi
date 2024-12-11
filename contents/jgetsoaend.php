<!DOCTYPE HTML>
<html>

<head>
	<title>SOAEND</title>
	<style type="text/css">
		@import "../assets/css/jquery.datepick.css";
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
	$tablesoa = 'soaend' . $tahunsoa;

	if ($tahunsoa < 2020) {
		$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
  invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,
  vat,salesvat,payment,this,col027,col028,video,term15,term30,term45,term60,
  term75,term90,termtotal from " . $tablesoa . " where (hd = 'H') and (suppcode = '" . $suppid . "') 
  and (transdate = '" . $tgl . "')");
	} else {
		$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
    invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,
    vat,salesvat,payment,this,col027,col028,video,term15,term30,term45,term60,
    term75,term90,termtotal from soaend where (hd = 'H') and (suppcode = '" . $suppid . "') 
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
	$rc = $db->Execute("select suppcom,jeincom from soacomend where blnthn = '" . $rs->fields[3] . "' and
    suppcode = '" . $rs->fields[4] . "'");
	$supp = intval($suppid) * 14102703;
	?>

	<form class="mt-4" id="frmcom" action="jsoacomend.php" method="post">
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
			<!-- 			
			JEIN COMMENT : ' . $rc->fields[1] . '
			<hr><br /><br />
			SUPPLIER COMMENT : <br />
			<textarea id="txtcom" name="txtcom" rows="5" cols="80">' . $rc->fields[0] . '</textarea>
			<input type="hidden" id="hcom" name="hcom" value="suppcom">
			<input type="hidden" id="hsupp" name="hsupp" value="' . $rs->fields[4] . '">
			<input type="hidden" id="hblnthn" name="hblnthn" value="' . $rs->fields[3] . '"> -->
			<?php
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

			<!-- SUPPLIER COMMENT : ' . $rc->fields[0] . '
			<hr><br /><br />
			JEIN COMMENT : <br />
			<textarea id="txtcom" name="txtcom" rows="5" cols="80">' . $rc->fields[1] . '</textarea>
			<input type="hidden" id="hcom" name="hcom" value="jeincom">
			<input type="hidden" id="hsupp" name="hsupp" value="' . $rs->fields[4] . '">
			<input type="hidden" id="hblnthn" name="hblnthn" value="' . $rs->fields[3] . '"> -->
		<?php
		}
		?>
		<!-- <br /><button type="submit" id="submit">Update Comment</button> -->
	</form>

	<a target="_blank" class="btn btn-info text-center mb-2" href="jsoadl.php?sid=' . $supp . '&tglid=' . $tgl .
	'">DOWNLOAD DATA TO CSV FORMAT</a>
	<div class="mt-2">
		<table id="tblsum" class="table table-responsive table-bordered table-striped font-monospace">
			<thead class="table-primary">
				<th>LAST PAYMENT</th>
				<th>PURCHASE</th>
				<th>OUR DN CN</th>
				<th>NET PURCHASE</th>
				<th>VAT</th>
				<th>DN CN (PUR)</th>
				<th>PAYMENT</th>
				<th>THIS BALANCE</th>
			</thead>
			<tbody class="text-nowrap">
				<?php
				while (!$rs->EOF) {
				?>

					<tr>
						<td align="right"><?= number_format($rs->fields[16], 2, '.', '') ?></td> <!--lastpay-->
						<td align="right"><?= number_format($rs->fields[17], 2, '.', '') ?></td><!--purchase-->
						<td align="right"><?= number_format($rs->fields[18], 2, '.', '') ?></td><!--dncn-->
						<td align="right"><?= number_format($rs->fields[19], 2, '.', '') ?></td><!--netpur-->
						<td align="right"><?= number_format($rs->fields[20], 2, '.', '') ?></td><!--vat-->
						<td align="right"><?= number_format($rs->fields[21], 2, '.', '') ?></td><!--dncnpur-->
						<td align="right"><?= number_format($rs->fields[22], 2, '.', '') ?></td><!--payment-->
						<td align="right"><?= number_format($rs->fields[23], 2, '.', '') ?></td><!--balance-->
					</tr>
			</tbody>
		</table>
	</div>
	<br>Payment Term<br>
	<div class="mt-2">
		<table id="tblpay" class="table table-responsive table-bordered table-striped font-monospace">
			<thead class="table-primary">
				<th>15 Days</th>
				<th>30 Days</th>
				<th>45 Days</th>
				<th>60 Days</th>
				<th>75 Days</th>
				<th>90 Days</th>
				<th>TOTAL</th>
			</thead>
			<tbody class="text-nowrap">
				<td align="right"><?= number_format($rs->fields[27], 2, '.', '') ?></td> <!-- days15 -->
				<td align="right"><?= number_format($rs->fields[28], 2, '.', '') ?></td> <!-- days30 -->
				<td align="right"><?= number_format($rs->fields[29], 2, '.', '') ?></td> <!-- days45 -->
				<td align="right"><?= number_format($rs->fields[30], 2, '.', '') ?></td> <!-- days60 -->
				<td align="right"><?= number_format($rs->fields[31], 2, '.', '') ?></td> <!-- days75 -->
				<td align="right"><?= number_format($rs->fields[32], 2, '.', '') ?></td> <!-- days90 -->
				<td align="right"><?= number_format($rs->fields[33], 2, '.', '') ?></td> <!-- daystotal -->
			<?php
					$rs->MoveNext();
				}
			?>
			</tbody>
		</table>
	</div>

	<!-- /*
	$supp = $suppid * 14102703 ;
	<a target="_blank" href="jsoaenddl.php?sid=' . $supp . '&tglid=' . $tgl . '">DOWNLOAD DATA TO CSV FORMAT</a>
	<br />*/ -->
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
			<tbody class="text-nowrap">
				<?php
				$nomor = 0;

				if ($tahunsoa < 2020) {
					$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
	  invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,
	  vat,salesvat,payment,this,col027,col028,video,term15,term30,term45,term60,
	  term75,term90,termtotal from " . $tablesoa . " where (hd = 'D') and (suppcode = '" . $suppid . "') 
	  and (transdate = '" . $tgl . "') order by INVOICE, OK");
				} else {
					$rs = $db->Execute("select transdate,hd,tm,blnthn,suppcode,ok,tgl,po,posq,
	  invoice,partno,partname,qty,price,amount,dncnd,lastpay,purchase,dncns,netpur,
	  vat,salesvat,payment,this,col027,col028,video,term15,term30,term45,term60,
	  term75,term90,termtotal from soaend where (hd = 'D') and (suppcode = '" . $suppid . "') 
	  and (transdate = '" . $tgl . "') order by INVOICE, OK");
				}
				while (!$rs->EOF) {
					$nomor++;
				?>
					<tr>
						<td align="right"><?= $nomor ?></td>
						<td><?= substr($rs->fields[6], 0, 10) ?></td> <!-- tgl -->
						<td><?= $rs->fields[7] ?></td>
						<td><?= $rs->fields[8] ?></td>
						<td><?= $rs->fields[9] ?></td>
						<td>
							<pre><?= trim($rs->fields[10]) ?></pre>
						</td>
						<td><?= $rs->fields[11] ?></td>
						<td align="right"><?= $rs->fields[12] ?></td>
						<td align="right"><?= number_format($rs->fields[13], 4, '.', '') ?></td> <!-- price -->
						<td align="right"><?= number_format($rs->fields[14], 2, '.', '') ?></td> <!-- amount -->
						<td align="right"><?= number_format($rs->fields[15], 2, '.', '') ?></td> <!-- ourdncn -->
					</tr>
				<?php
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