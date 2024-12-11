<html>
<head>
<title>BARCODE PRINT</title>
</head><body bgcolor="#ffffff">
<a href="../rcvweb">Kembali ke menu utama</a>
<br><br>
<table border="0" width="800">
	<tr>
		<td width="250"> <img height="50px" src="logo/logo_jvc2.png" /> </td>
		<td valign="top"> <font size="5">PT. JVC ELECTRONICS INDONESIA</font> <br> ***** BARCODE - PRINT ***** </td>
	</tr>
</table>
<br><br>
<?php
if(isset($_GET['partno']))

  {

    $lokasi = $_GET['lokasi'];
    $partno = $_GET['partno'];
    $pjgpartno = strlen($partno);
	
	switch ($pjgpartno)
	{  
	  case 1:
	  $partno .= '              ';
	  break;
	  case 2:
	  $partno .= '             ';
	  break;
	  case 3:
	  $partno .= '            ';
	  break;
	  case 4:
	  $partno .= '           ';
	  break;
	  case 5:
	  $partno .= '          ';
	  break;
	  case 6:
	  $partno .= '         ';
	  break;
	  case 7:
	  $partno .= '        ';
	  break;
	  case 8:
	  $partno .= '       ';
	  break;
	  case 9:
	  $partno .= '      ';
	  break;
	  case 10:
	  $partno .= '     ';
	  break;
	  case 11:
	  $partno .= '    ';
	  break;
	  case 12:
	  $partno .= '   ';
	  break;
	  case 13:
	  $partno .= '  ';
	  break;
	  case 14:
	  $partno .= ' ';
	  break;
	  default:
	  // no action
	}
	
    $po     = $_GET['po'];
    if($po == '')
	{  
	  $po = '       '; 
	}
	
    $suppname 	= $_GET['suppname'];
    $pack  		= $_GET['pack'];
    $qtystd 	= $_GET['qtystd'];
    $qtybal 	= $_GET['qtybal'];
	$vsupp 		= $_GET['supp'];

    
    $barcode 	= $partno . ' ' . $po . ' ' . $pack;

    // Including all required classes
    require('class/BCGFont.php');
    require('class/BCGColor.php');
    require('class/BCGDrawing.php'); 

    // Including the barcode technology
    include('class/BCGcode128.barcode.php'); 

    // Loading Font
    $font = new BCGFont('./class/font/Arial.ttf', 18);    
    
    echo '<table border="0" cellpadding="5">';

    // barcode -->
    for ($y=1;$y<=$qtystd;$y++)
    {
		$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($y) . '.jpg';

		// The arguments are R, G, B for color.
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255); 

		$code = new BCGcode128();
		$code->setScale(2); // Resolution
		$code->setThickness(30); // Thickness
		$code->setForegroundColor($color_black); // Color of bars
		$code->setBackgroundColor($color_white); // Color of spaces
		$code->setFont($font); // Font (or 0)
		$code->parse($barcode); // Text

		/* Here is the list of the arguments
		1 - Filename (empty : display on screen)
		2 - Background color */
		$drawing = new BCGDrawing('', $color_white);
		$drawing->setBarcode($code);
		$drawing->setFilename('image/'.$namafile);
		$drawing->draw();
		// Header that says it is an image (remove it if you save the barcode to a file)
		//header('Content-Type: image/png');

		// Draw (or save) the image into PNG format.
		$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
		
		echo '<tr>';
			echo '<td align="left" width="250">'.$suppname.'</td>';
			echo '<td align="right">'.$lokasi.'</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td align="center" colspan="2">';
				echo '<img width="400" title="barcode" src="image/' . $namafile . '" alt="gambar barcode" />';
			echo '</td>';
		echo '</tr>';

	}

        // make balance barcode
	if($qtybal > 0)
    {
		$extfile = $qtystd + 1;

		$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
		$barcode = $partno . ' ' . $po . ' ' . $qtybal;


		// The arguments are R, G, B for color.
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255); 

		$code = new BCGcode128();
		$code->setScale(2); // Resolution
		$code->setThickness(30); // Thickness
		$code->setForegroundColor($color_black); // Color of bars
		$code->setBackgroundColor($color_white); // Color of spaces
		$code->setFont($font); // Font (or 0)
		$code->parse($barcode); // Text

		/* Here is the list of the arguments
		1 - Filename (empty : display on screen)
		2 - Background color */
		$drawing = new BCGDrawing('', $color_white);
		$drawing->setBarcode($code);
		$drawing->setFilename('image/'.$namafile);
		$drawing->draw();
		// Header that says it is an image (remove it if you save the barcode to a file)
		//header('Content-Type: image/png');

		// Draw (or save) the image into PNG format.
		$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
		
		echo '<tr>';
			echo '<td align="left" width="250">'.$suppname.'</td>';
			echo '<td align="right">'.$lokasi.'</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td align="center" colspan="2">';
				echo '<img width="400"  title="barcode" src="image/' . $namafile . '" alt="gambar barcode" />';
			echo '</td>';
		echo '</tr>';
	}



  } // end of if (isset = get
?>



	  
</table>

</body></html>

