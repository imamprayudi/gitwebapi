
<?php
/*
get data Big Parts Schedule
*/
include("koneksi.php");

if (isset($_GET['supp']))
{
  $suppid = $_GET['supp']; 
}

if (isset($_GET['tgl']))
{
  $tgl = $_GET['tgl'];
}

$rs = $db->Execute("select transdate,hd,tm,suppcode,partno,partname,balqty,
  qty1,qty2,qty3,qty4,qty5,qty6,qty7,qty8,qty9,qty10,qty11,qty12,qty13,qty14,qty15,
  qty16,qty17,qty18,qty19,qty20,qty21,qty22,qty23,qty24,
  qty25,qty26,qty27,qty28,qty29,qty30,qty31 from bps where (hd = 'H') and
  (suppcode = '" . $suppid . "') and (transdate = '" . $tgl . "')");
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
  $supp = intval($suppid) * 14102703 ;
  echo '&nbsp;&nbsp;&nbsp;';
  echo '<a target="_blank" href="jbpsdl.php?suppid=' . $supp . "&tgl=" . $tgl . '">DOWNLOAD DATA TO CSV FORMAT</a>';
  echo '<br />';
  echo '<table id="tblbps" border="1">';
    
  while (!$rs->EOF)
  {
    echo '<br />';
    echo '<caption>BIG PART SCHEDULE FOR ' . $rs->fields[3] . '</caption>';
    echo '<tr>';
    echo '<th>NO</th>';
    echo '<th>Part Number</th>';
    echo '<th>00/00</th>';
    for ($i = 7; $i <= 26; $i++)
    {
      echo '<th>' . $rs->fields[$i] . '</th>';
    }
    echo '</tr>';
    $rs->MoveNext();
  }
  $nomor = 0;
  $rs = $db->Execute("select transdate,hd,tm,suppcode,partno,partname,balqty,
    qty1,qty2,qty3,qty4,qty5,qty6,qty7,qty8,qty9,qty10,qty11,qty12,qty13,qty14,qty15,
    qty16,qty17,qty18,qty19,qty20,qty21,qty22,qty23,qty24,
    qty25,qty26,qty27,qty28,qty29,qty30,qty31 from bps where (hd = 'D') 
    and (suppcode = '" . $suppid . "') and (transdate = '" . $tgl . "') order by partno");
  while (!$rs->EOF)
  {
    $nomor++;
    echo '<tr>';
    echo '<td>' . $nomor . '</td><td>';
    echo $rs->fields[4] . '<br />';
    echo $rs->fields[5] . '<br /></td>';
    for ($y = 6; $y <= 26; $y++)
    {
      echo '<td align="right">' . $rs->fields[$y] . '</td>';
    }
    echo '</tr>';
    $rs->MoveNext();
  }
    echo '</table>';

$rs->Close();
$db->Close();
?>