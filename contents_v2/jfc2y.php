<!DOCTYPE HTML>
<html>

<head>
  <title>Forecast 2 Years Version</title>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
  <!-- <script type="text/javascript">
    function ShowForecast(str, tipe) {
      var xmlhttp;
      if (str == "") {
        document.getElementById("sfcl").innerHTML = "";
        return;
      }
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById("sfcl").innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.open("GET", "jgetfc2y.php?supp=" + str + "&tipe=" + tipe, true);
      xmlhttp.send();
    }

    function setText() {
      var e = document.getElementById("idsupp");
      var strsupp = e.options[e.selectedIndex].value;
      var t = document.getElementById("idtipe");
      var strtipe = t.options[t.selectedIndex].value;
      document.getElementById("sfcl").innerHTML = '<div class="text-center mt-4 g-3">' +
        '<div class="spinner-border text-danger" role="status">' +
        '<span class = "visually-hidden" > Loading... < /span>' +
        '</div>' +
        '<div class = "spinner-border text-warning" role = "status" > ' +
        '<span class = "visually-hidden" > Loading... </span>' +
        '</div>' +
        '<div class = "spinner-border text-info" role = "status">' +
        '<span class = "visually-hidden" > Loading... < /span>' +
        '</div>' +
        '</div>';
      ShowForecast(strsupp, strtipe);
    }
  </script> -->
</head>

<body>


  <?php

  // session_start();
  // if (isset($_SESSION['usr'])) {
  //   // echo "session ok";
  //   $myid = $_SESSION["usr"];
  // } else {
  //   echo "session time out";
  // ?>
  //   <script>
  //     window.location.href = '../index.php';
  //   </script>
  // <?php
  // }

//   include("koneksi.php");
//   $rs = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp 
// inner join Supplier on usersupp.SuppCode = Supplier.SuppCode 
// where UserId = '" . $myid . "' order by suppname");
//   // include("jmenucss.php");
//   include('../contents_v2/layouts/header.php');

  include('layouts/header.php');
  ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Forecast</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Forecast</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">
            <form name="submit_fcy" class="row gx-3 gy-2 align-items-center">
              <div class="col-6">
                <label for="supplier" class="form-label">Supplier</label>
                  <select type="text" id="supplier" name="supplier" class="form-control"></select>
              </div>
              <div class="col-3">
                <label class="col-form-label" for="idsupp">Type</label>
                <select class="form-select" name="tipe" id="idtipe">
                  <option value="1">Weekly</option>
                  <option value="2">Monthly</option>
                </select>
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
      <div class="row"> <!-- sfcl -->
        <div class="card recent-sales overflow-auto ml-3">
          <div class="card-header">
            FORECAST 2 YEARS
          </div>
          <div class="card-body">
            <table id="table-forecast" class="table table-striped ml-3 display responsive nowrap"></table>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

   <?php include('layouts/footer.php'); ?>
  <script src="../dist/jforecast.bundle.js"></script>
</body>

</html>