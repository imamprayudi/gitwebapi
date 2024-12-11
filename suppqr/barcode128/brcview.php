<html>
<head>
	<title>Preview Barcode</title>
</head>
<body bgcolor="#ffffff">
	<p>
		<h3><IMG src="logo.png" align="left" width="157" height="37"></h3>
			PT. JVC ELECTRONICS INDONESIA ***** BARCODE - PRINT ***** 
		<a href="../brcsupp.php">kembali</a>
	</p>
	<br>
	<br>
<?php
if(isset($_GET['partno']))
{
    $partno = $_GET['partno'];    $pjgpartno = strlen($partno);
	
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
	
    $po     = $_GET['po'];    //$pjgpo  = strlen($po);
    if($po == '')
	{  
	  $po = '       '; 
	}
	
    $suppname 	= $_GET['suppname'];
    $pack   	= $_GET['pack'];
    $qtystd 	= $_GET['qtystd'];
    $qtybal 	= $_GET['qtybal'];
    $tgl    	= $_GET['tgl'];
    $lokasi    	= $_GET['lokasi'];
    $supp    	= $_GET['supp'];
    $invno   	= $_GET['invno'];
    
    $barcode = $partno . ' ' . $po . ' ' . $pack;

    // Including all required classes
    require('class/BCGFont.php');
    require('class/BCGColor.php');
    require('class/BCGDrawing.php'); 

    // Including the barcode technology
    include('class/BCGcode128.barcode.php'); 

    // Loading Font


    $font = new BCGFont('./class/font/Arial.ttf', 18);    
    
    echo '<table border="0" cellpadding="5">';
		//   $pb = 0;
		// barcode -->
		for ($y=1;$y<=$qtystd;$y++)
		{
			echo '<tr>';
			echo '<td>';
				echo '<font size=3pt align="left"><b>' . $invno . '</b></font>&nbsp;&nbsp;&nbsp;&nbsp;'.
				'<font size=2pt align="center">' . $supp . '</font>&nbsp;&nbsp;&nbsp;&nbsp;'.
				'<font size=3pt><b>' . $lokasi . '</b></font><br />';
				
				$namafile = $partno . $y . '.jpg';



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
				$drawing->setFilename('img_barcode/'.$namafile);
				$drawing->draw();
				// Header that says it is an image (remove it if you save the barcode to a file)
				//header('Content-Type: image/png');

				// Draw (or save) the image into PNG format.
				$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

				echo '<img width="290 height="100" ';
				echo 'title="barcode" src="img_barcode/' . $namafile . '" alt="gambar barcode" /><br />';
			echo '</td>';
			echo '</tr>';
		}  // end for $y

		// make balance barcode
		if($qtybal > 0)
		{
			echo '<tr>';
			echo '<td>';
				echo '<font size=3pt align="left"><b>' . $invno . '</b></font>&nbsp;&nbsp;&nbsp;&nbsp;'.
				'<font size=2pt align="center">' . $supp . '</font>&nbsp;&nbsp;&nbsp;&nbsp;'.
				'<font size=3pt><b>' . $lokasi . '</b></font><br />';

				$extfile = $qtystd + 1;

				$namafile = $partno . $extfile . '.jpg';
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
				$drawing->setFilename('img_barcode/'.$namafile);
				$drawing->draw();
				// Header that says it is an image (remove it if you save the barcode to a file)
				//header('Content-Type: image/png');

				// Draw (or save) the image into PNG format.
				$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

				echo '<img width="290 height="100" ';
				echo 'title="barcode" src="img_barcode/' . $namafile . '" alt="gambar barcode" /><br />';
			echo '</td>';
			echo '</tr>';
		}  // end of if qtybal > 0
	echo '</table>';
} // end of if (isset = get=
?>
	</body>
</html>
