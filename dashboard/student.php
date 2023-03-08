<!DOCTYPE html>
<html lang="en">

<?php
include('../core.php');
$fnc = new CommonFnc;
$fnc_json = new Fnc_json_service;
$fnc_chartjs = new Fnc_ChartJS;

include('main.php');

if (!isset($_SESSION["data"]["student"]) || (isset($_GET["data_refresh"]) && $_GET["data_refresh"])) {
    $_SESSION["data"]["student"] = $fnc_json->json_read('../data/student.json');
}
$fnc->debug_console("student: ", $_SESSION["data"]["student"]);

function panel_student_amount($data_array = NULL)
{
    $fnc = new CommonFnc;
    $edu_year = $fnc->get_education_year();

?>
    <div class="row row-cols-4 mb-3">
        <?php panel_personal_info_card("น.ศ. ทั้งหมด", $data_array["studying"], number_format((($data_array["studying"] * 100) / $data_array["studying"]), 2) . "%", "ni ni-money-coins"); ?>
        <?php panel_personal_info_card("น.ศ. ป.ตรี", $data_array["bachelor"], number_format((($data_array["bachelor"] * 100) / $data_array["studying"]), 2) . "%", "ni ni-world"); ?>
        <?php panel_personal_info_card("น.ศ. ป.โท", $data_array["master"], number_format((($data_array["master"] * 100) / $data_array["studying"]), 2) . "%", "ni ni-world"); ?>
        <?php panel_personal_info_card("สำเร็จการศึกษา", $data_array["finish"][($edu_year-1)], "ปีการศึกษา " . ($edu_year-1), "ni ni-world"); ?>
    </div>
<?php
}

function panel_student_amount_by_bachelor($data_array = NULL)
{
    global $fnc;
    if (!is_array($data_array)) {
        $data_array = $_SESSION["data"]["student"];
    }
    $in_study = 3;
?>
    <div class="row row-cols-3 mb-3">
        <?php panel_personal_info_card($fnc->department_name["ar"], $data_array["bachelor_department"]["ar"], number_format((($data_array["bachelor_department"]["ar"] * 100) / $data_array["bachelor"]), 2) . "%", "ni ni-money-coins"); ?>
        <?php panel_personal_info_card($fnc->department_name["la"], $data_array["bachelor_department"]["la"], number_format((($data_array["bachelor_department"]["la"] * 100) / $data_array["bachelor"]), 2) . "%", "ni ni-money-coins"); ?>
        <?php panel_personal_info_card($fnc->department_name["lt"], ($data_array["bachelor_department"]["lt"] + $data_array["bachelor_department"]["lt2"]), number_format(((($data_array["bachelor_department"]["lt"] + $data_array["bachelor_department"]["lt2"]) * 100) / $data_array["bachelor"]), 2) . "%", "ni ni-money-coins"); ?>
    </div>
<?php
}

function panel_student_amount_by_master($data_array = NULL)
{
    global $fnc;
    if (!is_array($data_array)) {
        $data_array = $_SESSION["data"]["student"];
    }
    $in_study = 3;
?>
    <div class="row row-cols-2 mb-3">
        <?php panel_personal_info_card($fnc->department_name["murp"], $data_array["master_department"]["murp"], number_format((($data_array["master_department"]["murp"] * 100) / $data_array["master"]), 2) . "%", "ni ni-money-coins"); ?>
        <?php panel_personal_info_card($fnc->department_name["mep"], $data_array["master_department"]["mep"], number_format((($data_array["master_department"]["mep"] * 100) / $data_array["master"]), 2) . "%", "ni ni-money-coins"); ?>
    </div>
<?php
}

