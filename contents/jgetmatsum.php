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
      window.location.href = '../index.php';
    </script>
  <?php
  }

  include("koneksi.php");
  if ($_POST) {
    $supp = $_POST['suppid'];
    $period  = $_POST['periodid'];
  }

  $csupp = 'C' . $supp;
  $rs = $db->Execute("select partno,partname, convert(decimal,prevblncqty), 
  convert(decimal,recqty), convert(decimal,shipqty), convert(decimal,thisblncqty) 
  from sc01 where (loccode = '" . $csupp . "') and (period='" . $period . "') 
  AND (WHCODE = 'MC1') order by partno");
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
  ?><div class="mt-2">
    <table id="tblfcl" class="table table-responsive table-bordered table-striped font-monospace">
      <thead class="table-primary">
        <th>NO</th>
        <th>Part Number</th>
        <th>Part Name</th>
        <th>Previous Month Bal QTY</th>
        <th>Receive QTY</th>
        <th>ISSUE QTY</th>
        <th>This Month Bal QTY</th>
      </thead>
      <tbody>
        <?php
        $nomor = 0;
        while (!$rs->EOF) {
          $nomor++;
          echo '<tr>';
          echo '<td>' . $nomor . '</td>';
          echo '<td>
        <pre>' . trim($rs->fields[0]) . '</pre>
      </td>';
          echo '<td>' . $rs->fields[1] . '</td>';
          $f2 = number_format($rs->fields[2]);
          echo '<td align="right">' . $f2 . '</td>';
          $f3 = number_format($rs->fields[3]);
          echo '<td align="right">' . $f3 . '</td>';
          $f4 = number_format($rs->fields[4]);
          echo '<td align="right">' . $f4 . '</td>';
          $f5 = number_format($rs->fields[5]);
          echo '<td align="right">' . $f5 . '</td>';
          $rs->MoveNext();
        }
        ?>
      </tbody>
    </table>
    </div>
</body>

</html>