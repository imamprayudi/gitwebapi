<html>
<head>
<title>BARCODE PRINT</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#ffffff">
<?php
if(isset($_GET['partno']))
{

    $partno 	= $_GET['partno'];
    $pjgpartno 	= strlen($partno);
	
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
	
	$lokasi 	= $_GET['lokasi'];
    $suppname 	= $_GET['suppname'];
    $pack   	= $_GET['pack'];
    $qtystd 	= $_GET['qtystd'];
    $qtybal 	= $_GET['qtybal'];
	$vsupp 		= $_GET['supp'];
		
	$partnm 	= $_GET['partnm'];
	$qty 		= $_GET['qty'];
	$deldate 	= $_GET['deldate'];
	$proddate 		= $_GET['proddate'];
	$kategori   = $_GET['kategori'];
	
	$stsinsp3 	= isset($_GET['stsinsp']) ? $_GET['stsinsp'] : '';
	$stsinsp2	= strtoupper($stsinsp3);
	//$stsinsp2	= 'DIRECT';
	//$stsinsp2	= 'INSPECTION';
	$stsinsp	= substr($stsinsp2,0,1);
	
    $barcode = $partno . ' ' . $po . ' ' . $pack;

    // Including all required classes
    require('class/BCGFont.php');
    require('class/BCGColor.php');
    require('class/BCGDrawing.php'); 

    // Including the barcode technology
    include('class/BCGcode128.barcode.php'); 

    // Loading Font
    $font = new BCGFont('./class/font/Arial.ttf', 12);    
    
	
	//  Preview Format Barcode berdasarkan Kategori Supplier
	switch ($kategori)
	{
		case '1':  // Format barcode kategori  --- >>>  Stamping Metal Part
			$mtrl 		= $_GET['mtrl'];
			$shift 		= $_GET['shift'];
			$qcc 		= $_GET['qcc'];
				
			$stdpack 	= $pack; // standard packing tiap palet
			$totalqty 	= $qty; // total production quantity
			$sisa 		= $totalqty % $stdpack; // sisa hasil bagi
			$jml 		=ceil($totalqty / $stdpack); //hasil bagi dibulatkan ke atas
			$kurang 	= 1;
			//$jml =floor($totalqty / $stdpack); //hasil bagi dibulatkan ke bawah
			//echo $jml ." dan " .$sisa;

			echo '<table border=0 cellspacing=0 width=650>';
				if ($jml==1){
					if ($stdpack == $totalqty){
						//echo("<tr><td>". $totalqty ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($jml) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/stmp128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/stmp128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
					else{
						//echo("<tr><td>". $sisa ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$qtybal.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								//echo $suppname . '<br />';
								$extfile = $jml + 1;

								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode = $partno . ' ' . $po . ' ' . $qtybal;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/stmp128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/stmp128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
				} // end if ($jml==1)
				if ($jml==2){
					//echo("<tr><td>". $stdpack ."</td>");
					echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $stdpack;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/stmp128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/stmp128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
					echo '</td>';
					if ($sisa!=0){
						//echo("<td>". $sisa ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$sisa.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$extfile 	= $sisa;

								$namafile	= trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/stmp128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/stmp128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} // end if ($sisa!=0)
					else{  
						//echo("<td>". $stdpack ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/stmp128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/stmp128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} //end  else
				} // end if ($jml==2)

				if($jml>2){
					for ($i=1;$i<=$jml;$i++){
						$kurang = $i * $stdpack;
						if($i % 2!=0){
							if (($totalqty - $kurang)>$sisa){
								//echo("<tr><td>". $stdpack ."</td>");
								if(($i+1) % 6==0){
									echo '<tr style="page-break-after: always;"><td>';
								}elseif($i % 3==0)	{
									echo '<tr><td height=400>';
								}else{
									echo '<tr><td>';
								}
								echo '<table border=1 cellspacing=0 width=300>';
									echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
									echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
									echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
									echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
									echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
									echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
								echo '</table>';
								echo '<table border=0 cellspacing=0 width=300>';
									echo '<tr><td align=center valign=top>';
										$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
										
										// The arguments are R, G, B for color.
										$color_black = new BCGColor(0, 0, 0);
										$color_white = new BCGColor(255, 255, 255); 

										$code = new BCGcode128();
										$code->setScale(1); // Resolution
										$code->setThickness(35); // Thickness
										$code->setForegroundColor($color_black); // Color of bars
										$code->setBackgroundColor($color_white); // Color of spaces
										$code->setFont($font); // Font (or 0)
										$code->parse($barcode); // Text
										
										/* Here is the list of the arguments
										1 - Filename (empty : display on screen)
										2 - Background color */
										$drawing = new BCGDrawing('', $color_white);
										$drawing->setBarcode($code);
										$drawing->setFilename('../../printqr/stmp128/'.$a);
										$drawing->draw();
										
										// Draw (or save) the image into PNG format.
										$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

										echo '<img width="300 height=120" ';
										echo 'title="barcode" src="../../printqr/stmp128/' . $a . '" alt="gambar barcode" /><br />';
									echo '</td></tr>';
								echo '</table>';
								echo '</td>';
							} // end if (($totalqty - $kurang)>$sisa)
							else{
								if($sisa==0){
									//echo("<tr><td>". $stdpack ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=400>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
										echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
										echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
										echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
										echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text
											
											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/stmp128/'.$a);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/stmp128/' . $a . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}else{
									//echo("<tr><td>". $sisa ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=400>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
										echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
										echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
										echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$sisa.' PCS</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
										echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$extfile 	= $sisa;
											
											$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';											
											$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text

											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/stmp128/'.$namafile);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/stmp128/' . $namafile . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}
							} //end else
						} // end if($i % 2!=0)
						if ($i % 2==0){
							echo '<td align=right >';
							echo '<table border=1 cellspacing=0 width=300>';
								echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
								echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
								echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
								echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
								echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td>  </tr>';
								echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
							echo '</table>';
							echo '<table border=0 cellspacing=0 width=300>';
								echo '<tr><td align=center valign=top>';
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/stmp128/' . $a . '" alt="gambar barcode" /><br />';
								echo '</td></tr>';
							echo '</table>';
							echo '</td></tr>';
						} // if ($i % 2==0)
					} // end for ($i=1;$i<=$jml;$i++)
				} // end if($jml>2)
			echo '</table>';
		break;
		// End Format barcode kategori  --- >>>  Stamping Metal Part
		
		case '2':  // Format barcode kategori  --- >>>  Injection Part
			$mtrl 		= $_GET['mtrl'];
			$shift 		= $_GET['shift'];
			$qcc 		= $_GET['qcc'];
			$ulcode   	= $_GET['ulcode'];

			$stdpack 	= $pack; // standard packing tiap palet
			$totalqty 	= $qty; // total production quantity
			$sisa 		= $totalqty % $stdpack; // sisa hasil bagi
			$jml 		=ceil($totalqty / $stdpack); //hasil bagi dibulatkan ke atas
			$kurang 	= 1;
			//$jml =floor($totalqty / $stdpack); //hasil bagi dibulatkan ke bawah
			//echo $jml ." dan " .$sisa;

			echo '<table border=0 cellspacing=0 width=650>';
				if ($jml==1){
					if ($stdpack == $totalqty){
						//echo("<tr><td>". $totalqty ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$stdpack.' PCS</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($jml) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/injc128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/injc128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
					else{
						//echo("<tr><td>". $sisa ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$qtybal.' PCS</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								//echo $suppname . '<br />';
								$extfile = $jml + 1;

								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode = $partno . ' ' . $po . ' ' . $qtybal;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/injc128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/injc128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
				} // end if ($jml==1)
				if ($jml==2){
					//echo("<tr><td>". $stdpack ."</td>");
					echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$stdpack.' PCS</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $stdpack;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/injc128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/injc128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
					echo '</td>';
					if ($sisa!=0){
						//echo("<td>". $sisa ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$sisa.' PCS</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$extfile 	= $sisa;

								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/injc128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/injc128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} // end if ($sisa!=0)
					else{
						//echo("<td>". $stdpack ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
							echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$stdpack.' PCS</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
							echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/injc128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/injc128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} //end  else
				} // end if ($jml==2)

				if($jml>2){
					for ($i=1;$i<=$jml;$i++){
						$kurang = $i * $stdpack;
						if($i % 2!=0){
							if (($totalqty - $kurang)>$sisa){
								//echo("<tr><td>". $stdpack ."</td>");
								if(($i+1) % 6==0){
									echo '<tr style="page-break-after: always;"><td>';
								}elseif($i % 3==0)	{
									echo '<tr><td height=380>';
								}else{
									echo '<tr><td>';
								}
								echo '<table border=1 cellspacing=0 width=300>';
									echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
									echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
									echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
									echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
									echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
									echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
									echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
									echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$stdpack.' PCS</b></p2></td> </tr>';
									echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
									echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
									echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
									echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
								echo '</table>';
								echo '<table border=0 cellspacing=0 width=300>';
									echo '<tr><td align=center valign=top>';
										$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
										
										// The arguments are R, G, B for color.
										$color_black = new BCGColor(0, 0, 0);
										$color_white = new BCGColor(255, 255, 255); 

										$code = new BCGcode128();
										$code->setScale(1); // Resolution
										$code->setThickness(35); // Thickness
										$code->setForegroundColor($color_black); // Color of bars
										$code->setBackgroundColor($color_white); // Color of spaces
										$code->setFont($font); // Font (or 0)
										$code->parse($barcode); // Text
										
										/* Here is the list of the arguments
										1 - Filename (empty : display on screen)
										2 - Background color */
										$drawing = new BCGDrawing('', $color_white);
										$drawing->setBarcode($code);
										$drawing->setFilename('../../printqr/injc128/'.$a);
										$drawing->draw();
										
										// Draw (or save) the image into PNG format.
										$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

										echo '<img width="300 height=120" ';
										echo 'title="barcode" src="../../printqr/injc128/' . $a . '" alt="gambar barcode" /><br />';
									echo '</td></tr>';
								echo '</table>';
								echo '</td>';
							} // end if (($totalqty - $kurang)>$sisa)
							else{
								if($sisa==0){
									//echo("<tr><td>". $stdpack ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=380>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
										echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
										echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
										echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$stdpack.' PCS</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
										echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text
											
											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/injc128/'.$a);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/injc128/' . $a . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}else{
									//echo("<tr><td>". $sisa ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=380>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
										echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
										echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
										echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$sisa.' PCS</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
										echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td><td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td></tr>';
										echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$extfile 	= $sisa;

											$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
											$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text

											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/injc128/'.$namafile);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/injc128/' . $namafile . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}
							} //end else
						} // end if($i % 2!=0)
						if ($i % 2==0){
							echo '<td align=right >';
							echo '<table border=1 cellspacing=0 width=300>';
								echo '<tr> <td width=70 rowspan=2><p2>Logo</p2></td> <td align=center><p2><b>'.$suppname.'</b></p2></td> <td width=70 align=center rowspan=2><p2><b>RoHS OK</b></p2></td> </tr>';
								echo '<tr> <td align=center><p2><b>'.$ulcode.'</b></p2></td> </tr>';
								echo '<tr> <td align=center><p2>Customer</p2></td> <td align=center colspan=2><p2>PT.JVCKENWOOD ELECTRONICS INDONESIA</p2></td> </tr>';
								echo '<tr> <td align=center><p2>Part Name.</p2></td> <td align=center><p2>'.$partnm.'</p2></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
								echo '<tr> <td align=center><p2>Part No.</p2></td> <td align=center><p2><b>'.$partno.'</b></p2></td> </tr>';
								echo '<tr> <td align=center><p2>Material</p2></td> <td align=center><p2>'.$mtrl.'</p2></td> </tr>';
								echo '<tr> <td align=center><p2>PO No.</p2></td> <td align=center><p2>'.$po.'</p2></td> </tr>';
								echo '<tr> <td align=center><p2>Qty</p2></td> <td align=center><p2><b>'.$stdpack.' PCS</b></p2></td> </tr>';
								echo '<tr> <td align=center><p2>Del. Date</p2></td> <td align=center><p2>'.$deldate.'</b></p2></td> </tr>';
								echo '<tr> <td align=center><p2>Prod. Date</p2></td> <td align=center><p2>'.$proddate.'</b></p2></td> </tr>';
								echo '<tr> <td align=center><p2>Shift</p2></td> <td align=center><p2>'.$shift.'</p2></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
								echo '<tr> <td align=center><p2>QC Check</p2></td> <td align=center><p2>'.$qcc.'</b></p2></td> </tr>';
							echo '</table>';
							echo '<table border=0 cellspacing=0 width=300>';
								echo '<tr><td align=center valign=top>';
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/injc128/' . $a . '" alt="gambar barcode" /><br />';
								echo '</td></tr>';
							echo '</table>';
							echo '</td></tr>';
						} // if ($i % 2==0)
					} // end for ($i=1;$i<=$jml;$i++)
				} // end if($jml>2)
			echo '</table>';
		break;
		// End Format barcode kategori  --- >>>  Injection Part
		
		case '3':  // Format barcode kategori  --- >>>  Printing Part
			$mtrl 		= $_GET['mtrl'];
			$shift 		= $_GET['shift'];
			$qcc 		= $_GET['qcc'];

			$stdpack 	= $pack; // standard packing tiap palet
			$totalqty 	= $qty; // total production quantity
			$sisa 		= $totalqty % $stdpack; // sisa hasil bagi
			$jml 		=ceil($totalqty / $stdpack); //hasil bagi dibulatkan ke atas
			$kurang 	= 1;
			//$jml =floor($totalqty / $stdpack); //hasil bagi dibulatkan ke bawah
			//echo $jml ." dan " .$sisa;

			echo '<table border=0 cellspacing=0 width=650>';
				if ($jml==1){
					if ($stdpack == $totalqty){
						//echo("<tr><td>". $totalqty ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($jml) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/prin128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/prin128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
					else{
						//echo("<tr><td>". $sisa ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$qtybal.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								//echo $suppname . '<br />';
								$extfile = $jml + 1;

								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode = $partno . ' ' . $po . ' ' . $qtybal;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/prin128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/prin128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
				} // end if ($jml==1)
				if ($jml==2){
					//echo("<tr><td>". $stdpack ."</td>");
					echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $stdpack;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/prin128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/prin128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
					echo '</td>';
					if ($sisa!=0){
						//echo("<td>". $sisa ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$sisa.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$extfile 	= $sisa;

								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/prin128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/prin128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} // end if ($sisa!=0)
					else{  
						//echo("<td>". $stdpack ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/prin128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/prin128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} //end  else
				} // end if ($jml==2)

				if($jml>2){
					for ($i=1;$i<=$jml;$i++){
						$kurang = $i * $stdpack;
						if($i % 2!=0){
							if (($totalqty - $kurang)>$sisa){
								//echo("<tr><td>". $stdpack ."</td>");
								if(($i+1) % 6==0){
									echo '<tr style="page-break-after: always;"><td>';
								}elseif($i % 3==0)	{
									echo '<tr><td height=400>';
								}else{
									echo '<tr><td>';
								}
								echo '<table border=1 cellspacing=0 width=300>';
									echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
									echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
									echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
									echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
									echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td><td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
									echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
								echo '</table>';
								echo '<table border=0 cellspacing=0 width=300>';
									echo '<tr><td align=center valign=top>';
										$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
										
										// The arguments are R, G, B for color.
										$color_black = new BCGColor(0, 0, 0);
										$color_white = new BCGColor(255, 255, 255); 

										$code = new BCGcode128();
										$code->setScale(1); // Resolution
										$code->setThickness(35); // Thickness
										$code->setForegroundColor($color_black); // Color of bars
										$code->setBackgroundColor($color_white); // Color of spaces
										$code->setFont($font); // Font (or 0)
										$code->parse($barcode); // Text
										
										/* Here is the list of the arguments
										1 - Filename (empty : display on screen)
										2 - Background color */
										$drawing = new BCGDrawing('', $color_white);
										$drawing->setBarcode($code);
										$drawing->setFilename('../../printqr/prin128/'.$a);
										$drawing->draw();
										
										// Draw (or save) the image into PNG format.
										$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

										echo '<img width="300 height=120" ';
										echo 'title="barcode" src="../../printqr/prin128/' . $a . '" alt="gambar barcode" /><br />';
									echo '</td></tr>';
								echo '</table>';
								echo '</td>';
							} // end if (($totalqty - $kurang)>$sisa)
							else{
								if($sisa==0){
									//echo("<tr><td>". $stdpack ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=400>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
										echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
										echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
										echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
										echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text
											
											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/prin128/'.$a);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/prin128/' . $a . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}else{
									//echo("<tr><td>". $sisa ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=400>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
										echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
										echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
										echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$sisa.' PCS</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
										echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$extfile 	= $sisa;

											$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
											$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text

											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/prin128/'.$namafile);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/prin128/' . $namafile . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}
							} //end else
						} // end if($i % 2!=0)
						if ($i % 2==0){
							echo '<td align=right >';
							echo '<table border=1 cellspacing=0 width=300>';
								echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
								echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
								echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Material</p></td> <td align=center><p>'.$mtrl.'</p></td> </tr>';
								echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
								echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Shift</p></td> <td align=center><p>'.$shift.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td>  </tr>';
								echo '<tr> <td align=center><p>QC Check</p></td> <td align=center><p>'.$qcc.'</b></p></td> </tr>';
							echo '</table>';
							echo '<table border=0 cellspacing=0 width=300>';
								echo '<tr><td align=center valign=top>';
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/prin128/' . $a . '" alt="gambar barcode" /><br />';
								echo '</td></tr>';
							echo '</table>';
							echo '</td></tr>';
						} // if ($i % 2==0)
					} // end for ($i=1;$i<=$jml;$i++)
				} // end if($jml>2)
			echo '</table>';
		break;
		// End Format barcode kategori  --- >>>  Printing Part
		
		case '4':  // Format barcode kategori  --- >>>  Wire Part
			// for kategori = 4 / WIRE
			$invno    	= $_GET['invno'];
			$et    		= $_GET['et'];
			$bn    		= $_GET['bn'];

			$stdpack 	= $pack; // standard packing tiap palet
			$totalqty 	= $qty; // total production quantity
			$sisa 		= $totalqty % $stdpack; // sisa hasil bagi
			$jml 		=ceil($totalqty / $stdpack); //hasil bagi dibulatkan ke atas
			$kurang 	= 1;
			//$jml =floor($totalqty / $stdpack); //hasil bagi dibulatkan ke bawah
			//echo $jml ." dan " .$sisa;

			echo '<table border=0 cellspacing=0 width=650>';
				if ($jml==1){
					if ($stdpack == $totalqty){
						//echo("<tr><td>". $totalqty ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Elec Tes</p></td> <td align=center><p>'.$et.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>1 / '.$jml.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($jml) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/wire128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/wire128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
					else{
						//echo("<tr><td>". $sisa ."</td></tr>");
						echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$qtybal.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Elect Test</p></td> <td align=center><p>'.$et.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>1 / '.$jml.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								//echo $suppname . '<br />';
								$extfile = $jml + 1;

								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode = $partno . ' ' . $po . ' ' . $qtybal;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/wire128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);
								
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/wire128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					}
				} // end if ($jml==1)
				if ($jml==2){
					//echo("<tr><td>". $stdpack ."</td>");
					echo '<tr><td>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Elec Test</p></td> <td align=center><p>'.$et.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>1 / '.$jml.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $stdpack;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/wire128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/wire128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
					echo '</td>';
					if ($sisa!=0){
						//echo("<td>". $sisa ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$sisa.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Elec Test</p></td> <td align=center><p>'.$et.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>2 / '.$jml.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$extfile 	= $sisa;

								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
								$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text

								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/wire128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/wire128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} // end if ($sisa!=0)
					else{  
						//echo("<td>". $stdpack ."</td></tr>");
						echo '<td align=right>';
						echo '<table border=1 cellspacing=0 width=300>';
							echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
							echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
							echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
							echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
							echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
							echo '<tr> <td align=center><p>Elec Test</p></td> <td align=center><p>'.$et.'</p></td> <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
							echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>2 / '.$jml.'</b></p></td> </tr>';
						echo '</table>';
						echo '<table border=0 cellspacing=0 width=300>';
							echo '<tr><td align=center>';
								$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
								
								// The arguments are R, G, B for color.
								$color_black = new BCGColor(0, 0, 0);
								$color_white = new BCGColor(255, 255, 255); 

								$code = new BCGcode128();
								$code->setScale(1); // Resolution
								$code->setThickness(35); // Thickness
								$code->setForegroundColor($color_black); // Color of bars
								$code->setBackgroundColor($color_white); // Color of spaces
								$code->setFont($font); // Font (or 0)
								$code->parse($barcode); // Text
								
								/* Here is the list of the arguments
								1 - Filename (empty : display on screen)
								2 - Background color */
								$drawing = new BCGDrawing('', $color_white);
								$drawing->setBarcode($code);
								$drawing->setFilename('../../printqr/wire128/'.$namafile);
								$drawing->draw();
								
								// Draw (or save) the image into PNG format.
								$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/wire128/' . $namafile . '" alt="gambar barcode" /><br />';
							echo '</td></tr>';
						echo '</table>';
						echo '</td></tr>';
					} //end  else
				} // end if ($jml==2)

				if($jml>2){
					for ($i=1;$i<=$jml;$i++){
						$kurang = $i * $stdpack;
						if($i % 2!=0){
							if (($totalqty - $kurang)>$sisa){
								//echo("<tr><td>". $stdpack ."</td>");
								if(($i+1) % 6==0){
									echo '<tr style="page-break-after: always;"><td>';
								}elseif($i % 3==0)	{
									echo '<tr><td height=400>';
								}else{
									echo '<tr><td>';
								}
								echo '<table border=1 cellspacing=0 width=300>';
									echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
									echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
									echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
									echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
									echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
									echo '<tr> <td align=center><p>Elec Test</p></td> <td align=center><p>'.$et.'</p></td>  <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
									echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>'.$i.' / '.$jml.'</b></p></td> </tr>';
								echo '</table>';
								echo '<table border=0 cellspacing=0 width=300>';
									echo '<tr><td align=center valign=top>';
										$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
										
										// The arguments are R, G, B for color.
										$color_black = new BCGColor(0, 0, 0);
										$color_white = new BCGColor(255, 255, 255); 

										$code = new BCGcode128();
										$code->setScale(1); // Resolution
										$code->setThickness(35); // Thickness
										$code->setForegroundColor($color_black); // Color of bars
										$code->setBackgroundColor($color_white); // Color of spaces
										$code->setFont($font); // Font (or 0)
										$code->parse($barcode); // Text
										
										/* Here is the list of the arguments
										1 - Filename (empty : display on screen)
										2 - Background color */
										$drawing = new BCGDrawing('', $color_white);
										$drawing->setBarcode($code);
										$drawing->setFilename('../../printqr/wire128/'.$a);
										$drawing->draw();
										
										// Draw (or save) the image into PNG format.
										$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

										echo '<img width="300 height=120" ';
										echo 'title="barcode" src="../../printqr/wire128/' . $a . '" alt="gambar barcode" /><br />';
									echo '</td></tr>';
								echo '</table>';
								echo '</td>';
							} // end if (($totalqty - $kurang)>$sisa)
							else{
								if($sisa==0){
									//echo("<tr><td>". $stdpack ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=400>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
										echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
										echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
										echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Elec Test</p></td> <td align=center><p>'.$et.'</p></td>  <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td> </tr>';
										echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>'.$i.' / '.$jml.'</b></p></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$a = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($stdpack) . '.jpg';
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text
											
											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/wire128/'.$a);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/wire128/' . $a . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}else{
									//echo("<tr><td>". $sisa ."</td>");
									if(($i+1) % 6==0){
										echo '<tr style="page-break-after: always;"><td>';
									}elseif($i % 3==0)	{
										echo '<tr><td height=400>';
									}else{
										echo '<tr><td>';
									}
									echo '<table border=1 cellspacing=0 width=300>';
										echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
										echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
										echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
										echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
										echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$sisa.' PCS</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
										echo '<tr> <td align=center><p>Elec Test</p></td> <td align=center><p>'.$et.'</p></td>  <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td>  </tr>';
										echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>'.$i.' / '.$jml.'</b></p></td> </tr>';
									echo '</table>';
									echo '<table border=0 cellspacing=0 width=300>';
										echo '<tr><td align=center valign=top>';
											$extfile 	= $sisa;

											$namafile = trim($vsupp).'_'.trim($partno).'_'.trim($po).'_'.trim($extfile) . '.jpg';
											$barcode 	= $partno . ' ' . $po . ' ' . $sisa;
											
											// The arguments are R, G, B for color.
											$color_black = new BCGColor(0, 0, 0);
											$color_white = new BCGColor(255, 255, 255); 

											$code = new BCGcode128();
											$code->setScale(1); // Resolution
											$code->setThickness(35); // Thickness
											$code->setForegroundColor($color_black); // Color of bars
											$code->setBackgroundColor($color_white); // Color of spaces
											$code->setFont($font); // Font (or 0)
											$code->parse($barcode); // Text

											/* Here is the list of the arguments
											1 - Filename (empty : display on screen)
											2 - Background color */
											$drawing = new BCGDrawing('', $color_white);
											$drawing->setBarcode($code);
											$drawing->setFilename('../../printqr/wire128/'.$namafile);
											$drawing->draw();
											
											// Draw (or save) the image into PNG format.
											$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

											echo '<img width="300 height=120" ';
											echo 'title="barcode" src="../../printqr/wire128/' . $namafile . '" alt="gambar barcode" /><br />';
										echo '</td></tr>';
									echo '</table>';
									echo '</td>';
								}
							} //end else
						} // end if($i % 2!=0)
						if ($i % 2==0){
							echo '<td align=right >';
							echo '<table border=1 cellspacing=0 width=300>';
								echo '<tr> <td width=70><p>Logo</p></td> <td align=center><p><b>'.$suppname.'</b></p></td> <td width=70 align=center><p><b>RoHS OK</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Customer</p></td> <td align=center colspan=2><p>PT.JVCKENWOOD ELECTRONICS INDONESIA</p></td> </tr>';
								echo '<tr> <td align=center><p>Part Name.</p></td> <td align=center><p>'.$partnm.'</p></td> <td rowspan=7 align=center valign=bottom><h2>'.$stsinsp.'</h2></td> </tr>';
								echo '<tr> <td align=center><p>Part No.</p></td> <td align=center><p><b>'.$partno.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Invoice No.</p></td> <td align=center><p>'.$invno.'</p></td> </tr>';
								echo '<tr> <td align=center><p>PO No.</p></td> <td align=center><p>'.$po.'</p></td> </tr>';
								echo '<tr> <td align=center><p>Qty</p></td> <td align=center><p><b>'.$stdpack.' PCS</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Del. Date</p></td> <td align=center><p>'.$deldate.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Prod. Date</p></td> <td align=center><p>'.$proddate.'</b></p></td> </tr>';
								echo '<tr> <td align=center><p>Elec Test</p></td> <td align=center><p>'.$et.'</p></td>  <td rowspan=2 align=center valign=top><b>Location</b><br><font size=2>'.$lokasi.'</font></td>  </tr>';
								echo '<tr> <td align=center><p>Box No.</p></td> <td align=center><p>'.$i.' / '.$jml.'</b></p></td> </tr>';
							echo '</table>';
							echo '<table border=0 cellspacing=0 width=300>';
								echo '<tr><td align=center valign=top>';
								echo '<img width="300 height=120" ';
								echo 'title="barcode" src="../../printqr/wire128/' . $a . '" alt="gambar barcode" /><br />';
								echo '</td></tr>';
							echo '</table>';
							echo '</td></tr>';
						} // if ($i % 2==0)
					} // end for ($i=1;$i<=$jml;$i++)
				} // end if($jml>2)
			echo '</table>';
		break;
		// End Format barcode kategori  --- >>>  Wire Part
		
		default:  // Format barcode Other Supplier
			echo '<table border=0 cellpadding=10 width=100%>';
				echo '<tr><td valign=top>';
					echo '<font size=7 color=red>Preview label gagal dilakukan !*</font>';
					echo '<br><hr>';
					echo '<font size=5 color=red>*Perusahaan anda tidak tergolong pada kategori manapun..</font>';
					echo '<br><br>';
				echo '</td></tr>';
			echo '</table>';
	} // end switch ($vsupp)
} // end if(isset($_GET['partno']))
?>
</body>
</html>

