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
      <!-- <input class="form-control" id="usrsecure" hidden=true value="<?//= $mysecure ?>" /> -->
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

              <!-- <div class="row row-cols-lg-auto g-2 align-items-center justify-content-center mt-2"> -->
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

  <?php
  // if ($mysecure == '3')
  // {

  //   echo '<form method="POST" action="jgetpodtlpost.php" id="frmconfirm" name="jfrm">';
  //   echo '<input type="radio" name="rbnconfirm" value="1" checked="checked" />Confirm<br />' ;
  //   echo '<input type="radio" name="rbnconfirm" value="2" />Reject<br />' ;
  //   echo 'Input reject reason : <br />'; 
  //   echo '<input type="text" id="txtreject" name="textreject">';
  //   echo '<input type="hidden" id="suppid" name="suppname" value="' . $suppcode . '">';
  //   echo '<input type="hidden" id="tglid" name="tglname" value="' . $tgl . '">';
  //   echo '<br /><br />';
  //   echo '<input type="submit" id="submit" value="submit">';
  //   echo '</form>';
  //   $qrysts = "update mailpost set status = 'read',updated = GETDATE() where (supplier = '" . $suppcode . "') 
  //   and (transdate='" . $tgl ."')";
  //   $rsts = $db->Execute($qrysts);
  //   if($db->affected_rows() > 0) 
  //   {
  //     echo '<br />';
  //     echo 'Thank you for read the detail...'  	;
  //   }
  //   $rsts->Close();
  // }

  // session_start();
  // if(isset($_SESSION['usr']))
  // {
  //   $myid = $_SESSION["usr"];
  // $mysecure = $_SESSION["usrsecure"];
  //   $mygroup = $_SESSION["usrgroup"];
  //   $myname = $_SESSION["usrname"];
  //   $mymail = $_SESSION["usrmail"];
  // }  
  // else
  // {
  //   echo "session time out";
  ?>
  <!-- <script> 
  window.location.href = '../index.php';
  </script> -->
  <?php
  // }

  // include("koneksi.php");
  // echo '<div class="datagrid">';
  // $supp = $_GET['sid'];
  // $suppcode = intval($supp) / 14102703 ;
  // $tgl  = $_GET['tglid'];
  // $sts = $_GET['sts'];
  // $conf = $_GET['conf'];
  // $confdate = $_GET['confdate'];
  // $qry = "select idno,pono,partno,partname,newqty,newdate, price, model, potype,
  //   suppliername from mailpo where (supplier = '" . $suppcode . "') and (rdate='" . $tgl ."')";
  // $rs = $db->Execute($qry);
  // $ada = $rs->RecordCount();
  // if ($ada == 0)
  // {
  //   echo '<br />Data Nothing ....';
  // }

  // echo '<br />';
  // echo '<img src="../assets/gambar/jvc.gif" alt="JVC KENWOOD CORPORATION" 
  // style="float:left;width:220px;height:35px;">';
  // echo 'PT.JVCKENWOOD ELECTRONICS INDONESIA';
  // echo '<br />';
  // echo 'PURCHASE ORDER DETAIL';
  // echo '<hr>';
  // echo $rs->fields[9] . '&nbsp; - &nbsp;' . $suppcode . '&nbsp;&nbsp;Transmission Date : ' . $tgl . '<br />';
  // echo 'Status : ' . $sts . ' Confirmation Status : ' . $conf . ' Confirmation Date : '. $confdate;
  // echo '<br />*** The Purchase Order consider accepted if there is no reply within 5 days ***';
  // echo '<hr><br /><br />';

  // if ($mysecure == '3')
  // {
  //   echo '<form method="POST" action="jgetpodtlpost.php" id="frmconfirm" name="jfrm">';
  //   echo '<input type="radio" name="rbnconfirm" value="1" checked="checked" />Confirm<br />' ;
  //   echo '<input type="radio" name="rbnconfirm" value="2" />Reject<br />' ;
  //   echo 'Input reject reason : <br />'; 
  //   echo '<input type="text" id="txtreject" name="textreject">';
  //   echo '<input type="hidden" id="suppid" name="suppname" value="' . $suppcode . '">';
  //   echo '<input type="hidden" id="tglid" name="tglname" value="' . $tgl . '">';
  //   echo '<br /><br />';
  //   echo '<input type="submit" id="submit" value="submit">';
  //   echo '</form>';
  //   $qrysts = "update mailpost set status = 'read',updated = GETDATE() where (supplier = '" . $suppcode . "') 
  //   and (transdate='" . $tgl ."')";
  //   $rsts = $db->Execute($qrysts);
  //   if($db->affected_rows() > 0) 
  //   {
  //     echo '<br />';
  //     echo 'Thank you for read the detail...'  	;
  //   }
  //   $rsts->Close();
  // }

  // echo '<table id="tblpodtl" border="1">';
  // echo '<tr>';
  // echo '<th>NO.</th>';
  // echo '<th>TRANSMISSION NO.</th>';
  // echo '<th>PO NUMBER</th>';
  // echo '<th>PART NUMBER</th>';
  // echo '<th>PART NAME</th>';
  // echo '<th>PO QTY</th>';
  // echo '<th>PO DATE</th>';
  // echo '<th>PRICE</th>';
  // echo '<th>MODEL</th>';
  // echo '<th>PO TYPE</th>';
  // echo '</tr>';
  // $nomor = 0;

  // // while (!$rs->EOF)
  // // {
  // //   $nomor++; 
  // //   echo '<tr>';
  // // 	echo '<td align="right">' . $nomor . '</td>'; 
  // //   echo '<td>' . $rs->fields[0] . '</td>';
  // //   echo '<td>' . $rs->fields[1] . '</td>';
  // //   echo '<td>' . $rs->fields[2] . '</td>';
  // //   echo '<td>' . $rs->fields[3] . '</td>';
  // //   echo '<td align="right">' . $rs->fields[4] . '</td>';
  // //   $rdate = substr($rs->fields[5],0,10);
  // //   echo '<td>' . $rdate . '</td>';
  // //   $rprice = number_format($rs->fields[6],5);
  // //   echo '<td align="right">' . $rprice . '</td>';
  // //   echo '<td>' . $rs->fields[7] . '</td>';
  // //   echo '<td>' . $rs->fields[8] . '</td>';
  // // 	echo '</tr>';
  // // 	$rs->MoveNext();
  // // }

  // echo '</table>';

  // // $rs->Close();
  // // $db->Close();

  ?>
  <!-- </div>
<div id="hasil"></div> -->

  <?php include('../contents_v2/layouts/footer.php'); ?>
  <script src="../dist/jpo_detail.bundle.js"></script>
</body>

</html>