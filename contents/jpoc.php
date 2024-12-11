<!DOCTYPE HTML>
<html>

<head>
  <title>Purchase Order Change</title>
  <!-- <style type="text/css">
    @import "../assets/css/jquery.datepick.css";
  </style>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
  <script src="../assets/js/jquery.js"></script>
  <script type="text/javascript" src="../assets/js/jquery.datepick.js"></script> -->
</head>

<body>
  <!-- 
  <?php
  // session_start();
  // if (isset($_SESSION['usr'])) {
  //   $myid = $_SESSION["usr"];
  // } else {
  //   echo "session time out";
  ?>
    <script>
      window.location.href = '../index.php';
    </script>
  <?php
  // }
  ?> -->

  <?php
  include('../contents_v2/layouts/header.php');
  ?>
  <!-- <script>
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
        $.post('jgetpoc.php', {
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
  </script> -->
  <?php
  //   include("koneksi.php");
  //   $rs = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp 
  // inner join Supplier on usersupp.SuppCode = Supplier.SuppCode 
  // where UserId = '" . $myid . "' order by suppname");
  //   // include("jmenucss.php");
  //   include('../contents_v2/layouts/header.php');

  ?>
  <main id="main" class="main">

    <div class="pagetitle">
        <h1>Purchase Order <span class="text-danger">Change</span></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Purchase Order Change</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="alert alert-warning" role="alert">
          <i class="fa-solid fa-triangle-exclamation"></i>
          *** The Purchase Order consider accepted if there is no reply within 5 days ***
        </div>
      </div>
      <div class="row">
        <?php

        //       echo '<br />';
        //       echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" 
        // style="float:left;width:220px;height:35px;">';
        //       echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA - PURCHASE ORDER CHANGE<br />';
        //       echo '*** The Purchase Order CHANGE consider accepted if there is no reply within 5 days ***';
        //       echo '<hr><br /><br />';
        //       echo '<form method="post" action="jgetpoc.php" name="jfForm">';
        //       echo 'Supplier : ';
        //       echo '<select name="supp" id="idsupp">';
        //       while (!$rs->EOF) {
        //         echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
        //         $rs->MoveNext();
        //       }
        // echo '</select>';
        // echo '<br /><br />';
        // echo 'DATE BETWEEN <input type="text" id="idtgl1" name="tgl1" />';
        // echo '&nbsp;&nbsp;';
        // echo 'AND <input type="text" id="idtgl2" name="tgl2" />';
        // echo '&nbsp;&nbsp;';
        // echo '  Filtered : ';
        // echo '<select name="pilih" id="idpilih">';
        // echo '<option value="1">All</option>';
        // echo '<option value="2">Unread</option>';
        // echo '<option value="3">Read</option>';
        // echo '<option value="4">Not Yet Confirmed</option>';
        // echo '<option value="5">Confirmed</option>';
        // echo '<option value="6">Reject</option>';
        // echo '</select>';
        // echo '<input type=submit value="Display">';
        // echo '</form>';
        // $rs->Close();
        // $db->Close();
        ?>
      </div>
      <div class="row">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-body">
            <h5 class="card-title">FILTER</h5>
            <form class="row g-3 ml-3" name="submit_poc" method="get">
              <div class="col-md-6">
                <!-- supplier: $("[name=supplier]").val(),
                from_date: $("[name=from_date]").val(),
                end_date: $("[name=end_date]").val(),
                select_po: $("[name=select_po]").val(),
                filter_by: $("[name=filter_by]").val() -->
                <div class="col-md-12">
                  <label for="supplier" class="form-label">Supplier</label>
                  <select type="text" id="supplier" name="supplier" class="form-control"></select>
                </div>
                <div class="row mt-2">
                  <div class="col-md-6">
                    <label for="from_date" class="form-label">From</label>
                    <input type="date" name="from_date" class="form-control" id="from_date" value="<?= date('Y-m-d') ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="end_date" class="form-label">To</label>
                    <input type="date" name="end_date" class="form-control" id="end_date" value="<?= date('Y-m-d') ?>">
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="col-12">
                  <label for="filter_by" class="form-label">Filter By</label>
                  <select class="form-select" name="filter_by" id="filter_by" data-placeholder="Filter By">
                    <option>--Select Category--</option>
                  </select>
                </div>
                <div class="col-12 mt-2">
                  <label for="select_poc" class="form-label mb-2">Select Based on Filter by</label>
                  <br>
                  <select class="form-select col-12" name="select_poc" id="select_poc" data-placeholder="Search Item" multiple>
                  </select>
                </div>
              </div>
              <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                <button type="reset" class="btn btn-secondary ">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="message"></div>
      </div>
      <div class="loading row col-12 mb-2 d-flex justify-content-center">
        <div class="spinner-border text-info mt-2" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      <div class="row">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-header">
            DATA PURCHASE ORDER CHANGE
          </div>
          <div class="card-body">
            <table id="table-purchase-order-change" class="table table-striped ml-3 display responsive nowrap">
            </table>
          </div>
        </div>
      </div>

      <!-- <div id="fdata">
        </div>
        <div id="sfcl">
        </div> -->

      <!-- </div> -->
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
  <script src="../dist/jpoc.bundle.js"></script>
</body>

</html>