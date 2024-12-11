<?php require('layouts/header.php'); ?>
<?php require('../contents/koneksi.php'); ?>
<style>
  div.dataTables_filter input {
    width: 400px;
    margin-left: 2px;
  }

  .t-head {
    border-top: black;
    border-bottom: black;
  }

  .swal-wide {
    width: 1500px !important;
  }

  .bg-unread {
    background-color: lightyellow;
  }

  .bg-rejected {
    background-color: lightcoral;
  }

  .bg-unconfirm {
    background-color: whitesmoke;
  }

  .bg-confirm {
    background-color: #bdf5bd;
  }

  .outset {
    border-bottom-style: outset;
  }

  table.dataTable.row-border tbody th,
  table.dataTable.row-border tbody td,
  table.dataTable.display tbody th,
  table.dataTable.display tbody td {
    border-top: 1px solid #dddddd;
  }

  table.dataTable.cell-border tbody th,
  table.dataTable.cell-border tbody td {
    border-top: 1px solid #dddddd;
    border-right: 1px solid #dddddd;
  }
</style>
<?php

$viewpo = $db->Execute("select top 1000 pono  from MAILPO ");
$viewpartno = $db->Execute("select top 1000  partno from MAILPO");

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
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <!-- Left side columns -->
    <div class="col-12">
      <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl">
          <div class="card info-card sales-card bg-secondary shadow load-holder">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <h5 class="card-title col-7 text-info text-start outset" name="monthly"></h5>
                  <p style="font-size:14px" class=" card-title col-5 text-light text-end outset">TOTAL ISSUE</p>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <h6 class="text-info col-xl-6 text-start"> PO </h6>
                  <h6 class="text-light col-xl-6 text-end mr-3" id="total_po"> 0</h6>
                </div>
                <div class="row">
                  <h6 class="text-info col-xl-6 text-start"> POC</h6>
                  <h6 class="text-light col-xl-6 text-end mr-3" id="total_poc">0</h6>
                </div>
              </div>
              <div class="d-flex align-items-center">
              </div>
            </div>
          </div>
          <div class="card info-card sales-card bg-secondary shadow placeholder-glow">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <div class="col-7 card-title outset">
                    <h5 class="col-12 placeholder"></h5>
                  </div>
                  <div class="col-5 card-title outset">
                    <p style="font-size:14px" class="text-light text-end">TOTAL ISSUE</p>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="row">
                  <div class="col-7">
                    <h6 class="text-info text-start"> PO </h6>
                  </div>
                  <div class="col-5">
                    <h6 class="placeholder col-12"></h6>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <h6 class="text-info text-start"> POC</h6>
                  </div>
                  <div class="col-7">
                    <h6 class="col-12 placeholder"></h6>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center">
              </div>
            </div>
          </div>

        </div>
        <!-- End TOTAL ISSUE -->

        <!-- UNREAD STATUS -->
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl">
          <div class="card info-card customers-card bg-unread shadow load-holder">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <h5 class="card-title col-7 text-dark text-start outset" name="monthly"></h5>
                  <p style="font-size:14px" class=" card-title col-5 text-secondary text-end outset ">UNREAD</p>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> PO </h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-start " id="percentpo_unread"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-start ">%</p>
                    </div>
                    <h6 class="text-secondary col-4 text-end mr-3" id="total_po_unread">0 </h6>
                  </div>
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> POC</h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-end " id="percentpoc_unread"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-end ">%</p>
                    </div>
                    <h6 class="text-secondary col-4 text-end mr-3" id="total_poc_unread">0 </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card info-card customers-card bg-unread shadow placeholder-glow">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <div class="col-7 card-title outset">
                    <h5 class="col-12 placeholder"></h5>
                  </div>
                  <div class="col-5 card-title outset">
                    <p style="font-size:14px" class="text-secondary text-end">UNREAD</p>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <div class="col-4">
                      <h6 class="text-dark text-start"> PO </h6>
                    </div>
                    <div class="col-4">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5">
                      <h6 class="text-dark text-start"> POC</h6>
                    </div>
                    <div class="col-3">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <!-- <div class="btn-group col-4">
                    </div> -->
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->

        <!-- READ & UNCONFIRM-->
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl">
          <div class="card info-card customers-card bg-unconfirm shadow load-holder">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <h5 class="card-title col-7 text-dark text-start outset" name="monthly"></h5>
                  <p style="font-size:14px" class=" card-title col-5 text-dark text-end  outset">UNCONFIRM</p>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> PO </h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-end " id="percentpo_unconfirm"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-end ">%</p>
                    </div>
                    <h6 class="text-secondary col-4 text-end mr-3" id="total_po_unconfirm">0</h6>
                  </div>
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> POC</h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-end " id="percentpoc_unconfirm"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-end ">%</p>
                    </div>
                    <h6 class="text-secondary col-4 text-end mr-3" id="total_poc_unconfirm">0</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card info-card customers-card bg-unconfirm shadow placeholder-glow">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <div class="col-5 card-title outset">
                    <h5 class="col-12 placeholder"></h5>
                  </div>
                  <div class="col-7 card-title outset">
                    <p class="text-dark text-end">UNCONFIRM</p>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <div class="col-4">
                      <h6 class="text-dark text-start"> PO </h6>
                    </div>
                    <div class="col-4">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5">
                      <h6 class="text-dark text-start"> POC </h6>
                    </div>
                    <div class="col-3">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- End confirm -->

        <!-- CONFIRM-->
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl">
          <div class="card info-card customers-card bg-confirm shadow load-holder">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <h5 class="card-title col-7 text-dark text-start  outset" name="monthly"></h5>
                  <p style="font-size:14px" class=" card-title col-5 text-dark text-end  outset">CONFIRMED</p>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> PO </h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-end " id="percentpo_confirm"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-end ">%</p>
                    </div>
                    <h6 class="text-dark col-4 text-end mr-3" id="total_po_confirm">0 </h6>
                  </div>
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> POC</h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-end " id="percentpoc_confirm"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-end ">%</p>
                    </div>
                    <h6 class="text-dark col-4 text-end mr-3" id="total_poc_confirm">0 <span class="text-success small pt-1 fw-bold " id="percent_poc_unconfirm"></span> <span class="text-muted small pt-2 ps-1">%</span></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card info-card customers-card bg-confirm shadow placeholder-glow">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <div class="col-7 card-title outset">
                    <h5 class="col-12 placeholder"></h5>
                  </div>
                  <div class="col-5 card-title outset">
                    <p style="font-size:14px" class="text-secondary text-end">CONFIRMED </p>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <div class="col-4">
                      <h6 class="text-dark text-start"> PO </h6>
                    </div>
                    <div class="col-4">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5">
                      <h6 class="text-dark text-start"> POC</h6>
                    </div>
                    <div class="col-3">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <!-- <div class="btn-group col-4">
                    </div> -->
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- End confirm -->

        <!-- REJECTED STATUS -->
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl">
          <div class="card info-card customers-card bg-rejected load-holder" id="infinite">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <h5 class="card-title col-7 text-dark text-start outset" name="monthly"></h5>
                  <p style="font-size:14px" class="card-title col-5 text-white text-end outset">REJECTED </p>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> PO </h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-start " id="percentpo_reject"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-start ">%</p>
                    </div>
                    <h6 class="text-white col-4 text-end mr-3" id="total_po_reject">
                  </div>
                  <div class="row">
                    <h6 class="text-dark col-4 text-start"> POC</h6>
                    <div class="btn-group col-4">
                      <p style="font-size:12px" class="text-success  fw-bold  text-end " id="percentpoc_reject"></p>
                      <p style="font-size:12px" class="text-success  fw-bold  text-end ">%</p>
                    </div>
                    <h6 class="text-white col-4 text-end mr-3" id="total_poc_reject">0 </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card info-card customers-card bg-rejected placeholder-glow">
            <div class="card-body">
              <div class="col-12">
                <div class="row">
                  <div class="col-7 card-title outset">
                    <h5 class="col-12 placeholder"></h5>
                  </div>
                  <div class="col-5 card-title outset">
                    <p style="font-size:14px" class="text-white text-end">REJECTED </p>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center">
                <div class="ps-3 col-12">
                  <div class="row">
                    <div class="col-4">
                      <h6 class="text-white text-start"> PO </h6>
                    </div>
                    <div class="col-4">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-5">
                      <h6 class="text-white text-start"> POC</h6>
                    </div>
                    <div class="col-3">
                      <p class="col-12 placeholder"></p>
                    </div>
                    <!-- <div class="btn-group col-4">
                    </div> -->
                    <div class="col-4">
                      <h6 class="col-12 placeholder"></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- End Revenue Card -->
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card recent-sales overflow-auto ml-3">
            <div class="card-body">
              <div class="row">
                <div class="col-7 card-title">
                  <h4>SUMMARY SUPPLIER PO</h4>
                </div>
                <div class="col-5 card-title">
                  <div class="loading d-flex justify-content-end">
                    <div class="spinner-border text-info" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Table with stripped rows -->
              <table id="table-summary-supplier-po" class="table table-striped ml-3 display responsive nowrap">
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-12">
          <div class="card recent-sales overflow-auto ml-3">
            <div class="card-body ">
              <div class="row">
                <div class="col-7 card-title">
                  <div class="row">
                    <h4>SUMMARY SUPPLIER PO <span class="text-danger">CHANGE</span></h4>

                  </div>
                </div>
                <div class="col-5 card-title">
                  <div class="loading d-flex justify-content-end">
                    <div class="spinner-border text-info" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Table with stripped rows -->
              <table id="table-summary-supplier-poc" class="table table-striped ml-3 display responsive nowrap">
              </table>
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>

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

      <?php
      // $rs = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp 
      //                               inner join Supplier on usersupp.SuppCode = Supplier.SuppCode 
      //                               where UserId = '" . $myid . "' order by suppname");
      ?>
      <!-- FILTER DATA PO -->
      <!-- <div class="row">
        <div class="col-sm-12 col-md-6 ml-2">
          <div class="card recent-sales overflow-auto ml-3">
            <div class="card-body">
              <h5 class="card-title">FILTER</h5>
              <form class="row g-3 ml-3" name="filter-all" method="get">
                <div class="col-md-12">
                  <label for="supplier" class="form-label">Supplier</label>
                  <select type="text" id="supplier" name="supplier" class="form-control">

                    <? //php foreach ($rs as $dd) { 
                    ?>
                      <option value="<? //= $dd[1] 
                                      ?>"><? //= $dd[2] . '-' . $dd[1] 
                                          ?></option>
                    <? //php } 
                    ?>

                  </select>
                </div>
                <div class="col-md-6">
                  <label for="from_date" class="form-label">From</label>
                  <input type="date" name="from_date" class="form-control" id="from_date" value="<?= date('Y-m-d') ?>"">
                  </div>
                  <div class=" col-md-6">
                  <label for="end_date" class="form-label">To</label>
                  <input type="date" name="end_date" class="form-control" id="end_date" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-12">
                  <label for="filter_by" class="form-label">Filter By</label>
                  <select class="form-select" name="filter_by" id="filter_by" data-placeholder="Filter By">
                    <option>--Select Category--</option>
                    <option value="part">Part Number</option>
                    <option value="pono">PO</option>
                  </select>
                </div>

                <div class="col-12">
                  <label for="select_po" class="form-label mb-2">Input PO/Part Number</label>
                  <br>
                  <select class="form-select col-12" name="select_po" id="select_po" data-placeholder="Search Item" multiple>
                  </select>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-6 ml-2">
          <div class="card recent-sales overflow-auto ml-3">
            <div class="card-body">
              <h5 class="card-title">REPEAT PO-<span class="text-danger">CHANGE</span></h5>
              <table id="repeat-po" class="table table-striped ml-3 display responsive nowrap">
                <thead class="t-head">
                  <tr>
                    <th scope="col">PO Number</th>
                    <th scope="col">Change</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- <div id="app" class="card col-sm-12 col-md-6 ml-3 table-responsive">
            <h4 class="card-title">REPEAT PO CHANGE</h4>
            <table id="repeat-po" class="table table-striped ml-3 display responsive nowrap">
              <thead class="t-head">
                <tr>
                  <th scope="col">PO Number</th>
                  <th scope="col">Change</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div> --
      </div> -->
      <!-- END FILTER DATA PO -->

      <!-- <div class="row">

        <div class="col-12">
          <div class="card recent-sales overflow-auto ml-3">
            <div class="card-body ">
              <h4 class="card-title">PO-<span class="text-danger">CHANGE</span> </h4>
              <!-- Table with stripped rows --
              <table id="po-change" class="table table-bordered dataTables_filter display responsive">
                <thead class="t-head">
                  <tr>
                    <th scope="col">Transmission No</th>
                    <th scope="col">Date</th>
                    <th scope="col">PO Status</th>
                    <th scope="col">Action Code</th>
                    <th scope="col">PO Number</th>
                    <th scope="col">Part Number</th>
                    <th scope="col">Partname</th>
                    <th scope="col">New Qty</th>
                    <th scope="col">New Date</th>
                    <th scope="col">Old Qty</th>
                    <th scope="col">Old Date</th>
                    <th scope="col">PO Type</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  </tr>
                </tbody>
              </table>
              <!-- End Table with stripped rows --
            </div>
          </div>
        </div>

      </div> --
    </div><!-- End Left side columns -->
  </section>

