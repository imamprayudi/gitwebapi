<!DOCTYPE HTML>
<html>

<head>
  <title>Time Delivery Schedule</title>
  <link href="../assets/css/jein.css" rel="stylesheet" type="text/css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript">
    function ShowBps(supp, tgl) {
      var xmlhttp;
      if (supp == "") {
        document.getElementById("sbps").innerHTML = "";
        return;
      }
      if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
          document.getElementById("sbps").innerHTML = xmlhttp.responseText;
        }
      }
      xmlhttp.open("GET", "jgettds.php?supp=" + supp + "&tgl=" + tgl, true);
      xmlhttp.send();
    }

    function setText() {
      var e = document.getElementById("idsupp");
      var strsupp = e.options[e.selectedIndex].value;
      var t = document.getElementById("idtgl");
      var strtgl = t.options[t.selectedIndex].value;
      document.getElementById("sbps").innerHTML = '<div class="text-center mt-4 g-3">' +
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
      ShowBps(strsupp, strtgl);
    }
  </script>
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

  include("koneksi.php");
  $rs = $db->Execute("select usersupp.UserId,usersupp.SuppCode,supplier.SuppName from UserSupp 
  inner join Supplier on usersupp.SuppCode = Supplier.SuppCode 
  where UserId = '" . $myid . "' order by suppname");

  // include("jmenucss.php");
  include('../contents_v2/layouts/header.php');

  ?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Time Delivery Schedule</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../contents_v2/index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="#">Schedules</a></li>
          <li class="breadcrumb-item active">Time Delivery Schedule</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="card card-info">
          <div class="card-body">
            <!-- echo '<br />';
            // echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" 
            //   style="float:left;width:220px;height:35px;">';
            // echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA ';
            // echo '<br />';
            // echo 'TIME DELIVERY SCHEDULE';
            // echo '<br /><br />'; -->
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
                <label for="idtgl" class="col-form-label"> Transmission Date </label>
                <?php $rs = $db->Execute("select transdate from tdsdate order by transdate desc"); ?>
                <select name="tgl" id="idtgl" class="form-select">
                  <?php
                  while (!$rs->EOF) {
                    echo '<option value="' . substr($rs->fields[0], 0, 10) . '">' . substr($rs->fields[0], 0, 10) . '</option>';
                    $rs->MoveNext();
                  } ?>
                </select>
              </div>
              <div class="col-2 mt-4">
                <button type="button" class="btn btn-info" name="mybtn" id="btn" onClick="setText()">Display</button>
                <!-- <a target="_blank" class="btn btn-info text-center mb-2" href="jtdsdl.php?suppid=' . $supp . " &tgl=" . $tgl . '">DOWNLOAD DATA TO CSV FORMAT</a> -->
              </div>
            </form>
            <?php
            $rs->Close();
            $db->Close();
            ?>
            <!-- <div id="fdata">
            </div> -->

            <div id="sbps" class="table-responsive">
            </div>

          </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>