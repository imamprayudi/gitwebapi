<!DOCTYPE HTML>
<html>

<head>
  <title>Forecast 2 Years Version</title>
  <link href="../assets/css/styles.css" rel="stylesheet" type="text/css">
  <script type="text/javascript">
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
  </script>
</head>

<body>


  <?php

  session_start();
  if (isset($_SESSION['usr'])) {
    // echo "session ok";
    $myid = $_SESSION["usr"];
  } else {
    echo "session time out";
  ?>
    <script>
      window.location.href = '../index.php';
    </script>
  <?php

  }

  include("koneksi.php");
  $rs = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp 
inner join Supplier on usersupp.SuppCode = Supplier.SuppCode 
where UserId = '" . $myid . "' order by suppname");
  // include("jmenucss.php");
  include('../contents_v2/layouts/header.php');

  ?>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Forecast</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Orders</a></li>
          <li class="breadcrumb-item active">Forecast</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">
            <form action="" class="row gx-3 gy-2 align-items-center">
              <div class="col-7">
                <label class="col-form-label" for="idsupp">Supplier</label>
                <select class="form-select" name="supp" id="idsupp">
                  <?php
                  while (!$rs->EOF) {
                    echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
                    $rs->MoveNext();
                  } ?>
                </select>
              </div>
              <div class="col-2">
                <label class="col-form-label" for="idsupp">Type</label>
                <select class="form-select" name="tipe" id="idtipe">
                  <option value="1">Weekly</option>
                  <option value="2">Monthly</option>
                </select>
              </div>
              <div class="col-2 mt-4">
                <input type="button" class="btn btn-info" value="Display" name="mybtn" id="btn" onClick="setText()">
              </div>
            </form>

            <!-- <div id="fdata">
            </div> -->
            <div id="sfcl" class="table-responsive">
            </div>
          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>