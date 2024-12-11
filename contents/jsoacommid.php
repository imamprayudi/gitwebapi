<!DOCTYPE HTML>
<html>

<head>
  <title>SOA</title>
  <style type="text/css">
    @import "../assets/css/jquery.datepick.css";
  </style>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
  <script src="../assets/js/jquery.js"></script>
  <script type="text/javascript" src="../assets/js/jquery.datepick.js"></script>
</head>

<body>
  <?php
  include("koneksi.php");
  // include("jmenucss.php");
  include('../contents_v2/layouts/header.php');

  ?>
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

        echo '<br />';
        $komentar = $_POST["txtcom"];
        echo '<br />';
        $yangkomen =  $_POST["hcom"];
        echo '<br />';
        $supp = trim($_POST["hsupp"]);
        echo '<br />';
        $blnthn = trim($_POST["hblnthn"]);
        $rscek = $db->Execute("select blnthn,suppcode,suppcom,jeincom from soacommid where 
  blnthn = '" . $blnthn . "' and suppcode = '" . $supp . "'");
        $ada = $rscek->RecordCount();
        if ($ada == 0) {
          $sql = "insert into soacommid(blnthn,suppcode," . $yangkomen . ") values('" . $blnthn . "','" . $supp . "','" . $komentar . "')";
        } else {
          $sql = "update soacommid set " . $yangkomen . " ='" . $komentar . "' where 
  blnthn ='" . $blnthn . "' and suppcode ='" . $supp . "'";
        }


        $rs = $db->Execute($sql);
        $rs->Close();
        $db->Close();
        echo 'Your comment has been updated to the system.... thank you';
        ?>

      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>