
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
include('koneksi.php');
$sql = "select partnumber,partname,orderqty,convert(varchar(10), reqdate, 23),
  ponumber,posq,orderbalance,supprest,model,convert(varchar(10), issuedate, 120),
  potype from ordbal where (suppcode = '" . $suppcode . "')";
$rs 		= $db->Execute($sql);
$fname = "ordbal" . $suppcode . ".csv";
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$fname");
header("Pragma: no-cache");
header("Expires: 0");
$fp = fopen("php://output", "w");
$headers = 'PARTNO, PARTNAME,QTY, REQUIRED, PO, SQ, BALANCE, SUPPREST, MODEL, ISSUE,TYPE' . "\n";
fwrite($fp,$headers);

while(!$rs->EOF)
{
  
    fputcsv($fp, array(	$rs->fields['0'], $rs->fields['1'], $rs->fields['2'], 
                        $rs->fields['3'], $rs->fields['4'], $rs->fields['5'], 
                        $rs->fields['6'], $rs->fields['7'], $rs->fields['8'], 
                        $rs->fields['9'], $rs->fields['10']));
    $rs->MoveNext();
}

fclose($fp);
$rs->Close();
$db->Close();
?>