<?php
/*
	****	modify by Mohamad Yunus
	****	on 25 Jan 2017
	****	revise: single QR Code
	*/

session_start();
$session_userid = $_SESSION['usr'];
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title> JKEI - PRINT LABEL BARCODE VIEW </title>
		<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
        <script src="../assets/js/jquery.js"></script>
		<link rel="shortcut icon" href= "assets/gambar/receiving.ico"/>
		<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	</head>
	
	<body>

<div id="kepala">
<?php
//	include("jmenudicss.php");
echo '<div id="section">';
echo '<br />';
echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">';
echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA ';
echo '<br />';
echo 'PRINT LABEL BARCODE VIEW';
echo '<br /><br />';
echo '</div>';
echo '<div id="section">';
include('con_svrdbn.php');
include('con_qrinvoice.php');

$partno 	= trim($_REQUEST['part']);
$suppname 	= trim($_REQUEST['suppname']);
$vsupp    	= $_REQUEST['suppcode'];
$po     	= $_REQUEST['po'];
$qty    	= $_REQUEST['qty'];
$deldate    = $_REQUEST['deldate'];
$proddate   = $_REQUEST['proddate'];
		
$rs2 = $db->Execute("select partname from stdpack where partnumber= '". $partno ."'");
$partnm = $rs2->fields[0];
$rs2->Close();
		
$rs3 = $db->Execute("select kategori from supplier where suppcode= '". $vsupp ."'");
$kategori = $rs3->fields[0];
$rs3->Close();
		
