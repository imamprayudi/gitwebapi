<!DOCTYPE HTML>
<html>

<head>
  <title>Purchase Order Detail</title>
</head>

<body>
  <?php
  include('../contents_v2/layouts/header.php');
  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Purchase Order Detail - </h1>
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
      <div class="row">
        <div class="message"></div>
      </div>
      <div class="loading row col-12 mb-2 d-flex justify-content-center">
        <div class="spinner-border text-info mt-2" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <div class="row" id="confirmation">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-header" id="confirm_title">

          </div>
          <div class="card-body">
            <form action="" method="post">
              <div class="row justify-content-center mt-2">
                <div class="col-md-6 col-sm-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="reason"></textarea>
                    <label for="floatingTextarea">Reason</label>
                  </div>
                </div>
              </div>
              <div class="row row-cols-auto g-2 justify-content-center mt-2">
                <div class="form-floating">
                  <button class="form control btn btn-lg btn-success" id="confirm_podtl"></button>
                </div>
                <div class="form-floating">
                  <button class="form control btn btn-lg btn-danger" id="reject_podtl"></button>
                </div>
              </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-header">
            DATA PURCHASE ORDER
          </div>
          <div class="card-body">
            <table id="table-purchase-order-detail" class="table table-striped ml-3 display responsive nowrap">
            </table>
          </div>
        </div>
        </form>
      </div>

    </section>
  </main>


  <?php include('../contents_v2/layouts/footer.php'); ?>
  <script src="../dist/jpo_detail.bundle.js"></script>
</body>

</html>