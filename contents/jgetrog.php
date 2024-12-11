<!DOCTYPE HTML>
<html>
<head>
<title>Return of Goods</title>
</head>
<body>

<?php
session_start();
if(isset($_SESSION['usr']))
{

}  
else
{
  echo "session time out";
  ?> 
  <script> 
    window.location.href = 'index.php';
  </script>
  <?php  
}

include("koneksi.php");
if ($_POST)
{
  $supp = $_POST['suppid'];
  $tgl1  = $_POST['tgl1id'];
  $tgl2  = $_POST['tgl2id'];
}
 
$rs = $db->Execute("select tgl,partno,partname,pono,qty,amount,ngcode,ngdesc
  from rog where ( suppcode = '" . $supp . "') and 
  ( tgl between '" . $tgl1 ."' and '" . $tgl2 . "') order by tgl,partno");
$ada = $rs->RecordCount();
if ($ada == 0)
{
  echo '<br />Data Nothing ....';
}
else
{
  echo '<table id="tblfcl" border="1">';
  echo '<tr>';
  echo '<th>NO</th>';
  echo '<th>Date</th>';
  echo '<th>Part Number</th>';
  echo '<th>Part Name</th>';
  echo '<th>PO Number</th>';
  echo '<th>QTY</th>';
  echo '<th>Amount</th>';
  echo '<th>NG Code</th>';
  echo '<th>NG Desc</th>';
	echo '</tr>';
  $nomor = 0;
  while (!$rs->EOF)
  {
    $nomor++; 
	  echo '<tr>';
		echo '<td>' . $nomor . '</td>'; 
		$vdate = substr($rs->fields[0],0,10);
    echo '<td>' . $vdate . '</td>';
		echo '<td>' . $rs->fields[1] . '</td>';
        echo '<td>' . $rs->fields[2] . '</td>';
        echo '<td>' . $rs->fields[3] . '</td>';
		$vqty = number_format($rs->fields[4]);
        echo '<td align="right">' . $vqty . '</td>';
        $vamt = number_format($rs->fields[5]);
        echo '<td align="right">' . $vamt . '</td>';
		echo '<td align="center">' . $rs->fields[6] . '</td>';
        echo '<td>' . $rs->fields[7] . '</td>';
	  $rs->MoveNext();
  }
	echo '</table>';
}  
?>
</body>
</html>