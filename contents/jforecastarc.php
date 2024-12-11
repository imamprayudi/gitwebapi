<!DOCTYPE HTML>
<html>

<head>
  <title>Forecast Archived</title>
  <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css"> -->
  <script src="../assets/js/jquery.js"></script>
</head>

<body>
  <?php

  session_start();
  if (isset($_SESSION['usr'])) {
    $myid = $_SESSION["usr"];
  } else {
    echo "session time out";
  ?>
    <script>
      window.location.href = '../index.php';
    </script>
  <?php
  }

  ?>
  <script>
    $(document).ready(function() {
      $('form[name=jfForm]').submit(function() {
        $('#fdata').html('<p><br /><br />Loading....<img src="../assets/gambar/loading.gif" alt="Loading" height="25" width="25" align="middle" /></p>');
        $.post('jgetfclarc.php', {
            suppid: $('[name=supp]').val(),
            tanggal: $('[name=tgl]').val(),
            tipe: $('[name=tipe]').val()
          },
          function(data) {
            $('#fdata').html(data).show();
          });
        return false;
      });

    });
  </script>
  <?php
  include("koneksi.php");
  $rs = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp 
inner join Supplier on usersupp.SuppCode = Supplier.SuppCode 
where UserId = '" . $myid . "' order by suppname");
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
        // echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">';
        // echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA ';
        // echo '<br />';
        // echo 'PART PURCHASE LONG FORECAST ARCHIVED';
        // echo '<br /><br />';
        echo '<form method="post" action="jgetfclarc.php" name="jfForm">';
        echo 'Supplier : ';
        echo '&nbsp;&nbsp;';
        echo '<select name="supp" id="idsupp">';

        while (!$rs->EOF) {
          echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
          $rs->MoveNext();
        }
        echo '</select>';
        echo '&nbsp;&nbsp;';
        $rsf = $db->Execute("select transdate from forcast_date order by transdate desc");
        echo '<select name="tgl" id="idtgl">';
        while (!$rsf->EOF) {
          echo '<option value="' . substr($rsf->fields[0], 0, 10) . '">' . substr($rsf->fields[0], 0, 10) . '</option>';
          $rsf->MoveNext();
        }
        echo '</select>&nbsp;&nbsp;';
        echo '<select name="tipe" id="idtipe">';
        echo '<option value="1">Weekly</option>';
        echo '<option value="2">Monthly</option>';
        echo '</select>';
        echo '&nbsp;&nbsp;';
        echo '<input type=submit value="Display">';
        echo '</form>';
        $rs->Close();
        $rsf->Close();
        $db->Close();

        ?>
        <br /><br />
        <div id="fdata">

        </div>
        <div id="sfcl">
        </div>

      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>

</body>

</html>