function panel_student_amount_by_department_ar($data_array = NULL)
{
    global $fnc;
    if (!is_array($data_array)) {
        $data_array = $_SESSION["data"]["student"];
    }
    $in_study = 3;
?>
    <div class="row row-cols-3 mb-3">
        <?php
        for ($i = 1; $i <= 5; $i++) {
            panel_personal_info_card($fnc->department["ar"] . " ปี " . $i, $data_array["bachelor_department"]["ar_year_" . $i], number_format((($data_array["bachelor_department"]["ar_year_" . $i] * 100) / $data_array["bachelor_department"]["ar"]), 2) . "%", "ni ni-money-coins");
        }
        panel_personal_info_card($fnc->department["ar"] . " ตกค้าง", $data_array["bachelor_department"]["ar_year_over"], number_format((($data_array["bachelor_department"]["ar_year_over"] * 100) / $data_array["bachelor_department"]["ar"]), 2) . "%", "ni ni-money-coins");
        ?>
    </div>
<?php
}
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
            <?php panel_student_amount($_SESSION["data"]["student"]); ?>

            <div class="row row-cols-md-1  row-cols-lg-2 mt-4 mb-4 g-4">
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ป.เอก", "ป.โท", "ป.ตรี");
                    $data_person = $_SESSION["data"]["student"];
                    $data_array = array($data_person["doctor"], $data_person["master"], $data_person["bachelor"]);
                    $fnc_chartjs->gen_Chart_Doughnut('สัดส่วนนักศึกษา', $labels_array, $data_array, 'student_degree2');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ป.เอก", "ป.โท", "ป.ตรี");
                    $data_person = $_SESSION["data"]["student"];
                    $data_array = array($data_person["doctor"], $data_person["master"], $data_person["bachelor"]);
                    $fnc_chartjs->gen_Chart_Bar('สัดส่วนนักศึกษา', $labels_array, $data_array, 'student_degree');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("สถาปัตยกรรม",  "ภูมิสถาปัตยกรรม",  "เทคโนโลยีภูมิทัศน์", "การออกแบบฯ", "การวางผังเมืองฯ");
                    $data_person = $_SESSION["data"]["student"];
                    $data_array = array($data_person["bachelor_department"]["ar"], $data_person["bachelor_department"]["la"], $data_person["bachelor_department"]["lt"], $data_person["master_department"]["mep"], $data_person["master_department"]["murp"]);
                    $fnc_chartjs->gen_Chart_Bar('นักศึกษาตามสาขา', $labels_array, $data_array, 'student_department');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 1",  "ปี 2",  "ปี 3", "ปี 4", "ปี 5", "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["bachelor_department"];
                    $data_array = array(
                        $data_person["ar_year_1"] + $data_person["la_year_1"] + $data_person["lt_year_1"],
                        $data_person["ar_year_2"] + $data_person["la_year_2"] + $data_person["lt_year_2"],
                        $data_person["ar_year_3"] + $data_person["la_year_3"] + $data_person["lt_year_3"] + $data_person["lt2_year_1"],
                        $data_person["ar_year_4"] + $data_person["la_year_4"] + $data_person["lt_year_4"] + $data_person["lt2_year_2"],
                        $data_person["ar_year_5"] + $data_person["la_year_5"],
                        $data_person["ar_year_over"] + $data_person["la_year_over"] + $data_person["lt_year_over"] + $data_person["lt2_year_over"]
                    );
                    $fnc_chartjs->gen_Chart_Bar('ป.ตรี ตามชั้นปี', $labels_array, $data_array, 'student_bachelor_yearly');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 1",  "ปี 2", "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["master_department"];
                    $data_array = array(
                        $data_person["murp_year_1"] + $data_person["mep_year_1"],
                        $data_person["murp_year_2"] + $data_person["mep_year_2"],
                        $data_person["murp_year_over"] + $data_person["mep_year_over"]
                    );
                    $fnc_chartjs->gen_Chart_Bar('ป.โท ตามชั้นปี', $labels_array, $data_array, 'student_master_yearly');
                    ?>
                </div>
            </div>

            <div class="row row-cols-md-1 row-cols-lg-2 mt-4 mb-4 g-4">
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 1",  "ปี 2",  "ปี 3", "ปี 4", "ปี 5", "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["bachelor_department"];
                    $data_array = array($data_person["ar_year_1"], $data_person["ar_year_2"], $data_person["ar_year_3"], $data_person["ar_year_4"], $data_person["ar_year_5"], $data_person["ar_year_over"]);
                    $fnc_chartjs->gen_Chart_Bar('สาขา' . $fnc->department_name["ar"], $labels_array, $data_array, 'student_department_ar');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 1",  "ปี 2",  "ปี 3", "ปี 4", "ปี 5", "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["bachelor_department"];
                    $data_array = array($data_person["la_year_1"], $data_person["la_year_2"], $data_person["la_year_3"], $data_person["la_year_4"], $data_person["la_year_5"], $data_person["la_year_over"]);
                    $fnc_chartjs->gen_Chart_Bar('สาขา' . $fnc->department_name["la"], $labels_array, $data_array, 'student_department_la');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 1",  "ปี 2",  "ปี 3", "ปี 4", "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["bachelor_department"];
                    $data_array = array($data_person["lt_year_1"], $data_person["lt_year_2"], $data_person["lt_year_3"], $data_person["lt_year_4"], $data_person["lt_year_over"]);
                    $fnc_chartjs->gen_Chart_Bar('สาขา' . $fnc->department_name["lt"], $labels_array, $data_array, 'student_department_lt');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 3", "ปี 4", "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["bachelor_department"];
                    $data_array = array($data_person["lt2_year_1"], $data_person["lt2_year_2"], $data_person["lt2_year_over"]);
                    $fnc_chartjs->gen_Chart_Bar('สาขา' . $fnc->department_name["lt"] . ' (ต่อเนื่อง)', $labels_array, $data_array, 'student_department_lt2');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 1",  "ปี 2",  "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["master_department"];
                    $data_array = array($data_person["murp_year_1"], $data_person["murp_year_2"], $data_person["murp_year_over"]);
                    $fnc_chartjs->gen_Chart_Bar('สาขา' . $fnc->department_name["murp"], $labels_array, $data_array, 'student_department_murp');
                    ?>
                </div>
                <div class="col mb-lg-0 mb-4">
                    <?php
                    $labels_array = array("ปี 1",  "ปี 2",  "ตกค้าง");
                    $data_person = $_SESSION["data"]["student"]["master_department"];
                    $data_array = array($data_person["mep_year_1"], $data_person["mep_year_2"], $data_person["mep_year_over"]);
                    $fnc_chartjs->gen_Chart_Bar('สาขา' . $fnc->department_name["mep"], $labels_array, $data_array, 'student_department_mep');
                    ?>
                </div>
            </div>

            <?php panel_student_amount_by_bachelor($_SESSION["data"]["student"]); ?>
            <?php panel_student_amount_by_master($_SESSION["data"]["student"]); ?>
            <?php panel_student_amount_by_department_ar($_SESSION["data"]["student"]); ?>

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
    <!-- <script src="../theme/assets/js/plugins/chartjs.min.js"></script> -->
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["1st", "2nd", "3rd", "4th", "5th", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#fff",
                    data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 15,
                            font: {
                                size: 14,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            display: false
                        },
                    },
                },
            },
        });


        var ctx2 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

        var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

        gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
        gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                        label: "Mobile apps",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#cb0c9f",
                        borderWidth: 3,
                        backgroundColor: gradientStroke1,
                        fill: true,
                        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                        maxBarThickness: 6

                    },
                    {
                        label: "Websites",
                        tension: 0.4,
                        borderWidth: 0,
                        pointRadius: 0,
                        borderColor: "#3A416F",
                        borderWidth: 3,
                        backgroundColor: gradientStroke2,
                        fill: true,
                        data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
                        maxBarThickness: 6
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#b2b9bf',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#b2b9bf',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
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
    <script src="../theme/assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>