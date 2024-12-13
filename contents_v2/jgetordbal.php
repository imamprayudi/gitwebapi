<!DOCTYPE HTML>
<html>

<head>
  <title>Purchase Order Detail</title>
</head>

<body>

  <?php
  include('layouts/header.php');
  ?>
<?php  

// include("koneksi.php");

if ($_POST)
{
  // $supp = $_POST['suppid'];
  // $urutan  = $_POST['urutanid'];
  // if ($urutan == 1)
  // {
  //   $orderby = 'partnumber';
  // }
  // if ($urutan == 2)
  // {
  //   $orderby = 'reqdate';
  // }
	// if ($urutan == 3)
  // {
  //   $orderby = 'ponumber';
  // }
	// if ($urutan == 4)
  // {
  //   $orderby = 'model';
  // }
	// if ($urutan == 5)
  // {
  //   $orderby = 'issuedate';
  // }
	
}
 
// $rs = $db->Execute("select transdate,suppcode,partnumber,partname,orderqty,reqdate,ponumber,
//   posq,orderbalance,supprest,model,issuedate,potype,statuspart,remark,statusread 
//   from ordbal where suppcode = '" . $supp . "' order by " . $orderby);
// $ada = $rs->RecordCount();
// if ($ada == 0) {
//   // echo 'Data Nothing ....';
  ?>
    <!-- <div class="mt-4 container col-12 text-center text-danger">
      <h2>Data Nothing ....</h2>
    </div> -->
  <?php
  // die();
// }
  // $supp = intval($supp) * 14102703 ;
  // echo '&nbsp;&nbsp;&nbsp;';
  echo '<div class="mt-2">';
  // echo '<a target="_blank" class="btn btn-info text-center mb-2" href="jordbaldl.php?sid=' . $supp . '">DOWNLOAD DATA TO CSV FORMAT</a>';

  echo '<table id="tblfcl" class="table table-responsive table-bordered table-striped  font-monospace">';
  // echo '<tr>';
  echo "<thead class='table-primary'>";
  echo '<th>NO</th>';
  echo '<th>PART NUMBER</th>';
  echo '<th>PART NAME</th>';
  echo '<th>ORDER <br />QTY</th>';
  echo '<th>REQUIRED <br />DATE</th>';
  echo '<th>PO <br />NUMBER</th>';
  echo '<th>SQ</th>';
  echo '<th>ORDER <br />BALANCE</th>';
  echo '<th>SUPP <br />REST</th>';
  echo '<th>MODEL</th>';
  echo '<th>ISSUE <br />DATE</th>';
  echo '<th>PO <br />TYPE</th>';
	// echo '</tr>';
	echo '</thead>';
  $nomor = 0;
  echo "<tbody>";
  // while (!$rs->EOF)
  // {
  //   $nomor++; 
	//   echo '<tr>';
	// 	echo '<td>' . $nomor . '</td>'; 
  //   echo '<td>' . $rs->fields[2] . '</td>';
	// 	echo '<td>' . $rs->fields[3] . '</td>';
	// 	echo '<td align="right">' . $rs->fields[4] . '</td>';
	// 	$rdate = substr($rs->fields[5],0,10);
	// 	echo '<td>' . $rdate . '</td>';
	// 	echo '<td>' . $rs->fields[6] . '</td>';
	// 	echo '<td>' . $rs->fields[7] . '</td>';
	// 	echo '<td align="right">' . $rs->fields[8] . '</td>';
	// 	echo '<td align="right">' . $rs->fields[9] . '</td>';
	// 	echo '<td>' . $rs->fields[10] . '</td>';
	// 	$idate = substr($rs->fields[11],0,10);
	// 	echo '<td>' . $idate . '</td>';
	// 	echo '<td>&nbsp;' . $rs->fields[12] . '&nbsp;</td>';
	// 	echo '</tr>';
	//   $rs->MoveNext();
  // }
  echo "</tbody>";
  echo '</table>';

?>
</div>
<?php include('layouts/footer.php'); ?>
  <script src="../dist/jordbal.bundle.js"></script>
</body>
</html>