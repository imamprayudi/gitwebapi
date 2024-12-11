<?php

/*
  Forecast Download
  Maret 2020
  Imam Prayudi
*/


session_start();
if(isset($_SESSION['usr']))
{

}  
else
{
  echo "session time out";
}

$supp = $_GET['sid'];
$suppcode = intval($supp) / 14102703 ;

include('koneksi.php');

$sqlh = "select dtqty1,dtqty2,dtqty3,dtqty4,dtqty5,dtqty6,dtqty7,dtqty8,dtqty9,dtqty10,
dtqty11,dtqty12,dtqty13,dtqty14,dtqty15,dtqty16,dtqty17,dtqty18,dtqty19,dtqty20,dtqty21,dtqty22,
dtqty23,dtqty24,dtqty25,dtqty26,dtqty27,dtqty28 
from fcl where (suppcode = '" . $suppcode . "') and rt = 'H'"; 
$rsh    = $db->Execute($sqlh);
$fname = "fcl" . $suppcode . ".csv";
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
$fp = fopen("php://output", "w");
$headers = 'PARTNO,PARTNAME,LT,DD/MM,' . $rsh->fields['0'] . ',' . $rsh->fields['1'] . ',' .
$rsh->fields['2'] . ',' . $rsh->fields['3'] . ',' . $rsh->fields['4'] . ',' . $rsh->fields['5'] . ',' .
$rsh->fields['6'] . ',' . $rsh->fields['7'] . ',' . $rsh->fields['8'] . ',' . $rsh->fields['9'] . ',' .
$rsh->fields['10'] . ',' . $rsh->fields['11'] . ',' . $rsh->fields['12'] . ',' . $rsh->fields['13'] . ',' .
$rsh->fields['14'] . ',' . $rsh->fields['15'] . ',' .  $rsh->fields['16'] . ',' . $rsh->fields['17'] . ',' .
$rsh->fields['18'] . ',' . $rsh->fields['19'] . ','  . $rsh->fields['20'] . ',' . $rsh->fields['21'] . ',' .
$rsh->fields['22'] . ',' . $rsh->fields['23'] . ',' . $rsh->fields['24'] . ',' . $rsh->fields['25'] . ',' .
$rsh->fields['26'] . ',' . $rsh->fields['27'] . "\n";
           
$sql = "select partno,partname,leadtime,dtqty1,dtqty2,dtqty3,dtqty4,dtqty5,dtqty6,dtqty7,
dtqty8,dtqty9,dtqty10,dtqty11,dtqty12,dtqty13,dtqty14,dtqty15,dtqty16,dtqty17,dtqty18,
dtqty19,dtqty20,dtqty21,dtqty22,dtqty23,dtqty24,dtqty25,dtqty26,dtqty27,dtqty28,
dt2qt1,dt2qt2,dt2qt3,dt2qt4,dt2qt5,dt2qt6,dt2qt7,dt2qt8,dt2qt9,dt2qt10,dt2qt11,dt2qt12,
dt2qt13,dt2qt14,dt2qt15,dt2qt16,dt2qt17,dt2qt18,dt2qt19,dt2qt20,dt2qt21,dt2qt22,dt2qt23,
dt2qt24,dt2qt25,dt2qt26,dt2qt27,dt2qt28,
dt3qt1,dt3qt2,dt3qt3,dt3qt4,dt3qt5,dt3qt6,dt3qt7,dt3qt8,dt3qt9,dt3qt10,dt3qt11,dt3qt12,
dt3qt13,dt3qt14,dt3qt15,dt3qt16,dt3qt17,dt3qt18,dt3qt19,dt3qt20,dt3qt21,dt3qt22,dt3qt23,
dt3qt24,dt3qt25,dt3qt26,dt3qt27,dt3qt28,
dt4qt1,dt4qt2,dt4qt3,dt4qt4,dt4qt5,dt4qt6,dt4qt7,dt4qt8,dt4qt9,dt4qt10,dt4qt11,dt4qt12,
dt4qt13,dt4qt14,dt4qt15,dt4qt16,dt4qt17,dt4qt18,dt4qt19,dt4qt20,dt4qt21,dt4qt22,dt4qt23,
dt4qt24,dt4qt25,dt4qt26,dt4qt27,dt4qt28
from fcl where (suppcode = '" . $suppcode . "') and (rt = 'D') order by partno";
$rs 		= $db->Execute($sql);
fwrite($fp,$headers);

