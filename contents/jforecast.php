<!DOCTYPE HTML>
<html>

<head>
  <title>Forecast</title>
  <!-- <link href="../assets/css/styles.css" rel="stylesheet" type="text/css"> -->
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
      xmlhttp.open("GET", "jgetfcl.php?supp=" + str + "&tipe=" + tipe, true);
      xmlhttp.send();
    }

    function setText() {
      var e = document.getElementById("idsupp");
      var strsupp = e.options[e.selectedIndex].value;
      var t = document.getElementById("idtipe");
      var strtipe = t.options[t.selectedIndex].value;
      document.getElementById("sfcl").innerHTML = '<div><p><br /><br />Loading....<img src="../assets/gambar/loading.gif" alt="Loading" height="25" width="25" align="middle" /></p></div>';
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
  $rs = $db->Execute("select userid,suppcode,suppname from usersupp where UserId = '" . $myid . "' 
  order by suppname");
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
          
        
        <?php

        echo '<br />';

        // echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" 
        //   style="float:left;width:220px;height:35px;">';
        // echo 'PT.JVC ELECTRONICS INDONESIA ';
        // echo '<br />';
        // echo 'PART PURCHASE LONG FORECAST';
        // echo '<br /><br />';
        echo '<form action="">';
        echo 'Supplier : &nbsp;&nbsp;';
        echo '<select name="supp" id="idsupp">';

        while (!$rs->EOF) {
          echo '<option value="' . $rs->fields[1] . '">' . $rs->fields[2] . ' - ' . $rs->fields[1] . '</option>';
          $rs->MoveNext();
        }
        echo '</select>';
        echo '&nbsp;&nbsp;';
        echo '<select name="tipe" id="idtipe">';
        echo '<option value="1">Weekly</option>';
        echo '<option value="2">Monthly</option>';
        echo '</select>';
        echo '&nbsp;&nbsp;';
        echo '<input type=BUTTON value="Display" name="mybtn" id="btn" onClick="setText()">';
        echo '</form>';
        $rs->Close();
        $db->Close();
        ?>
        <br /><br />


        <div id="fdata" class="responsive">
        </div>

        <div id="sfcl" >
        </div>


        </div>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

    <?php include('../contents_v2/layouts/footer.php'); ?>
</body>

</html>