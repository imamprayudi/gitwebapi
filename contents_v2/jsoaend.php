<!DOCTYPE HTML>
<html>

<head>
  <title>Statement Of Account End Term Payment</title>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/default.css" rel="stylesheet" type="text/css">
</head>

<body>

  <?php
    include('layouts/header.php');
  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Statement of Account - Payment End Of Month</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Payment End Of Month</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">

            <form name="submit_soaend" class="row gx-3 gy-2 align-items-center">
              <div class="col-7">
                <label for="supplier" class="form-label">Supplier</label>
                <select type="text" id="supplier" name="supplier" class="form-control"></select>
              </div>
              <div class="col-3">
                <label for="soa_date" class="form-label">SOA Date</label>
                <select id="soa_date" name="soa_date" class="form-control">
                  <option value="">Select SOA Date...</option>
                </select>
              </div>
              <div class="col-2 mt-4">
                <input type="submit" value="Display" class="btn btn-info" id="submit_soaend">
              </div>
            </form>
            
            <div class="row mb-3">
              <div class="message"></div>
            </div>
            
            <div class="loading row col-12 mb-2 d-flex justify-content-center">
              <div class="spinner-border text-info mt-2" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>

            <!-- Comment Card -->
            <div class="row mb-3" id="comment-section">
              <div class="card">
                <div class="card-header">
                  <h5>SUPPLIER COMMENT</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <label class="form-label">Supplier Comment:</label>
                      <textarea class="form-control" id="supplier_comment" rows="3" readonly></textarea>
                    </div>
                    <div class="col-6">
                      <label class="form-label">JKEI Comment:</label>
                      <textarea class="form-control" id="jkei_comment" rows="3"></textarea>
                      <button type="button" class="btn btn-primary mt-2" id="update_comment">Update Comment</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Last Payment Card -->
            <div class="row mb-3" id="last-payment-section">
              <div class="card">
                <div class="card-header">
                  <h5>LAST PAYMENT SUMMARY</h5>
                </div>
                <div class="card-body">
                  <table id="table-last-payment" class="table table-striped"></table>
                </div>
              </div>
            </div>

            <!-- Term Table -->
            <div class="row mb-3" id="term-section" style="display: none;">
              <div class="card">
                <div class="card-header">
                  <h5>PAYMENT TERMS</h5>
                </div>
                <div class="card-body">
                  <table id="table-term" class="table table-striped"></table>
                </div>
              </div>
            </div>

            <!-- SOA End Data Table -->
            <div class="row">
              <div class="card recent-sales overflow-auto ml-3">
                <div class="card-header">
                  STATEMENT OF ACCOUNT - END TERM PAYMENT
                </div>
                <div class="card-body">
                  <table id="table-soaend" class="table table-striped ml-3 display responsive nowrap"></table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
  <script src="../dist/jsoa.bundle.js"></script>
</body>

</html>