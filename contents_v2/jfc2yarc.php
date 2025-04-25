<!DOCTYPE HTML>
<html>

<head>
  <title>Forecast Archived</title>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
</head>

<body>


  <?php

  include('layouts/header.php');
  ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Forecast Archived</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Forecast Archived</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">
            <form name="submit_fcyArc" class="row gx-3 gy-2 align-items-center">
              <div class="col-6">
                <label for="supplier" class="form-label">Supplier</label>
                  <select type="text" id="supplier" name="supplier" class="form-control"></select>
              </div>
              <div class="col-2">
                <label for="from_date" class="form-label">Transmission Date</label>
                <select type="text" id="tgl" name="tgl" class="form-control"></select>
              </div>
              <div class="col-2">
                <label class="col-form-label" for="idsupp">Type</label>
                <select class="form-select" name="tipe" id="idtipe">
                  <option value="1">Weekly</option>
                  <option value="2">Monthly</option>
                </select>
              </div>
              <div class="col-2 mt-4">
                <input type=submit value="Display" class="btn btn-info" id="submit_forecastArc">
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
      <div class="row"> <!-- sfcl -->
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-header">
            FORECAST ARCHIVED
          </div>
          <div class="card-body">
            <table id="table-forecastArc" class="table table-striped ml-3 display responsive nowrap"></table>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

   <?php include('layouts/footer.php'); ?>
  <script src="../dist/jforecast.bundle.js"></script>
</body>

</html>