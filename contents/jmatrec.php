<!DOCTYPE HTML>
<html>

<head>
  <title>Material Received Detail</title>
  <style type="text/css">
    @import "../assets/css/jquery.datepick.css";
  </style>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
  <script src="../assets/js/jquery.js"></script>
  <script type="text/javascript" src="../assets/js/jquery.datepick.js"></script>

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
      $('#idtgl1').datepick();
      $('#idtgl2').datepick();
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
        $.post('jgetmatrec.php', {
            suppid: $('[name=supp]').val(),
            tgl1id: $('[name=tgl1]').val(),
            tgl2id: $('[name=tgl2]').val()
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
      <h1>Material Detail Received</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Material Detail Received</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">


            <!-- <br />
            <img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">
            PT.JVCKENWOOD ELECTRONICS INDONESIA
            <br />
            MATERIAL DETAIL RECEIVED STATUS REPORT
            <br /><br /> -->
            <form method="post" action="jgetmatrec.php" name="jfForm">
              <!-- class="row gx-3 gy-2 align-items-center"> -->
              <!-- <div class="mt-1 row"> -->
              <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">Date Between</span>
                <input type="text" class="form-control" id="idtgl1" name="tgl1">
                <span class="input-group-text">AND</span>
                <input type="text" class="form-control" id="idtgl2" name="tgl2">
              </div>
              <div class="input-group mt-3">
                <span class="input-group-text" id="basic-addon1">Supplier</span>
                <select class="form-select" name="supp" id="idsupp">
                  <?php
                  while (!$rs->EOF) {
                    echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
                    $rs->MoveNext();
                  }
                  ?>
                </select>
              </div>
              <div class="input-group mt-3">
                <input type=submit value="Display" class="btn btn-info">
              </div>


              <!-- <label class="col-sm-2 col-form-label" for="idtgl">Date Between</label>
              <div class="col-sm-10 imput-group">
                <input type="text" class="form-control" id="idtgl1" name="tgl1">
                <span class="input-group-text">AND</span>
                <input type="text" class="form-control" id="idtgl2" name="tgl2">
              </div> -->
              <!-- </div> -->
              <!-- <div class="col-12">
                <label class="col-form-label" for="idtgl">Date Between</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="idtgl1" name="tgl1">
                  <span class="input-group-text">AND</span>
                  <input type="text" class="form-control" id="idtgl2" name="tgl2">
                </div>
              </div>
              <div class="col-9">
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
              <div class="col-3 mt-3">
                <input type=submit value="Display" class="btn btn-info">
              </div> -->
            </form>
            <?php
            $rs->Close();
            $db->Close();
            ?>
            <br /><br />
            <div id="fdata" class="table-responsive">
            </div>
            <div id="sfcl">
            </div>

          </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>