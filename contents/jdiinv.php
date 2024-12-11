
<?php
include 'koneksi.php';
?>

<html> 
<head>
<title>Delivery Edit</title>
<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
            <script src="../assets/js/jquery.js"></script>
</head>
<body>
  
<script type="text/javascript">
checked=false;
function checkedall (frmdiinv)
{
  var aa= document.getElementById('frmdiinv');
  if (checked == false)
  {
    checked = true
  }
  else
  {
    checked = false
  }
  for (var i =0; i < aa.elements.length;i++)
  {
    aa.elements[i].checked = checked;
  }
}
</script>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (isset($_POST['subinv']))
  {
    $btnsub = "invoice";
  }
  if (isset($_POST['subqty']))
  {
    $btnsub = "qty";
  }
  if (isset($_POST['upload']))
  {
    $btnsub = "upload";
  }
  if (isset($_POST['subedit']))
  {
    $btnsub = "edit";
  }
  if (isset($_POST['nama']))
  {
    $uinv = $_POST['nama'];
  }
  else
  {
	  $uinv = ""  ;
  }	  
  if (isset($_POST['qty']))
  {
    $uqty = $_POST['qty'];
  }
  else
  {
	  $uqty = "";  
  }
  if (isset($_POST['chkRow']))
  {
    $ceknilai = $_POST['chkRow'];
  }
  else
  {
	  $ceknilai = "";  
  }

  if ($ceknilai == "")
  {
    if (isset($_POST['supptgl']))
	  {
	    $supptgl = $_POST['supptgl'];
	  }
  }

  if ($ceknilai != "")
  {    
    foreach ($_POST['chkRow'] as $rowId)
    {
      $supptgl = substr($rowId,0,11) . '%';
      if( ($uinv != "") && ($btnsub == "invoice"))
      {
        $sqlupinv = "update di set invoice = '{$uinv}' where supptglpo = '{$rowId}'";
        $rsupdate = $db->Execute($sqlupinv);
      }
  
      if( ($uqty != "") && ($btnsub == "qty"))
      { 
	      $sqlupinv = "update di set qty = '{$uqty}' where supptglpo = '{$rowId}'";
        $rsupdate = $db->Execute($sqlupinv); 
      }
  
      if($btnsub == "upload")
      {
        $sqlupinv = "update di set status = '1' where (supptglpo = '{$rowId}') and (invoice <> '')";
        $rsupdate = $db->Execute($sqlupinv);
      }

    } 
    $rsupdate->Close();
  } 

  if($btnsub == "edit")
  {
    $vsupp = substr($_POST['supp'],0,5);
    $vthn = substr($_POST['diyear'],2,2);
    $vbln = $_POST['dimonth'];
    $vtgl = $_POST['didate']; 
    $supptgl = $vsupp . $vthn . $vbln . $vtgl .  "%";
  }
 
}
else
{
  $vsupp = ($_GET['s'] - 712) / 1997;
  $vtgl  = $_GET['t'];
  $vthn = substr($vtgl,6,2);
  $vbln = substr($vtgl,3,2);
  $vtgl = substr($vtgl,0,2);
  $supptgl = $vsupp . $vthn . $vbln . $vtgl . "%";
} 
 // include("jmenucss.php");
  include('../contents_v2/layouts/header.php');

  ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Forecast</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Forecast</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">
          
        
        <?php

        echo '<br />';
echo "<table border=1>";
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Supplier Code</th>';
echo '<th>PO req.date</th>';
echo '<th>PO</th>';
echo '<th>PART NUMBER</th>';
echo '<th>QTY</th>';
echo '<th>Delivery Date</th>';
echo '<th>Time</th>';
echo '<th>INVOICE</th>';
echo '<th>Status</th>';
echo '<th>SQ</th>';
echo "<th><input type='checkbox' name='checkall' onclick='checkedall(frmdiinv);'></th>";
echo '</tr>';
$sqldiv = "select supptglpo,supp,convert(varchar,tgli,1),po,partno,qty,convert(varchar,tgld,1),invoice,status,ditime,disq from di where status = '0' and supptglpo like  '{$supptgl}' order by invoice,partno,po";
$recdiv = $db->execute($sqldiv);
echo '<form action="jdiinv.php" method="post" id=frmdiinv name=frmdiinv>';
while (!$recdiv->EOF)
{
  echo "<tr>";
  echo  "<td>" . $recdiv->fields[0] . "</td><td>" . $recdiv->fields[1] . "</td><td>" . $recdiv->fields[2] . "</td>" ;
  echo  "<td>" . $recdiv->fields[3] . "</td><td>" . $recdiv->fields[4] . '</td><td align="right">' . $recdiv->fields[5] . "</td>";
  echo  "<td>" . $recdiv->fields[6] . "</td><td>" . $recdiv->fields[9] . ":00</td><td>" . $recdiv->fields[7] . "</td><td>" . $recdiv->fields[8] . "</td><td>" . $recdiv->fields[10] . "</td>" ;
  $yd = 'yudi'; 
  echo '<td><input type="checkbox" value=' . $recdiv->fields[0] . ' name="chkRow[]"></td>';
  echo "<td>";
  echo "</td>";
  echo "</tr>";
  $recdiv->MoveNext();
}  
$recdiv->Close();
echo '<br>';
echo '<input type="hidden" name="supptgl" value=' . $supptgl . '>'; 
echo 'ketik nomor invoice ( MAX 15 digit ) : ';
echo '<input type="text" name="nama" value="" size="20" maxlength="15">';
echo '<input type="submit" value="update invoice" id=submit1 name=subinv>';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo 'ketik qty untuk revisi    : ';
echo '<input type="text" name="qty" value="" size="20" maxlength="10">';
echo '<input type="submit" value="update qty" id="submit2" name="subqty">';
echo '<br><br>';
echo 'Klik upload untuk kirim data ke JEIN : ';
echo '<input type="submit" value="upload" id="submit3" name="upload">';
echo '</form>';
echo "</table>";

$db->Close();
?>
        </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

    <?php include('../contents_v2/layouts/footer.php'); ?>
</body></html>
?>