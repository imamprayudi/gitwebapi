<!DOCTYPE HTML>
<html>

<head>
  <title>Forecast Archived OLD</title>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
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
        $('#fdata').html('<div class="text-center mt-4 g-3">' +
          '<div class="spinner-border text-danger" role="status">' +
          '<span class = "visually-hidden" > Loading... < /span>' +
          '</div>' +
          '<div class = "spinner-border text-warning" role = "status" > ' +
          '<span class = "visually-hidden" > Loading... </span>' +
          '</div>' +
          '<div class = "spinner-border text-info" role = "status">' +
          '<span class = "visually-hidden" > Loading... < /span>' +
          '</div>' +
          '</div>');
        $.post('jgetfclarcy.php', {
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
      <h1>Forecast Archived OLD</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Forecast Archived OLD</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">


            <!-- echo '<br />';
            echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">';
            echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA ';
            echo '<br />';
            echo 'PART PURCHASE LONG FORECAST ARCHIVED OLD FORMAT';
            echo '<br /><br />'; -->
            <form method="post" action="jgetfclarcy.php" name="jfForm" class="row gx-3 gy-2 align-items-center">
              <div class="col-5">
                <label class="col-form-label" for="idsupp">Supplier</label>
                <select class="form-select" name="supp" id="idsupp">
                  <?php
                  while (!$rs->EOF) {
                    echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
                    $rs->MoveNext();
                  }
                  ?>
                </select>
              </div>
              <?php
              $rsf = $db->Execute("select transdate from FORECASTDATEY order by transdate desc");
              ?>
              <div class="col-2">
                <label class="col-form-label" for="idtgl">Tanggal</label>
                <select class="form-select" name="tgl" id="idtgl">
                  <?php
                  while (!$rsf->EOF) {
                    echo '<option value="' . substr($rsf->fields[0], 0, 10) . '">' . substr($rsf->fields[0], 0, 10) . '</option>';
                    $rsf->MoveNext();
                  }
                  ?>
                </select>
              </div>
              <div class="col-2">
                <label class="col-form-label" for="idtipe">Type</label>
                <select class="form-select" name="tipe" id="idtipe">
                  <option value="1">Weekly</option>
                  <option value="2">Monthly</option>
                </select>
              </div>
              <div class="col-2 mt-4">
                <input type=submit value="Display" class="btn btn-info">
              </div>
            </form>
            <?php
            $rs->Close();
            $rsf->Close();
            $db->Close();
            ?>

            <div id="fdata" class="table-responsive">

            </div>
            <div id="sfcl">
            </div>

          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>