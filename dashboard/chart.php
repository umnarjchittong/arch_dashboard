<!DOCTYPE html>
<html lang="en">

<?php
include('../core.php');
$fnc = new CommonFnc;
$fnc_json = new Fnc_json_service;

include('main.php');


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
</head>

<body class="g-sidenav-show  bg-gray-100">
    <?php include 'nav_aside.php'; ?>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">

        <!-- Navbar -->
        <?php include 'nav_top.php'; ?>
        <!-- End Navbar -->

        <div class="container-fluid py-4">

            <div class="row mt-4">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-title p-3">
                            <h3 class="mb-1 pt-2 text-bold">sample bar chart.js</h3>
                        </div>
                        <div class="card-body p-3">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-title p-3">
                            <h3 class="mb-1 pt-2 text-bold">sample doughnut chart.js</h3>
                        </div>
                        <div class="card-body p-3">
                            <canvas id="myDoughnutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-5 mb-lg-0 mb-4">
                    chart bar
                </div>
                <div class="col-lg-7">
                    chart line
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
    <script src="../node_modules/chart.js/dist/chart.umd.js"></script>
    <script>
        const barchart = document.getElementById('myBarChart');
        const dataset_barchart = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [                    
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)'
                ],
                borderColor: [                    
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)'
                ],
                borderWidth: 1
            }]
        };
        new Chart(barchart, {
            type: 'bar',
            data: dataset_barchart,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const DoughnutChart = document.getElementById('myDoughnutChart');
        const dataset_DoughnutChart = {
            labels: [
                'Red',
                'Blue',
                'Yellow'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [                    
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)'
                ],
                borderColor: [                    
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        };
        new Chart(DoughnutChart, {
            type: 'doughnut',
            data: dataset_DoughnutChart,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <!-- <script src="../theme/assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script> -->
</body>

</html>