while(!$rs->EOF)
{
  fputcsv($fp, array(	$rs->fields['0'], $rs->fields['1'], $rs->fields['2'], 
  'FIRM',$rs->fields['3'], $rs->fields['4'],$rs->fields['5'],$rs->fields['6'],$rs->fields['7'],
  $rs->fields['8'],$rs->fields['9'],$rs->fields['10'],$rs->fields['11'],$rs->fields['12'],
  $rs->fields['13'],$rs->fields['14'],$rs->fields['15'],$rs->fields['16'],$rs->fields['17'],
  $rs->fields['18'],$rs->fields['19'],$rs->fields['20'],$rs->fields['21'],$rs->fields['22'],
  $rs->fields['23'],$rs->fields['24'],$rs->fields['25'],$rs->fields['26'],$rs->fields['27'],
  $rs->fields['28'],$rs->fields['29'],$rs->fields['30']));
  
  fputcsv($fp, array(	$rs->fields['0'], $rs->fields['1'], $rs->fields['2'], 
  'FOREC',$rs->fields['31'], $rs->fields['32'],$rs->fields['33'],$rs->fields['34'],$rs->fields['35'],
  $rs->fields['36'],$rs->fields['37'],$rs->fields['38'],$rs->fields['39'],$rs->fields['40'],
  $rs->fields['41'],$rs->fields['42'],$rs->fields['43'],$rs->fields['44'],$rs->fields['45'],
  $rs->fields['46'],$rs->fields['47'],$rs->fields['48'],$rs->fields['49'],$rs->fields['50'],
  $rs->fields['51'],$rs->fields['52'],$rs->fields['53'],$rs->fields['54'],$rs->fields['55'],
  $rs->fields['56'],$rs->fields['57'],$rs->fields['58']));
                      
  fputcsv($fp, array(	$rs->fields['0'], $rs->fields['1'], $rs->fields['2'], 
  'PLAN',$rs->fields['59'], $rs->fields['60'],$rs->fields['61'],$rs->fields['62'],$rs->fields['63'],
  $rs->fields['64'],$rs->fields['65'],$rs->fields['66'],$rs->fields['67'],$rs->fields['68'],
  $rs->fields['69'],$rs->fields['70'],$rs->fields['71'],$rs->fields['72'],$rs->fields['73'],
  $rs->fields['74'],$rs->fields['75'],$rs->fields['76'],$rs->fields['77'],$rs->fields['78'],
  $rs->fields['79'],$rs->fields['80'],$rs->fields['81'],$rs->fields['82'],$rs->fields['83'],
  $rs->fields['84'],$rs->fields['85'],$rs->fields['86']));

  fputcsv($fp, array(	$rs->fields['0'], $rs->fields['1'], $rs->fields['2'], 
  'TOTAL',$rs->fields['87'], $rs->fields['88'],$rs->fields['89'],$rs->fields['90'],$rs->fields['91'],
  $rs->fields['92'],$rs->fields['93'],$rs->fields['94'],$rs->fields['95'],$rs->fields['96'],
  $rs->fields['97'],$rs->fields['98'],$rs->fields['99'],$rs->fields['100'],$rs->fields['101'],
  $rs->fields['102'],$rs->fields['103'],$rs->fields['104'],$rs->fields['105'],$rs->fields['106'],
  $rs->fields['107'],$rs->fields['108'],$rs->fields['109'],$rs->fields['110'],$rs->fields['111'],
  $rs->fields['112'],$rs->fields['113'],$rs->fields['114']));

  $rs->MoveNext();
}

fclose($fp);
$rsh->Close();
$rs->Close();
$db->Close();
?>