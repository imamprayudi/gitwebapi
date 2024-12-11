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

include('koneksi.php');
$supp = $_GET['suppid'];
$suppcode = intval($supp) / 14102703 ;
$tgl  = $_GET['tgl'];
$sqlh = "select top 1 transdate,hd,tm,suppcode,partno,partname,balqty,
  qty1,qty2,qty3,qty4,qty5,qty6,qty7,qty8,qty9,qty10,qty11,qty12,qty13,qty14,qty15,
  qty16,qty17,qty18,qty19,qty20,qty21,qty22,qty23,qty24,
  qty25,qty26,qty27,qty28,qty29,qty30,qty31 from bps where ( hd = 'H' ) and 
  (suppcode = '" . $suppcode . "') and (transdate = '" . $tgl . "')";
$rsh 		= $db->Execute($sqlh);

while (!$rsh->EOF)
{ 
  $headers = 'PARTNO, PARTNAME, ' . $rsh->fields[6] . ',' . $rsh->fields[7] . ',' . $rsh->fields[8] . ',' . $rsh->fields[9];
  $headers = $headers . ',' . $rsh->fields[10] . ',' . $rsh->fields[11] . ',' . $rsh->fields[12] . ',' . $rsh->fields[13] . ',' . $rsh->fields[14];
  $headers = $headers . ',' . $rsh->fields[15] . ',' . $rsh->fields[16] . ',' . $rsh->fields[17] . ',' . $rsh->fields[18] . ',' . $rsh->fields[19];
  $headers = $headers . ',' . $rsh->fields[20] . ',' . $rsh->fields[21] . ',' . $rsh->fields[22] . ',' . $rsh->fields[23] . ',' . $rsh->fields[24];
  $headers = $headers . ',' . $rsh->fields[25] . ',' . $rsh->fields[26] . ',' ; 
  $headers = $headers . "\n";
  $rsh->MoveNext();
}

$sqld = "select transdate,hd,tm,suppcode,partno,partname,balqty,
  qty1,qty2,qty3,qty4,qty5,qty6,qty7,qty8,qty9,qty10,qty11,qty12,qty13,qty14,qty15,
  qty16,qty17,qty18,qty19,qty20,qty21,qty22,qty23,qty24,
  qty25,qty26,qty27,qty28,qty29,qty30,qty31 from bps where ( hd = 'd' ) and 
  (suppcode = '" . $suppcode . "') and (transdate = '" . $tgl . "') order by partno";
$rsd  = $db->Execute($sqld);
$fname = "bps" . $suppcode . ".csv";
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
$fp = fopen("php://output", "w");
fwrite($fp,$headers);

while(!$rsd->EOF)
{  
  fputcsv($fp, array(	$rsd->fields['4'], $rsd->fields['5'], $rsd->fields['6'], $rsd->fields['7'], $rsd->fields['8'],  
                      $rsd->fields['9'], $rsd->fields['10'], $rsd->fields['11'], $rsd->fields['12'], $rsd->fields['13'],  
                      $rsd->fields['14'], $rsd->fields['15'], $rsd->fields['16'], $rsd->fields['17'], $rsd->fields['18'],
                      $rsd->fields['19'], $rsd->fields['20'], $rsd->fields['21'], $rsd->fields['22'], $rsd->fields['23'],
                      $rsd->fields['24'], $rsd->fields['25'], 
                      $rsd->fields['26']));
  $rsd->MoveNext();
}

fclose($fp);
$rsh->Close();
$rsd->Close();
$db->Close();
?>