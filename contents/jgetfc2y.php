<!-- <!DOCTYPE HTML>
<html>
<head>
<title>Get Forecast</title>
<!-- <link href="/css/jein.css" rel="stylesheet" type="text/css>--
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

<div class='datagrid'> -->

<?php

include("koneksi.php");

if (isset($_GET['supp']))
 {
   $suppid = $_GET['supp'];
   $tipe = $_GET['tipe'];
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
	  $r2 = 60;
    }
 }

$rs = $db->Execute("select transdate, rt, suppcode, subsuppcode, subsuppname, partno, partname, leadtime, 
  dt1qt1, dt1qt2, dt1qt3, dt1qt4, dt1qt5, dt1qt6, dt1qt7, dt1qt8, dt1qt9, dt1qt10, 
  dt1qt11, dt1qt12, dt1qt13, dt1qt14, dt1qt15, dt1qt16, dt1qt17, dt1qt18, dt1qt19, dt1qt20, 
  dt1qt21, dt1qt22, dt1qt23, dt1qt24, dt1qt25, dt1qt26, dt1qt27, dt1qt28, dt1qt29, dt1qt30, 
  dt1qt31, dt1qt32, dt1qt33, dt1qt34, dt1qt35, dt1qt36, dt1qt37, dt1qt38, dt1qt39, dt1qt40, 
  dt1qt41,dt1qt42,dt1qt43,dt1qt44, dt1qt45, dt1qt46, dt1qt47, dt1qt48, dt1qt49, dt1qt50, 
  dt1qt51, dt1qt52, dt1qt53,
  dt2qt1, dt2qt2, dt2qt3, dt2qt4, dt2qt5, dt2qt6, dt2qt7, dt2qt8, dt2qt9, dt2qt10, 
  dt2qt11, dt2qt12, dt2qt13, dt2qt14, dt2qt15, dt2qt16, dt2qt17, dt2qt18, dt2qt19, dt2qt20, 
  dt2qt21, dt2qt22, dt2qt23, dt2qt24, dt2qt25, dt2qt26, dt2qt27, dt2qt28, dt2qt29, dt2qt30, 
  dt2qt31, dt2qt32, dt2qt33, dt2qt34, dt2qt35, dt2qt36, dt2qt37, dt2qt38, dt2qt39, dt2qt40, 
  dt2qt41,dt2qt42,dt2qt43,dt2qt44, dt2qt45, dt2qt46, dt2qt47, dt2qt48, dt2qt49, dt2qt50, 
  dt2qt51, dt2qt52, dt2qt53,
  dt3qt1, dt3qt2, dt3qt3, dt3qt4, dt3qt5, dt3qt6, dt3qt7, dt3qt8, dt3qt9, dt3qt10, 
  dt3qt11, dt3qt12, dt3qt13, dt3qt14, dt3qt15, dt3qt16, dt3qt17, dt3qt18, dt3qt19, dt3qt20, 
  dt3qt21, dt3qt22, dt3qt23, dt3qt24, dt3qt25, dt3qt26, dt3qt27, dt3qt28, dt3qt29, dt3qt30, 
  dt3qt31, dt3qt32, dt3qt33, dt3qt34, dt3qt35, dt3qt36, dt3qt37, dt3qt38, dt3qt39, dt3qt40, 
  dt3qt41,dt3qt42,dt3qt43,dt3qt44, dt3qt45, dt3qt46, dt3qt47, dt3qt48, dt3qt49, dt3qt50, 
  dt3qt51, dt3qt52, dt3qt53,
  dt4qt1, dt4qt2, dt4qt3, dt4qt4, dt4qt5, dt4qt6, dt4qt7, dt4qt8, dt4qt9, dt4qt10, 
  dt4qt11, dt4qt12, dt4qt13, dt4qt14, dt4qt15, dt4qt16, dt4qt17, dt4qt18, dt4qt19, dt4qt20, 
  dt4qt21, dt4qt22, dt4qt23, dt4qt24, dt4qt25, dt4qt26, dt4qt27, dt4qt28, dt4qt29, dt4qt30, 
  dt4qt31, dt4qt32, dt4qt33, dt4qt34, dt4qt35, dt4qt36, dt4qt37, dt4qt38, dt4qt39, dt4qt40, 
  dt4qt41,dt4qt42,dt4qt43,dt4qt44, dt4qt45, dt4qt46, dt4qt47, dt4qt48, dt4qt49, dt4qt50, 
  dt4qt51, dt4qt52, dt4qt53,
  webcode from fc2y where rt = 'H' and suppcode = '" . $suppid . "'");

$ada = $rs->RecordCount();

if ($ada == 0) {
  // echo 'Data Nothing ....';
  ?>
    <div class="mt-4 container col-12 text-center text-danger">
      <h2>Data Nothing ....</h2>
    </div>
  <?php
  die();
}
    echo '<div class="mt-2">';
    echo '<table id="tblfcl" class="table table-responsive table-bordered table-striped font-monospace">';
    
    while (!$rs->EOF)
     {
       echo '<caption>FORECAST FOR ' . $rs->fields[4] . ' (' . $rs->fields[2] . ')' . ' - ' . $rs->fields[0] . ' - ' .$tipetext . '</caption>';
       echo '<tr>';
       echo "<thead class='table-primary'>";
       echo '<th>NO</th>';
       echo '<th style="width:100%">Part Number</th>';
       echo '<th>DD/MM</th>';
      
       for ($i = $r1; $i <= $r2; $i++)
        {
          echo '<th>' . $rs->fields[$i] . '</th>';
        }
       echo '</tr>';
       $rs->MoveNext();
     }
    echo "</thead>";
    $nomor = 0;
    $rs = $db->Execute("select transdate, rt, suppcode, subsuppcode, subsuppname, partno, partname, leadtime, 
    dt1qt1, dt1qt2, dt1qt3, dt1qt4, dt1qt5, dt1qt6, dt1qt7, dt1qt8, dt1qt9, dt1qt10, 
    dt1qt11, dt1qt12, dt1qt13, dt1qt14, dt1qt15, dt1qt16, dt1qt17, dt1qt18, dt1qt19, dt1qt20, 
    dt1qt21, dt1qt22, dt1qt23, dt1qt24, dt1qt25, dt1qt26, dt1qt27, dt1qt28, dt1qt29, dt1qt30, 
    dt1qt31, dt1qt32, dt1qt33, dt1qt34, dt1qt35, dt1qt36, dt1qt37, dt1qt38, dt1qt39, dt1qt40, 
    dt1qt41, dt1qt42, dt1qt43, dt1qt44, dt1qt45, dt1qt46, dt1qt47, dt1qt48, dt1qt49, dt1qt50, 
    dt1qt51, dt1qt52, dt1qt53,
    dt2qt1, dt2qt2, dt2qt3, dt2qt4, dt2qt5, dt2qt6, dt2qt7, dt2qt8, dt2qt9, dt2qt10, 
    dt2qt11, dt2qt12, dt2qt13, dt2qt14, dt2qt15, dt2qt16, dt2qt17, dt2qt18, dt2qt19, dt2qt20, 
    dt2qt21, dt2qt22, dt2qt23, dt2qt24, dt2qt25, dt2qt26, dt2qt27, dt2qt28, dt2qt29, dt2qt30, 
    dt2qt31, dt2qt32, dt2qt33, dt2qt34, dt2qt35, dt2qt36, dt2qt37, dt2qt38, dt2qt39, dt2qt40, 
    dt2qt41, dt2qt42, dt2qt43, dt2qt44, dt2qt45, dt2qt46, dt2qt47, dt2qt48, dt2qt49, dt2qt50, 
    dt2qt51, dt2qt52, dt2qt53,
    dt3qt1, dt3qt2, dt3qt3, dt3qt4, dt3qt5, dt3qt6, dt3qt7, dt3qt8, dt3qt9, dt3qt10, 
    dt3qt11, dt3qt12, dt3qt13, dt3qt14, dt3qt15, dt3qt16, dt3qt17, dt3qt18, dt3qt19, dt3qt20, 
    dt3qt21, dt3qt22, dt3qt23, dt3qt24, dt3qt25, dt3qt26, dt3qt27, dt3qt28, dt3qt29, dt3qt30, 
    dt3qt31, dt3qt32, dt3qt33, dt3qt34, dt3qt35, dt3qt36, dt3qt37, dt3qt38, dt3qt39, dt3qt40, 
    dt3qt41, dt3qt42, dt3qt43, dt3qt44, dt3qt45, dt3qt46, dt3qt47, dt3qt48, dt3qt49, dt3qt50, 
    dt3qt51, dt3qt52, dt3qt53,
    dt4qt1, dt4qt2, dt4qt3, dt4qt4, dt4qt5, dt4qt6, dt4qt7, dt4qt8, dt4qt9, dt4qt10, 
    dt4qt11, dt4qt12, dt4qt13, dt4qt14, dt4qt15, dt4qt16, dt4qt17, dt4qt18, dt4qt19, dt4qt20, 
    dt4qt21, dt4qt22, dt4qt23, dt4qt24, dt4qt25, dt4qt26, dt4qt27, dt4qt28, dt4qt29, dt4qt30, 
    dt4qt31, dt4qt32, dt4qt33, dt4qt34, dt4qt35, dt4qt36, dt4qt37, dt4qt38, dt4qt39, dt4qt40, 
    dt4qt41, dt4qt42, dt4qt43, dt4qt44, dt4qt45, dt4qt46, dt4qt47, dt4qt48, dt4qt49, dt4qt50, 
    dt4qt51, dt4qt52, dt4qt53,
    webcode from fc2y where rt = 'D' and suppcode = '" . $suppid . "' order by partno");
  echo "<tbody>";
    while (!$rs->EOF)
     {
       $nomor++;
       echo '<tr>';
       echo '<td>' . $nomor . '</td><td style="width:100%">';
       echo '<pre>' . $rs->fields[5]  . '</pre><br />';
       echo $rs->fields[6] . '<br />';
       echo $rs->fields[7] . '<br />';
       // echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       echo '</td>';
       echo '<td>FIRM<br />FOREC<br />PLAN<br />TOTAL<br /></td>';
       for ($y = $r1; $y <= $r2; $y++)
        {
         echo '<td align="right">' . $rs->fields[$y] . '<br />';
         echo $rs->fields[$y+53] . '<br />';
         echo $rs->fields[$y+53+53] . '<br />';
         echo $rs->fields[$y+53+53+53] . '</td>';
        }
       echo '</tr>';
       $rs->MoveNext();
     }
  echo "</tbody>";
    echo '</table>';

    echo '</div>';
  
$rs->Close();
$db->Close();
?>
</div>
</body>
</html>