$rs4 = $db_qrinvoice->Execute("select case imincl when '1' then 'Direct' else 'Inspection' 
  end as sts_insp from sa96t where iprod = '". $partno ."'");
$sts_inspection = $rs4->fields[0];
$rs4->Close();
				
echo '<table border=0 cellpadding=0 cellspacing=0>';
echo '<tr valign="top">';
echo '<td width=450>';
echo '<table border=0 cellpadding=4 cellspacing=4>';
echo '<tr>';
echo '<td width=150 valign=top>Supplier Name</td>';
echo '<td><b> ' . $suppname . ' </b></td>';
echo '</tr>';
echo '<tr>';	
echo '<td width=150 valign=top>Part Number</td>';
echo '<td><input type="text" name="partnumber" id="partnumber" value="'. $partno .'" readonly=""></td>';
echo '</tr>';
if($kategori == 2){
  $ulcode    	= $_REQUEST['ulcode'];
  echo '<tr>';
	echo '<td width=150 valign=top>UL Code</td>';
	echo '<td><input type="text" name="ulcode" id="ulcode" value="'. $ulcode .'" readonly=""></td>';
	echo '</tr>';
}

if($kategori == 4){
	$invno    	= $_REQUEST['invno'];
	echo '<tr>';
	echo '<td width=150 valign=top>Invoice No</td>';
	echo '<td><input type="text" name="invno" id="invno" value="'. $invno .'" readonly=""></td>';
	echo '</tr>';
}
else{
	$mtrl     	= $_REQUEST['mtrl'];
	echo '<tr>';
	echo '<td width=150 valign=top>Material</td>';
	echo '<td><input type="text" name="mtrl" id="mtrl" value="'. $mtrl .'" readonly=""></td>';
	echo '</tr>';
}

echo '<tr>';
echo '<td width=150 valign=top>PO No.</td>';
echo '<td><input type="text" name="po" id="po" value="'. $po .'" readonly=""></td>';
echo '</tr>';
echo '<tr>';
echo '<td width=150 valign=top>QTY</td>';
echo '<td><input type="text" name="qty" id="qty" value="'. $qty .'" readonly=""></td>';
echo '</tr>';
//Query	
$rs = $db->Execute("select stdpack_supp, lokasi from stdpack where partnumber= '". $partno ."' 
  and suppcode= '". $vsupp ."'");
$pack 	= $rs->fields[0];
$lokasi = trim($rs->fields[1]);
$rs->Close();
echo '<tr>';
echo '<td width=150 valign=top>Standard Pack</td>';
echo '<td><input type="text" value="'. $pack .'" readonly=""></td>';
echo '</tr>';
echo '<tr>';
echo '<td width=150 valign=top>Lokasi</td>';
echo '<td><input type="text" value="'. $lokasi .'" readonly=""></td>';
echo '</tr>';
echo '<tr>';
echo '<td width=150 valign=top>Delivery Date</td>';
echo '<td><input type="text" name="deldate" id="deldate" value="'. $deldate .'" readonly=""></td>';
echo '</tr>';
echo '<tr>';
echo '<td width=150 valign=top>Prod. Date</td>';
echo '<td><input type="text" name="proddate" id="proddate" value="'. $proddate .'" readonly=""></td>';
echo '</tr>';
						
if($kategori == 4){
	$et    		= $_REQUEST['et'];
	echo '<tr>';
	echo '<td width=150 valign=top>Elec Test</td>';
	echo '<td><input type="text" name="et" id="et" value="'. $et .'" readonly=""></td>';
	echo '</tr>';
}
else{
	$shift    	= $_REQUEST['shift'];
	echo '<tr>';
	echo '<td width=150 valign=top>Shift</td>';
	echo '<td><input type="text" name="shift" id="shift" value="'. $shift .'" readonly=""></td>';
	echo '</tr>';
}
						
if($kategori == 4){
	echo '<tr>';
	echo '<td colspan=2></td>';
	echo '</tr>';
}
else{
	$qcc    	= $_REQUEST['qcc'];
	echo '<tr>';
	echo '<td width=150 valign=top>QC Check</td>';
	echo '<td><input type="text" name="qcc" id="qcc" value="'. $qcc .'" readonly=""></td>';
	echo '</tr>';
}

echo '</table>';
echo '</td>';
$label = 0;
$label = intval($qty / $pack);
$sisa  = $qty % $pack;
$qtystd = $label;
$qtybal = $sisa;
						
if($sisa > 0){
	$label++;
}

$suppname = str_replace("&","and",$suppname);
$sql2 		= "select left('$suppname', 7)";
$nt2 		= $db->Execute($sql2);
$suppname2 	= $nt2->fields[0];
$nt2->Close();
				
if($kategori == 2){
	echo '<td align="center" width=250><b>Format Print QRcode Inner Box</b> <br><br>
				<a target="_blank" href="barcodeqr/barcode_view_lama.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&mtrl=' . $mtrl . '&deldate=' . $deldate . '&proddate=' . $proddate . '&shift=' . $shift . '&qcc=' . $qcc . '&kategori=' . $kategori . '&ulcode=' . $ulcode . '&stsinsp=' . $sts_inspection . '">
				<img src="img/innerboxqr.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
	echo '<td align="center" width=250><b>Format Print Barcode Outter Box</b> <br><br>
				<a target="_blank" href="barcode128/barcode_view_baru.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&mtrl=' . $mtrl . '&deldate=' . $deldate . '&proddate=' . $proddate . '&shift=' . $shift . '&qcc=' . $qcc . '&kategori=' . $kategori . '&ulcode=' . $ulcode . '&stsinsp=' . $sts_inspection . '">
				<img height="250px" src="img/outterbox.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
	echo '<td align="center" width=250><b>Format Print QRcode Outter Box</b> <br><br>
				<a target="_blank" href="barcodeqr/barcode_view_baru.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&mtrl=' . $mtrl . '&deldate=' . $deldate . '&proddate=' . $proddate . '&shift=' . $shift . '&qcc=' . $qcc . '&kategori=' . $kategori . '&ulcode=' . $ulcode . '&stsinsp=' . $sts_inspection . '">
				<img height="220px" src="img/outterboxqr.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
}
elseif($kategori != 4){
	echo '<td align="center" width=250><b>Format Print QRcode Inner Box</b> <br><br>
				<a target="_blank" href="barcodeqr/barcode_view_lama.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&mtrl=' . $mtrl . '&deldate=' . $deldate . '&proddate=' . $proddate . '&shift=' . $shift . '&qcc=' . $qcc . '&kategori=' . $kategori . '&stsinsp=' . $sts_inspection . '">
				<img src="img/innerboxqr.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
	echo '<td align="center" width=250><b>Format Print Barcode Outter Box</b> <br><br>
				<a target="_blank" href="barcode128/barcode_view_baru.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&mtrl=' . $mtrl . '&deldate=' . $deldate . '&proddate=' . $proddate . '&shift=' . $shift . '&qcc=' . $qcc . '&kategori=' . $kategori . '&stsinsp=' . $sts_inspection . '">
				<img height="250px" src="img/outterbox.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
	echo '<td align="center" width=250><b>Format Print QRcode Outter Box</b> <br><br>
				<a target="_blank" href="barcodeqr/barcode_view_baru.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&mtrl=' . $mtrl . '&deldate=' . $deldate . '&proddate=' . $proddate . '&shift=' . $shift . '&qcc=' . $qcc . '&kategori=' . $kategori . '&stsinsp=' . $sts_inspection . '">
				<img height="220px" src="img/outterboxqr.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
}
else{
	$mtrl = "";
	$shift = "";
	$qcc = "";
	$bn = "";
	echo '<td align="center" width=250><b>Format Print QRcode Inner Box</b> <br><br> 
				<a target="_blank" href="barcodeqr/barcode_view_lama.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&deldate=' . $deldate . '&proddate=' . $proddate . '&et=' . $et . '&kategori=' . $kategori . '&bn=' . $bn . '&invno=' . $invno . '&stsinsp=' . $sts_inspection . '">
				<img src="img/innerboxqr.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
	echo '<td align="center" width=250><b>Format Print Barcode Outter Box</b> <br><br>
				<a target="_blank" href="barcode128/barcode_view_baru.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&invno=' . $invno . '&deldate=' . $deldate . '&proddate=' . $proddate . '&et=' . $et . '&kategori=' . $kategori . '&bn=' . $bn . '&stsinsp=' . $sts_inspection . '">
				<img height="250px" src="img/outterbox.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
	echo '<td align="center" width=250><b>Format Print QRcode Outter Box</b> <br><br>
				<a target="_blank" href="barcodeqr/barcode_view_baru.php?lokasi='.$lokasi.'&partno=' . $partno . '&po=' . $po . '&pack=' . $pack . '&qtystd=' . $qtystd . '&qtybal=' . $qtybal . '&suppname=' . $suppname2 . '&supp=' . $vsupp . '&qty=' . $qty . '&partnm=' . $partnm . '&invno=' . $invno . '&deldate=' . $deldate . '&proddate=' . $proddate . '&et=' . $et . '&kategori=' . $kategori . '&bn=' . $bn . '&stsinsp=' . $sts_inspection . '">
				<img height="220px" src="img/outterboxqr.png" />
				</a>
				<br>
				<font style="font-size:8pt;"> click image to print barcode</font>
				</td>';
}
			
echo '</tr>';
echo '</table>';
	
$db->Close();
?>
			</div>
		</div>		
	</body>
</html>