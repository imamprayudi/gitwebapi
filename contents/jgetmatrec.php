<!DOCTYPE HTML>
<html>

<head>
  <title>Material Summary</title>
</head>

<body>

  <?php
  session_start();
  if (isset($_SESSION['usr'])) {
  } else {
    echo "session time out";
  ?>
    <script>
      window.location.href = 'index.php';
    </script>
  <?php
  }

  include("koneksi.php");
  if ($_POST) {
    $supp = $_POST['suppid'];
    $tgl1  = $_POST['tgl1id'];
    $tgl2  = $_POST['tgl2id'];
  }

  $rs = $db->Execute("select col001,col002,col003,col004,col005,col006,col007,col008,
  col009,col010,col011,col012,col013,col014,col015,col016,col017,col018,col019,col020
  from vvi07rec where ( col013 = '" . $supp . "') and 
  ( col005 between '" . $tgl1 . "' and '" . $tgl2 . "') order by col005,col001");
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
  ?>
  <div class="mt-2">
    <table id="tblfcl" class="table table-responsive table-bordered table-striped font-monospace">
      <thead class='table-primary'>
        <th>NO</th>
        <th>Date</th>
        <th>Part Number</th>
        <th>PO Number</th>
        <th>Receive QTY</th>
        <th>Trans Code</th>
        <th>PM</th>
      </thead>
      <tbody>
        <?php
        $nomor = 0;
        while (!$rs->EOF) {
          $nomor++;
          echo '<tr>';
          echo '<td>' . $nomor . '</td>';
          $vdate = substr($rs->fields[4], 0, 10);
          echo '<td>' . $vdate . '</td>';
          echo '<td>
        <pre>' . trim($rs->fields[0]) . '</pre>
      </td>';
          echo '<td>' . $rs->fields[8] . '</td>';
          $vqty = number_format($rs->fields[5]);
          echo '<td align="right">' . $vqty . '</td>';
          echo '<td align="center">' . $rs->fields[2] . '</td>';
          if ($rs->fields[5] < 0) {
            $cekpm = '-';
          } else {
            $cekpm = '+';
          }
          echo '<td align="center">' . $cekpm . '</td>';
          $rs->MoveNext();
        }

        ?>
      </tbody>
    </table>
  </div>
</body>

</html>