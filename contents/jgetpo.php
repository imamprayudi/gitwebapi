<!DOCTYPE HTML>
<html>
<head>
<script language=javascript>
function loadwindow(url)
{
  window.open (url,"login","toolbar=1,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=970,height=625,left=0,top=0");
}
</script>
<title>Purchase Order</title>
<link href="../assets/css/jein.css" rel="stylesheet" type="text/css">
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
    window.location.href = '../index.php';
  </script>
  <?php  
}
  ?>

<?php
include("koneksi.php");
if ($_POST)
{
  $supp = $_POST['suppid'];
  $tgl1  = $_POST['tgl1id'];
  $tgl2  = $_POST['tgl2id'];
  $tgl1 =  date('Y-m-d' , strtotime($tgl1));
  $tgl2 = date('Y-m-d' , strtotime($tgl2));
}

$rs = $db->Execute("select transdate,supplier,status,confirmation,confirmdate,rejectreason 
  from mailpost where ( supplier = '" . $supp . "') and 
  ( transdate between '" . $tgl1 ."' and '" . $tgl2 . "') order by transdate");
$ada = $rs->RecordCount();
if ($ada == 0)
{
  echo '<br />Data Nothing ....';
}
else
{
  echo '<table class="datagrid" id="tblfcl">';
  echo '<tr>';
  echo '<th>NO</th>';
  echo '<th>Transmission Date</th>';
  echo '<th>Status</th>';
  echo '<th>Confirmation Status</th>';
  echo '<th>Confirmation Date</th>';
  echo '<th>Reject Reason</th>';
	echo '<th>***</th>';
	echo '<th>***</th>';
  echo '</tr>';
  $nomor = 0;
  while (!$rs->EOF)
  {
    $nomor++; 
	  echo '<tr>';
		echo '<td>' . $nomor . '</td>'; 
		$vdate = substr($rs->fields[0],0,10);
    echo '<td>' . $vdate . '</td>';
		echo '<td>' . $rs->fields[2] . '</td>';
		echo '<td>' . $rs->fields[3] . '</td>';
		$vconfirm = substr($rs->fields[4],0,16);
    echo '<td align="center">' . $vconfirm . '</td>';
    $reason = $rs->fields[5];
    echo '<td align="center">' . $reason . '</td>';
		$suppcode = $rs->fields[1] * 14102703 ;
    echo '<td><font size="1" face="verdana"><a target="_blank" href="jgetpodtl.php?sid=';
    echo $suppcode;
    echo '&tglid=';
    echo $vdate;
    echo '&sts=';
    echo $rs->fields[2];
    echo '&conf=';
    echo $rs->fields[3];
    echo '&confdate=';
    echo $vconfirm;
    echo '"</a>View Detail</td>';
    echo '<td><font size="1" face="verdana"><a target="_blank" href="jpodl.php?sid=' . $suppcode . '&tglid=' . $vdate . '"</a>Download</td>';
	  $rs->MoveNext();
  }
  echo '</table>';
}
$rs->Close();
$db->Close();
?>
</body>
</html>
