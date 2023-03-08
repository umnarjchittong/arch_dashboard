<!DOCTYPE html>
<html lang="en">

<?php
include('../core.php');
$fnc = new CommonFnc;
$fnc_json = new Fnc_json_service;
$fnc_chartjs = new Fnc_ChartJS;

include('main.php');

if (!isset($_SESSION["data"]["personal"]) || (isset($_GET["data_refresh"]) && $_GET["data_refresh"])) {
  $_SESSION["data"]["personal"] = $fnc_json->json_read('../data/personal.json');
}
$fnc->debug_console("personal: ", $_SESSION["data"]["personal"]);


?>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/favicon-96x96.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon-96x96.png">
  <title>
    ARCH Dashboard
  </title>
  <!--     Fonts and icons     -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" /> -->
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;600;700" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../theme/assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- <link href="../theme/assets/css/nucleo-svg.css" rel="stylesheet" /> -->
  <!-- Font Awesome Icons -->
  <link href="../node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> -->
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/dashboard.css" rel="stylesheet" />
  <script src="../node_modules/chart.js/dist/chart.umd.js"></script>
</head>

<body class="g-sidenav-show  bg-gray-100">
  <?php include 'nav_aside.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">

    <!-- Navbar -->
    <?php include 'nav_top.php'; ?>
    <!-- End Navbar -->

    <div class="container-fluid py-4">
      <?php panel_personal_info($_SESSION["data"]["personal"]); ?>

      <div class="row row-cols-md-2  row-cols-lg-4 mt-4 mb-4">
        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("วิชาการ", "สนับสนุน", "ศึกษาต่อ");
          $data_person = $_SESSION["data"]["personal"];
          $data_array = array($data_person["teacher"], $data_person["officer"], 3);
          $fnc_chartjs->gen_Chart_Doughnut('สัดส่วนบุคลากรทั้งหมด', $labels_array, $data_array, 'person_overall');
          ?>
        </div>
        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("ศ.", "รศ.", "ผศ.", "อ.");
          $data_person = $_SESSION["data"]["personal"]["teacher_degree"];
          $data_array = array($data_person["professor"], $data_person["assoc_prof"], $data_person["assist_prof"], $data_person["teacher"]);
          $fnc_chartjs->gen_Chart_Doughnut('ตำแหน่งทางวิชาการ', $labels_array, $data_array, 'person_position');
          ?>
        </div>

        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("ป.เอก", "ป.โท", "ป.ตรี", "อื่นๆ");
          $data_person = $_SESSION["data"]["personal"]["teacher_degree"];
          $data_array = array($data_person["doctor"], $data_person["master"], $data_person["bachelor"], 0);
          $fnc_chartjs->gen_Chart_Doughnut('คุณวุฒิ สายวิชาการ', $labels_array, $data_array, 'teacher_degree');
          ?>
        </div>
        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("ป.เอก", "ป.โท", "ป.ตรี", "อื่นๆ");
          $data_person = $_SESSION["data"]["personal"]["officer_degree"];
          $data_array = array($data_person["doctor"], $data_person["master"], $data_person["bachelor"], $data_person["none"]);
          $fnc_chartjs->gen_Chart_Doughnut('คุณวุฒิ สายสนับสนุน', $labels_array, $data_array, 'officer_degree');
          ?>
        </div>
      </div>

      <div class="row row-cols-md-1 row-cols-lg-2 mt-4 mb-4 g-4">
        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("วิชาการ", "สนับสนุน", "ศึกษาต่อ");
          $data_person = $_SESSION["data"]["personal"];
          $data_array = array($data_person["teacher"], $data_person["officer"], 3);
          $fnc_chartjs->gen_Chart_Bar('สัดส่วนบุคลากรทั้งหมด', $labels_array, $data_array, 'person_overall_bar');
          ?>
        </div>
        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("ศ.", "รศ.", "ผศ.", "อ.");
          $data_person = $_SESSION["data"]["personal"]["teacher_degree"];
          $data_array = array($data_person["professor"], $data_person["assoc_prof"], $data_person["assist_prof"], $data_person["teacher"]);
          $fnc_chartjs->gen_Chart_Bar('ตำแหน่งทางวิชาการ', $labels_array, $data_array, 'person_position_bar');
          ?>
        </div>

        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("ป.เอก", "ป.โท", "ป.ตรี", "อื่นๆ");
          $data_person = $_SESSION["data"]["personal"]["officer_degree"];
          $data_array = array($data_person["doctor"], $data_person["master"], $data_person["bachelor"], 0);
          $fnc_chartjs->gen_Chart_Bar('คุณวุฒิ สายวิชาการ', $labels_array, $data_array, 'teacher_degree_bar');
          ?>
        </div>
        <div class="col mb-lg-0 mb-4">
          <?php
          $labels_array = array("ป.เอก", "ป.โท", "ป.ตรี", "อื่นๆ");
          $data_person = $_SESSION["data"]["personal"]["officer_degree"];
          $data_array = array($data_person["doctor"], $data_person["master"], $data_person["bachelor"], $data_person["none"]);
          $fnc_chartjs->gen_Chart_Bar('คุณวุฒิ สายสนับสนุน', $labels_array, $data_array, 'officer_degree_bar');
          ?>
        </div>
      </div>


      <?php //panel_personal_teacher_degree($_SESSION["data"]["personal"]); ?>
      <?php //panel_personal_teacher_position($_SESSION["data"]["personal"]); ?>
      <?php //panel_personal_officer_degree($_SESSION["data"]["personal"]); ?>

      <div class="row mt-4 d-none">
        <div class="col-lg-5 mb-lg-0 mb-4">
          <?php chart_sample(); ?>
        </div>
        <div class="col-lg-7">
          <?php line_chart_personal_retire(); ?>
        </div>
      </div>

      <?php include 'nav_footer.php'; ?>
    </div>
  </main>
  <!--   Core JS Files   -->
  <!-- <script src="../theme/assets/js/core/popper.min.js"></script> -->
  <!-- <script src="../theme/assets/js/core/bootstrap.min.js"></script> -->
  <!-- <script src="../node_modules/@popperjs/core/dist/cjs/popper.js"></script> -->
  <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="../theme/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../theme/assets/js/plugins/smooth-scrollbar.min.js"></script>


  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../theme/assets/js/soft-ui-dashboard.min.js"></script>
</body>

</html>