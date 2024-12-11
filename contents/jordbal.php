<!DOCTYPE HTML>
<html>

<head>
  <title>Order Balance</title>
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
        $.post('jgetordbal.php', {
            suppid: $('[name=supp]').val(),
            urutanid: $('[name=urutan]').val()
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
      <h1>Order Balance</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Order Balance</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">
            <form method="post" action="jgetordbal.php" name="jfForm" class="row gx-3 gy-2 align-items-center">
              <div class="col-6">
                <label class="col-form-label" for="idsupp">Supplier</label>
                <select class="form-select" name="supp" id="idsupp">
                  <?php
                  while (!$rs->EOF) {
                    echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
                    $rs->MoveNext();
                  } ?>
                </select>
              </div>
              <div class="col-3">
                <label class="col-form-label" for="idurutan">Order By</label>
                <select class="form-select" name="urutan" id="idurutan">
                  <option value="1">Part Number</option>
                  <option value="2">Req Date</option>
                  <option value="3">PO Number</option>
                  <option value="4">Model</option>
                  <option value="5">Issue Date</option>
                </select>
              </div>
              <div class="col-2 mt-4">
                <input type=submit value="Display" class="btn btn-info">
              </div>
            </form>
            <?php
            $rs->Close();
            $db->Close();
            ?>

            <div id="fdata" class="table-responsive"></div>
            <!-- <div id="sfcl">
            </div> -->

          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>