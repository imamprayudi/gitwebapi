
<?php
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
$tgl  = $_GET['tglid'];
include('koneksi.php');
$tahunsoa = substr($tgl,0,4);
$tablesoa = 'soa' . $tahunsoa;
if ($tahunsoa < 2020){
  $sql = "select convert(varchar(10),tgl,23),po,posq,invoice,partno,
    partname,qty,price,amount,dncnd from " . $tablesoa . " where (suppcode = '" . $suppcode . "') 
    and (transdate = '" . $tgl . "') and (OK = 'D')";
}
else{
  $sql = "select convert(varchar(10),tgl,23),po,posq,invoice,partno,
    partname,qty,price,amount,dncnd from soa where (suppcode = '" . $suppcode . "') 
    and (transdate = '" . $tgl . "') and (OK = 'D')";
}

$rs 		= $db->Execute($sql);
$fname = "soa" . $suppcode . "-" . $tgl . ".csv";
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
$fp = fopen("php://output", "w");
$headers = 'TGL,PO,SQ,INVOICE,PARTNO,PARTNAME,QTY,PRICE,AMOUNT,DNCND' . "\n";
fwrite($fp,$headers);
while(!$rs->EOF)
{
  fputcsv($fp, array(	$rs->fields['0'], $rs->fields['1'], $rs->fields['2'], 
                      $rs->fields['3'], $rs->fields['4'], $rs->fields['5'], 
                      $rs->fields['6'], $rs->fields['7'], $rs->fields['8'], 
                      $rs->fields['9']));
  $rs->MoveNext();
}

fclose($fp);
$rs->Close();
$db->Close();
?>