<!DOCTYPE HTML>
<html>

<head>
  <title>Material Detail Received</title>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">

</head>

<body>

  <?php
    include('layouts/header.php');
  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Material Detail Issued</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Materials</a></li>
          <li class="breadcrumb-item active">Material Detail Issued</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">

            <form name="submit_matiss" class="row gx-3 gy-2 align-items-center">
              <div class="col-7">
                <label for="supplier" class="form-label">Supplier</label>
                  <select type="text" id="supplier" name="supplier" class="form-control"></select>
              </div>
              <div class="col-2">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" id="from_date" name="from_date" class="form-control">
              </div>
              <div class="col-2">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
              </div>
              <div class="col-2 mt-4">
                <input type=submit value="Display" class="btn btn-info" id="submit_matiss">
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
            <div class="row"> <!-- sfcl -->
              <div class="card recent-sales overflow-auto ml-3">
                <div class="card-header">
                  MATERIAL DETAIL ISSUED
                </div>
                <div class="card-body">
                  <table id="table-matiss" class="table table-striped ml-3 display responsive nowrap"></table>
                </div>
              </div>
            </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
  <script src="../dist/jmaterial.bundle.js"></script>
</body>

</html>