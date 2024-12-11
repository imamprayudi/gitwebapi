<?php
//session_start();
//$myusername = $_SESSION['dinew_smyid'];
include 'koneksi.php';
// include("jmenudicss.php");
?>

<html>
<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
<script src="../assets/js/jquery.js"></script>

<body>
  <script type="text/javascript">
    checked = false;

    function checkedall(frmdiinv) {
      var aa = document.getElementById('frmdiinv');
      if (checked == false) {
        checked = true
      } else {
        checked = false
      }
      for (var i = 0; i < aa.elements.length; i++) {
        aa.elements[i].checked = checked;
      }
    }
  </script>

  <?php include('../contents_v2/layouts/header.php'); ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Forecast Archived</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Forecast Archived</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          // method post
          if (isset($_POST['subinv'])) {
            $btnsub = "invoice";
          }
          if (isset($_POST['subqty'])) {
            $btnsub = "qty";
          }
          if (isset($_POST['upload'])) {
            $btnsub = "upload";
          }
          if (isset($_POST['subedit'])) {
            $btnsub = "edit";
          }
          if (isset($_POST['subview'])) {
            $btnsub = "view";
          }
          if (isset($_POST['nama'])) {
            $uinv = $_POST['nama'];
          } else {
            $uinv = "";
          }
          if (isset($_POST['qty'])) {
            $uqty = $_POST['qty'];
          } else {
            $uqty = "";
          }
          if (isset($_POST['chkRow'])) {
            $ceknilai = $_POST['chkRow'];
          } else {
            $ceknilai = "";
          }


          if ($ceknilai == "") {
            if (isset($_POST['supptgl'])) {
              $supptgl = $_POST['supptgl'];
            }
          }
          if ($ceknilai != "") {
            foreach ($_POST['chkRow'] as $rowId) {
              $supptgl = substr($rowId, 0, 11) . '%';
              if (($uinv != "") && ($btnsub == "invoice")) {
                $sqlupinv = "update di set invoice = '{$uinv}' where supptglpo = '{$rowId}'";
                $rsupdate = $db->Execute($sqlupinv);
                $rsupdate->Close();
              }

              if (($uqty != "") && ($btnsub == "qty")) {
                $sqlupqty = "update di set qty = '{$uqty}' where supptglpo = '{$rowId}'";
                $rsupdate = $db->Execute($sqlupqty);
                $rsupdate->Close();
              }

              if ($btnsub == "upload") {
                $sqlupload = "update di set status = '1' where supptglpo = '{$rowId}'";
                $rsupload  = $db->Execute($rsupload);
                $rsupload->Close();
              }
            } //end foreach
          } // end if ($ceknilai != "")

          if ($btnsub == "edit") {
            $vsupp = substr($_POST['supp'], 0, 5);
            $vthn = substr($_POST['diyear'], 2, 2);
            $vbln = $_POST['dimonth'];
            $vtgl = $_POST['didate'];
            $supptgl = $vsupp . $vthn . $vbln . $vtgl .  "%";
          }
          if ($btnsub == "view") {
            $vsupp = substr($_POST['supp'], 0, 5);
            $vthn = substr($_POST['diyear'], 2, 2);
            $vbln = $_POST['dimonth'];
            $vtgl = $_POST['didate'];
            $supptgl = $vsupp . $vthn . $vbln . $vtgl . "%";
            //echo '$supptgl : ' . $supptgl;
            // echo '<a href="menu.php">menu</a>';
            echo '<br><br>VIEW DELIVERY INSTRUCTION<br>';
            $vstatus = $_POST['distatus'];
            if ($vstatus == '0') {
              echo "Status is not yet uploaded";
            }
            if ($vstatus == '1') {
              echo "Status is uploaded";
            }
            if ($vstatus == '2') {
              echo "Status is received";
            }
            echo "<br>";
          }
        } // end if ($_SERVER['REQUEST_METHOD'] == 'POST')
        else {
          $vsupp = ($_GET['s'] - 712) / 1997;
          $vtgl  = $_GET['t'];
          $vthn = substr($vtgl, 6, 2);
          $vbln = substr($vtgl, 3, 2);
          $vtgl = substr($vtgl, 0, 2);
          $supptgl = $vsupp . $vthn . $vbln . $vtgl . "%";
        } //end of get

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

        $sqldiv = "select supptglpo,supp,convert(varchar,tgli,1),po,partno,qty,convert(varchar,tgld,1),
  invoice,status,ditime,disq from di where status = '{$vstatus}' and supptglpo like
  '{$supptgl}' order by invoice,partno,po";
        $recdiv = $db->Execute($sqldiv);
        echo '<form action="diinv.php" method="post" id=frmdiinv name=frmdiinv>';
        while (!$recdiv->EOF) {
          echo "<tr>";
          echo  "<td>" . $recdiv->fields[0] . "</td><td>" . $recdiv->fields[1] . "</td><td>" . $recdiv->fields[2] . "</td>";
          echo  "<td>" . $recdiv->fields[3] . "</td><td>" . $recdiv->fields[4] . '</td><td align="right">' . $recdiv->fields[5] . "</td>";
          echo  "<td>" . $recdiv->fields[6] . "</td><td>" . $recdiv->fields[9] . ":00</td><td>" . $recdiv->fields[7] . "</td><td>" . $recdiv->fields[8] . "</td><td>" . $recdiv->fields[10] . "</td>";
          $yd = 'yudi';
          echo '<td><input type="checkbox" value=' . $recdiv->fields[0] . ' name="chkRow[]"></td>';
          echo "<td>";
          echo "</td>";
          echo "</tr>";
          $recdiv->MoveNext();
        }  // end of while recdiv fetch array
        $recdiv->Close();
        echo '<input type="hidden" name="supptgl" value=' . $supptgl . '>';
        echo '</form>';
        echo "</table>";
        $db->Close();
        ?>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>