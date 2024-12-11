<!DOCTYPE HTML>
<html>

<head>
  <title>Purchase Order</title>
  <!-- <style type="text/css">
@import "../assets/css/jquery.datepick.css";
</style>
<link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/jquery.datepick.js"></script> -->
</head>

<body>
  <?php
  include('../contents_v2/layouts/header.php');
  ?>

  <?php
  //   include("koneksi.php");
  //   $rs = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp 
  // inner join Supplier on usersupp.SuppCode = Supplier.SuppCode 
  // where UserId = '" . $myid . "' order by suppname");
  // include("jmenucss.php");
  // include('../contents_v2/layouts/header.php');

  ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Purchase Order</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Purchase Order</li>
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



      <?php

      // echo '<br />';
      // echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" style="float:left;width:220px;height:35px;">';
      // echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA - PURCHASE ORDER';
      // echo '<br />';
      /* 
echo '<form method="post" action="jgetpo.php" name="jfForm">';
echo 'Supplier : ';
echo '<select name="supp" id="idsupp">';

while (!$rs->EOF) 
{
  echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
  $rs->MoveNext();
}
echo '</select>';
echo '<br /><br />';
echo 'DATE &nbsp;<input type="text" id="datefrom" name="datefrom" data-mindate="today"/>';
echo '<br /><br />';
echo 'DATE BETWEEN &nbsp;<input type="date" id="idtgl1" name="tgl1" />';
echo '&nbsp;AND &nbsp;<input type="date" id="idtgl2" name="tgl2" />';
echo '  Filtered : ' ;
echo '<select name="pilih" id="idpilih">';
echo '<option value="1">All</option>';
echo '<option value="2">Unread</option>';
echo '<option value="3">Read</option>';
echo '<option value="4">Not Yet Confirmed</option>';
echo '<option value="5">Confirmed</option>';
echo '<option value="6">Reject</option>';
echo '</select>&nbsp;';
echo '<input type=submit value="Display">';
echo '</form>';
$rs->Close();
$db->Close(); */
      ?>
      <!-- <br/><br /> -->

      <!-- FILTER DATA PO -->
      <div class="row">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-body">
            <h5 class="card-title">FILTER</h5>
            <form class="row g-3 ml-3" name="submit_po" method="get">
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
                  <label for="select_po" class="form-label mb-2">Select Based on Filter by</label>
                  <br>
                  <select class="form-select col-12" name="select_po" id="select_po" data-placeholder="Search Item" multiple>
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
            DATA PURCHASE ORDER
          </div>
          <div class="card-body">
            <table id="table-purchase-order-st" class="table table-striped ml-3 display responsive nowrap">
            </table>
          </div>
        </div>
      </div>





      <!-- END FILTER DATA PO -->

      <!-- <div class="row">
          <div class="card card-info">
            <div class="card-body">
              <form action="jgetpodtl.php" method="get">
                <div class="mb3 col-6">
                  <select name="supplier" id="supplier" class="form-select">
                  
                  </select>
                </div>
              </form>
            </div>
          </div>
        </div> -->

      <!-- <div id="fdata">
      </div>
      <div id="sfcl">
      </div> -->


    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
  <script src="../dist/jpo.bundle.js"></script>
</body>

</html>