</main>
<!-- End #main -->
<?php require('layouts/footer.php'); ?>
<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../dist/dashboard.bundle.js"></script>
<!-- <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="../node_modules/axios/dist/axios.min.js"></script> -->
<!-- <script src="../node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script> -->
<!-- <script src="../node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script> -->
<script>
  function detail_click(pono) {

    var dummy = '';

    Swal.fire({
      title: 'Detail PO',
      customClass: 'swal-wide',
      html: `<table id="repeated_detail" class="table table-bordered dataTables_filter">
                      <thead class="t-head">
                        <tr>
                          <th style="font:size:12px" scope="col">Transmission No</th>
                          <th style="font:size:12px"  scope="col">Date</th>
                          <th style="font:size:12px"  scope="col">Action Code</th>
                          <th style="font:size:12px"  scope="col">PO Number</th>
                          <th style="font:size:12px"  scope="col">Part Number</th>
                          <th style="font:size:12px"  scope="col">Partname</th>
                          <th style="font:size:12px"  scope="col">New Qty</th>
                          <th style="font:size:12px"  scope="col">New Date</th>
                          <th style="font:size:12px"  scope="col">Old Qty</th>
                          <th style="font:size:12px"  scope="col">Old Date</th>
                          <th style="font:size:12px"  scope="col">PO Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>                     
                        </tr>
                      </tbody>
                    </table>`
    });

    axios.get('../api/dashboard.php', {
        params: {
          method: "getDataFilter",
          supplier: $('[name=supplier]').val(),
          from_date: $('[name=from_date]').val(),
          end_date: $('[name=end_date]').val(),
          select_po: [pono],
          filter_by: 'pono'
        }
      })
      .then(function(response) {
        console.log("repeated_detail => ", response)

        let repeate_detail_table = new DataTable('#repeated_detail', {
          data: response.data.pochange,
          order: [1, 'desc'],
          retrieve: true,
          dom: 'Bfrtip',
          buttons: [
            'excelHtml5',
            'csvHtml5'
          ],
          columns: [{
              data: 'idno'
            },
            {
              data: 'rdate'
            },
            {
              data: 'actioncode'
            },
            {
              data: 'pono'
            },
            {
              data: 'partno'
            },
            {
              data: 'partname'
            },
            {
              data: 'newqty'
            },
            {
              data: 'newdate'
            },
            {
              data: 'oldqty'
            },
            {
              data: 'olddate'
            },
            {
              data: 'potype'
            }
          ]

        });
      })
      .catch(function(error) {
        console.log(error);
      });
  }
</script>