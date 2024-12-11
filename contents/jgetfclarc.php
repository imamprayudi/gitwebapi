<!DOCTYPE HTML>
<html>
<head>
<title>Forecast</title>
<style>
table th, td
{
  font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
  border:1px solid grey;
  font-size:12px;
  border-collapse: collapse;
}
td
{
  padding:5px;
  border-collapse: collapse;
}
th
{
  background-color:navy;
  color:white;
  border-collapse: collapse;
}
</style>
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

include("koneksi.php");

if ($_POST)
{
  $supp = $_POST['suppid'];
  $tgl  = $_POST['tanggal'];
  $tglyy = substr($tgl,0,4);
  $tglmm = substr($tgl,5,2);
  $tgldd = substr($tgl,8,2);
  $tg = $tglmm . '/' . $tgldd . '/' . $tglyy;
  $tipe = $_POST['tipe'];

  if ($tipe == 1)
  {
    $tipetext = 'WEEKLY';
	  $r1 = 8;
	  $r2 = 35;
  }
  if ($tipe == 2)
  {
    $tipetext = 'MONTHLY';
	  $r1 = 36;
	  $r2 = 41;
  }
}

$rs = $db->Execute("select transdate, rt, suppcode, subsuppcode, subsuppname, partno, partname, leadtime, 
  dtqty1, dtqty2, dtqty3, dtqty4, dtqty5, dtqty6, dtqty7, dtqty8, dtqty9, dtqty10, dtqty11, dtqty12,
  dtqty13, dtqty14, dtqty15, dtqty16, dtqty17, dtqty18, dtqty19, dtqty20, dtqty21, dtqty22, dtqty23, 
  dtqty24, dtqty25, dtqty26, dtqty27, dtqty28, dtqty29, dtqty30, dtqty31, dtqty32, dtqty33, dtqty34, 
  dt2qt1, dt2qt2, dt2qt3, dt2qt4, dt2qt5, dt2qt6, dt2qt7, dt2qt8, dt2qt9, dt2qt10, dt2qt11, dt2qt12, 
  dt2qt13, dt2qt14, dt2qt15, dt2qt16, dt2qt17, dt2qt18, dt2qt19, dt2qt20, dt2qt21, dt2qt22, dt2qt23, 
  dt2qt24, dt2qt25, dt2qt26, dt2qt27, dt2qt28, dt2qt29, dt2qt30, dt2qt31, dt2qt32, dt2qt33, dt2qt34, 
  dt3qt1, dt3qt2, dt3qt3, dt3qt4, dt3qt5, dt3qt6, dt3qt7, dt3qt8, dt3qt9, dt3qt10, dt3qt11, dt3qt12, 
  dt3qt13, dt3qt14, dt3qt15, dt3qt16, dt3qt17, dt3qt18, dt3qt19, dt3qt20, dt3qt21, dt3qt22, dt3qt23, 
  dt3qt24, dt3qt25, dt3qt26, dt3qt27, dt3qt28, dt3qt29, dt3qt30, dt3qt31, dt3qt32, dt3qt33, dt3qt34,
  dt4qt1, dt4qt2, dt4qt3, dt4qt4, dt4qt5, dt4qt6, dt4qt7, dt4qt8, dt4qt9, dt4qt10, dt4qt11, dt4qt12, 
  dt4qt13, dt4qt14, dt4qt15, dt4qt16, dt4qt17, dt4qt18, dt4qt19, dt4qt20, dt4qt21, dt4qt22, dt4qt23, 
  dt4qt24, dt4qt25, dt4qt26, dt4qt27, dt4qt28, dt4qt29, dt4qt30, dt4qt31, dt4qt32, dt4qt33, dt4qt34, 
  scold, scnew from forecastn where rt = 'H' and suppcode = '" . $supp . "' and transdate = '" . $tg . "'");
$ada = $rs->RecordCount();

if ($ada == 0)
{
  echo 'Data Nothing ....';
}
else
{
  echo '<table id="tblfcl">';
  while (!$rs->EOF)
  {
    echo '<br />';
    echo '<caption>FORECAST FOR ' . $rs->fields[4] . 
      ' (' . $rs->fields[2] . ')' . ' - ' . $rs->fields[0] . ' - ' .$tipetext . '</caption>';
    echo '<tr>';
    echo '<th>NO</th>';
    echo '<th>Part Number</th>';
    echo '<th>DD/MM</th>'; 
    for ($i = $r1; $i <= $r2; $i++)
    {
      echo '<th>' . $rs->fields[$i] . '</th>';
    }
      echo '</tr>';
      $rs->MoveNext();
  }
  $nomor = 0;
  $rs = $db->Execute("select transdate, rt, suppcode, subsuppcode, subsuppname, partno, partname, leadtime, 
    dtqty1, dtqty2, dtqty3, dtqty4, dtqty5, dtqty6, dtqty7, dtqty8, dtqty9, dtqty10, dtqty11, dtqty12,
    dtqty13, dtqty14, dtqty15, dtqty16, dtqty17, dtqty18, dtqty19, dtqty20, dtqty21, dtqty22, dtqty23, 
    dtqty24, dtqty25, dtqty26, dtqty27, dtqty28, dtqty29, dtqty30, dtqty31, dtqty32, dtqty33, dtqty34, 
    dt2qt1, dt2qt2, dt2qt3, dt2qt4, dt2qt5, dt2qt6, dt2qt7, dt2qt8, dt2qt9, dt2qt10, dt2qt11, dt2qt12, 
    dt2qt13, dt2qt14, dt2qt15, dt2qt16, dt2qt17, dt2qt18, dt2qt19, dt2qt20, dt2qt21, dt2qt22, dt2qt23, 
    dt2qt24, dt2qt25, dt2qt26, dt2qt27, dt2qt28, dt2qt29, dt2qt30, dt2qt31, dt2qt32, dt2qt33, dt2qt34, 
    dt3qt1, dt3qt2, dt3qt3, dt3qt4, dt3qt5, dt3qt6, dt3qt7, dt3qt8, dt3qt9, dt3qt10, dt3qt11, dt3qt12, 
    dt3qt13, dt3qt14, dt3qt15, dt3qt16, dt3qt17, dt3qt18, dt3qt19, dt3qt20, dt3qt21, dt3qt22, dt3qt23, 
    dt3qt24, dt3qt25, dt3qt26, dt3qt27, dt3qt28, dt3qt29, dt3qt30, dt3qt31, dt3qt32, dt3qt33, dt3qt34,
    dt4qt1, dt4qt2, dt4qt3, dt4qt4, dt4qt5, dt4qt6, dt4qt7, dt4qt8, dt4qt9, dt4qt10, dt4qt11, dt4qt12, 
    dt4qt13, dt4qt14, dt4qt15, dt4qt16, dt4qt17, dt4qt18, dt4qt19, dt4qt20, dt4qt21, dt4qt22, dt4qt23, 
    dt4qt24, dt4qt25, dt4qt26, dt4qt27, dt4qt28, dt4qt29, dt4qt30, dt4qt31, dt4qt32, dt4qt33, dt4qt34, 
    scold, scnew from forecastn where rt = 'D' and transdate = '" . $tg . "' and 
    suppcode = '" . $supp . "' order by partno");
  while (!$rs->EOF)
  {
    $nomor++;
    echo '<tr>';
    echo '<td>' . $nomor . '</td><td>';
    echo $rs->fields[5] . '<br />';
    echo $rs->fields[6] . '<br />';
    echo $rs->fields[7] . '<br />';
    echo '<td>FIRM<br />FOREC<br />PLAN<br />TOTAL<br /></td>';
    for ($y = $r1; $y <= $r2; $y++)
    {
      echo '<td align="right">' . $rs->fields[$y] . '<br />';
      echo $rs->fields[$y+34] . '<br />';
      echo $rs->fields[$y+34+34] . '<br />';
      echo $rs->fields[$y+34+34+34] . '</td>';
    }
      echo '</tr>';
      $rs->MoveNext();
  }
  echo '</table>';
}
$rs->Close();
$db->Close();
?>
</body>
</html>