<style>
    .nav-link>.bi {
        color: dark;
    }

    .nav-link .active .bi {
        color: white;
    }
</style>
<?php
function aside_gen_menu_item($label = "Dashboard", $icon = "bi bi-house", $url_path = "../dashboard/", $url_filename = "")
{
    $fnc = new CommonFnc();
    $activate = '';
    $icon .= ' text-dark';
    if ($fnc->get_url_filename() == $fnc->get_url_filename($url_filename)) {
        $activate = ' active';
        $icon .= ' text-white';
    }
?>
    <li class="nav-item">
        <a class="nav-link<?= $activate; ?>" href="<?= $url_path . $url_filename ?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="<?= $icon ?> fs-6"></i>
            </div>
            <span class="nav-link-text ms-1"><?= $label ?></span>
        </a>
    </li>
<?php
}
?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html" target="_blank">
            <img src="../assets/img/favicon-96x96.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Arch Dashboard</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <?php aside_gen_menu_item("Dashboard", "bi bi-house", "../dashboard/", "index.php"); ?>
            <?php aside_gen_menu_item("KPI's", "bi bi-speedometer", "../dashboard/", "kpi.php?y=" . $fnc->get_fiscal_year() . "&dimension=4"); ?>
            <?php aside_gen_menu_item("บุคลากร", "bi bi-person-square", "../dashboard/", "personal.php"); ?>
            <?php aside_gen_menu_item("การเงิน", "bi-currency-bitcoin", "../dashboard/", "finance.php"); ?>
            <?php aside_gen_menu_item("งานวิจัย/บทความ", "bi-book", "../dashboard/", "research.php"); ?>
            <?php aside_gen_menu_item("กิจกรรมคณะ", "bi-book", "../dashboard/", "activity.php"); ?>
            <?php aside_gen_menu_item("นักศึกษา", "bi-mortarboard-fill", "../dashboard/", "student.php"); ?>
            <?php aside_gen_menu_item("กิจกรรม น.ศ.", "bi-book", "../dashboard/", "student_activity.php"); ?>            
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Sample pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link  " href="../theme/pages/profile.html" target="_blank">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(1.000000, 0.000000)">
                                            <path class="color-background opacity-6" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"></path>
                                            <path class="color-background" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                                            <path class="color-background" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  " href="../dashboard/chart.php" target="_blank">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(1.000000, 0.000000)">
                                            <path class="color-background opacity-6" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"></path>
                                            <path class="color-background" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                                            <path class="color-background" d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Chart.js</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpeg')"></div>
            <div class="card-body text-start p-3 w-100">
                <div class="docs-info">
                    <h6 class="text-white up mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold">Please contact</p>
                    <a href="https://m.me/umnarj" target="_blank" class="btn btn-white btn-sm w-100 mb-0">fb/umnarj</a>
                </div>
            </div>
        </div>
    </div>
</aside>