<!DOCTYPE html>
<html lang="en">

<?php
include('../core.php');
$fnc = new CommonFnc;
$fnc_json = new Fnc_json_service;
$fnc_chartjs = new Fnc_ChartJS;
$jsonQ = new jsonQuery();

include('main.php');

if (!isset($_SESSION["data"]["research"]) || (isset($_GET["data_refresh"]) && $_GET["data_refresh"])) {
    $_SESSION["data"]["research"] = $fnc_json->json_read('../data/research.json');
}
$fnc->debug_console("Research: ", $_SESSION["data"]["research"]);

function gen_tbl($array_data)
{
    global $fnc;
    $jsonQ = new jsonQuery();
    // echo 'kpi_dimension<pre>';
    // print_r($kpi_dimension);
    // echo '</pre>';
?>
    <table class="table align-items-center mb-3">
        <thead>
            <tr>
                <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-6">#</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-6">งานวิจัย</th>
                <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-6 d-none d-lg-table-cell">ระยะเวลาวิจัย</th>
            </tr>
        </thead>
        <tbody class="mb-5">
            <?php
            $x = 0;
            foreach ($array_data as $row) {
                $x++;
            ?>
                <tr>
                    <td class="text-center align-top fw-bold pt-3">
                        <?= $x ?>
                    </td>
                    <td class="align-top text-wrap pt-3">
                        <div class="px-2 py-1">
                            <h6 class="mb-0 text-sm fw-normal"><span class="fw-bold"><?= $row["mjuCode"] ?></span><br><?= $row["nameTh"] ?></h6>
                        </div>
                    </td>
                    <td class="text-sm align-top text-nowrap pt-3 d-none d-lg-table-cell">
                        <span class="text-xs"><?= $fnc->gen_date_range_semi_th($row["startedDate"], $row["endedDate"]) ?></span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
}

function gen_data_table()
{
    $fnc = new CommonFnc();
    $jsonQ = new jsonQuery();
    global $year;
    // echo '<pre>';
    // print_r($data_array);
    // echo '</pre>';


?>
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-6 mt-2">
                    <h5>งานวิจัย ตามปีงบประมาณที่ได้รับเงินสนับสนุน <span class="font-weight-bold ms-1">ปีงบประมาณ <?= $year ?></span></h5>
                </div>
                <div class="col-lg-6 col-6 my-auto text-end">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group me-3">
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle p-2 pe-4 fs-6 fw-normal" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                <?= 'ปีงบประมาณ ' . $year; ?>
                            </button>
                            <!-- <a class="cursor-pointer dropdown-toggle" id="dropdownTable" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a> -->
                            <ul class="dropdown-menu dropdown-menu-lg-end shadow">
                                <?php
                                for ($f = $fnc->get_fiscal_year(); $f >= ($fnc->get_fiscal_year() - 5); $f--) {
                                    echo '
                                <li><a class="dropdown-item border-radius-md';
                                    if (isset($_GET["y"]) && $f == $_GET["y"]) {
                                        echo ' active" aria-current="true';
                                    }
                                    echo '" href="?y=' . $f . '">ปีงบประมาณ ' . $f . '</a></li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body px-2 pb-2">

            <?php
            if (array_key_exists($year, $_SESSION["data"]["research"])) {
                $data_array = $_SESSION["data"]["research"][$year];
                gen_tbl($data_array);
            } else {
                echo '<h3 class="text-center text-primary opacity-7 py-5">- ไม่พบข้อมูล -</h3>';
            }
            ?>
        </div>
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

            <?php
            // $y = 2564;
            if (isset($_GET["y"]) && $_GET["y"] != '') {
                $year = $_GET["y"];
            } else {
                $year = $fnc->get_fiscal_year();
            }
            // $data_kpi = $_SESSION["data"]["research"][$fiscal];
            // $data_research = $jsonQ->where($_SESSION["data"]["research"], "endedYear = " . $year);
            // if (array_key_exists($year, $_SESSION["data"]["research"])) {                
            echo '<div class="my-4">';
            gen_data_table();
            echo '</div>';
            // }


            // echo '<h1>ปีงบประมาณ ' . $y . '</h1>';
            // foreach ($data_kpi as $kpi) {
            //     echo "<h3>" . $kpi["name"] . "</h3><hr>";
            //     foreach ($kpi["KpiDimension"] as $KpiDimension) {
            //         echo "<h5 style='padding-left: 2em;'>" . $KpiDimension["name"] . "</h5><hr>";
            //         foreach ($KpiDimension["kpiGroup"] as $kpiGroup) {
            //             echo "<p style='padding-left: 5em;'>" . $kpiGroup["name"] . " (" . $kpiGroup["result"] . "/" . $kpiGroup["goal"] . ")" . " weight: " . $kpiGroup["weight"] . "</p><hr>";
            //         }
            //     }
            // }


            // if (!isset($_GET["dimension"]) || $_GET["dimension"] == "") {
            //     echo '<div class="mt-5 py-5"></div>';
            // }

            ?>

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
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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
    <script src="../theme/assets/js/soft-ui-dashboard.min.js"></script>
</body>

</html>