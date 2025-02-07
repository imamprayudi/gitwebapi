<!DOCTYPE HTML>
<html>

<head>
  <title>Print Barcode Label</title>
</head>

<body>
  <?php
  include('layouts/header.php');
  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Print Barcode Label</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Delivery</a></li>
          <li class="breadcrumb-item active">Print Barcode Label</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">
            <form method="post" action="jgetordbal.php" name="submit_ordbal" class="row gx-3 gy-2 align-items-center">
              <div class="col-6">
                <label for="supplier" class="form-label">Supplier</label>
                  <select type="text" id="supplier" name="supplier" class="form-control"></select>
              </div>
              <div class="col-2 mt-4">
                <input type=submit value="Display" class="btn btn-info">
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
      <div id="qrcode"></div>
        <button onclick="generateQRCode()">Generate QR Code</button>
      <!-- <div class="row">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-header">
            DATA ORDER BALANCE
          </div>
          <div class="card-body">
            <table id="table-orderBalance" class="table table-striped ml-3 display responsive nowrap"></table>
          </div>
        </div>
      </div> -->
    </section>

  </main><!-- End #main -->

  <?php include('layouts/footer.php'); ?>
  <script src="../dist/barcode_label.bundle.js"></script>
</body>

</html>