<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

isset($_SESSION['usr']) ? $myid = $_SESSION["usr"] : header("location:../contents/login.html");
$myid = $_SESSION["usr"];
$mysecure = $_SESSION["usrsecure"];
$mygroup = $_SESSION["usrgroup"];
$myname = $_SESSION["usrname"];
$mymail = $_SESSION["usrmail"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - JKEI Website</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <!-- <link href="../template/NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- <link href="../template/NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->
  <!-- <link href="../template/NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet"> -->
  <!-- <link href="../template/NiceAdmin/assets/vendor/quill/quill.snow.css" rel="stylesheet"> -->
  <!-- <link href="../template/NiceAdmin/assets/vendor/quill/quill.bubble.css" rel="stylesheet"> -->
  <!-- <link href="../template/NiceAdmin/assets/vendor/remixicon/remixicon.css" rel="stylesheet"> -->
  <!-- <link href="../template/NiceAdmin/assets/vendor/simple-datatables/style.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <!-- <link href="assets/css/style.css" rel="stylesheet"> -->
  <link href="../dist/main.bundle.css" rel="stylesheet">
</head>

<body class="toggle-sidebar">

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <span class="d-none d-lg-block">JVCKENWOOD</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <!-- <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a>
          <!-- End Notification Icon --

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items --

        </li> -->
        <!-- End Notification Nav -->

        <!-- <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon --

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items --

        </li> -->
        <!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['usrname'] ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $_SESSION['usrname'] ?></h6>
              <span><?= $_SESSION['usrgroup'] ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../contents_v2/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a href="#" class="nav-link"><small>Version 2.0.0-ALPHA-35</small></a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="../contents_v2/index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item"> <!-- ORDER -->
        <a class="nav-link collapsed" data-bs-target="#order-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Orders</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="order-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../contents/jfc2y.php">
              <i class="bi bi-circle"></i><span>Forecast</span>
            </a>
          </li>
          <li>
            <a href="../contents/jfc2yarc.php">
              <i class="bi bi-circle"></i><span>Forecast Archived</span>
            </a>
          </li>
          <li>
            <a href="../contents/jforecastarcy.php">
              <i class="bi bi-circle"></i><span>Forecast Archived OLD</span>
            </a>
          </li>
          <li>
            <a href="../contents/jpo.php">
              <i class="bi bi-circle"></i><span>Purchase Order</span>
            </a>
          </li>
          <li>
            <a href="../contents/jpoc.php">
              <i class="bi bi-circle"></i><span>Purchase Order Change</span>
            </a>
          </li>
          <li>
            <a href="../contents/jordbal.php">
              <i class="bi bi-circle"></i><span>Order Balance</span>
            </a>
          </li>
          <li>
            <a href="../contents/jordbalnew.php">
              <i class="bi bi-circle"></i><span>Order Balance New</span>
            </a>
          </li>
        </ul>
      </li><!-- End Order Nav -->

      <li class="nav-item"> <!-- SCHEDULE -->
        <a class="nav-link collapsed" data-bs-target="#schedule-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Schedules</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="schedule-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../contents/jtds.php">
              <i class="bi bi-circle"></i><span>Time Delivery</span>
            </a>
          </li>
          <li>
            <a href="../contents/jbps.php">
              <i class="bi bi-circle"></i><span>Big Parts</span>
            </a>
          </li>
        </ul>
      </li><!-- End Schedule Nav -->

      <li class="nav-item"> <!-- MATERIAL -->
        <a class="nav-link collapsed" data-bs-target="#material-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Materials</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="material-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../contents/jmatsum.php">
              <i class="bi bi-circle"></i><span>Summary</span>
            </a>
          </li>
          <li>
            <a href="../contents/jmatrec.php">
              <i class="bi bi-circle"></i><span>Received Detail</span>
            </a>
          </li>
          <li>
            <a href="../contents/jmatiss.php">
              <i class="bi bi-circle"></i><span>Issued Detail</span>
            </a>
          </li>
        </ul>
      </li><!-- End Material Nav -->

      <li class="nav-item"> <!-- SOA -->
        <a class="nav-link collapsed" data-bs-target="#soa-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Statement of Account</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="soa-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../contents/jsoa.php">
              <i class="bi bi-circle"></i><span>Detail</span>
            </a>
          </li>
          <li>
            <a href="../contents/jsoamid.php">
              <i class="bi bi-circle"></i><span>Mid</span>
            </a>
          </li>
          <li>
            <a href="../contents/jsoaend.php">
              <i class="bi bi-circle"></i><span>End</span>
            </a>
          </li>
        </ul>
      </li><!-- End Soa Nav -->

      <li class="nav-item"> <!-- DELIVERY -->
        <a class="nav-link collapsed" data-bs-target="#delivery-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Delivery</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="delivery-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../contents/jverify.php">
              <i class="bi bi-circle"></i><span>Delivery Instruction</span>
            </a>
          </li>
          <li>
            <a href="../suppqr/jstd_pack.php">
              <i class="bi bi-circle"></i><span>Std Packing Maintenance</span>
            </a>
          </li>
          <li>
            <a href="../suppqr/jmnl_barcode.php">
              <i class="bi bi-circle"></i><span>Print Barcode Label</span>
            </a>
          </li>
        </ul>
      </li><!-- End Delivery Nav -->
      <!-- 
      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav --

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav --

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav --

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav --

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav --

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav --

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li>End Blank Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->