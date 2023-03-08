<!DOCTYPE html>
<html lang="en">
<?php
include '../core.php';
$fnc = new CommonFnc;
$db = new database;
$API = new MJU_API;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API CONNECTION</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="../node_modules/@popperjs/core/dist/cjs/popper.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</head>

<body>
    <h1>API DATA CONNECTION</h1>

    <div class="container">

        <?php
        $department = array("ar" => "1904", "la" => "1901", "lt" => "1902", "mep" => "1903", "murp" => "1905");
        // $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Faculty/19";
        // $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";
        // $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/2564/Program/1904";
        $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/2564/Program/";
        // $API->get_api_info("Student in Study", $api_url, true);

        get_api_info("https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/2564/Faculty/19", "ผู้สำเร็จการศึกษาปี 2564");

        $data_array = $API->GetAPI_array("https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/2564/Faculty/19");
        $data_array = $API->gen_array_filter_instr($data_array, "programNameTh", "ทัศน์");

        echo '<pre>';
        print_r($data_array);
        echo '</pre>';

        $i = 0;
        foreach ($department as $dept) {
            get_api_info($api_url . $dept, array_keys($department)[$i]);
            $i++;
        }

        function get_api_info($api_url, $title, $display = false)
        {
            global $API;

            $API->get_api_info($title, $api_url, $display);

            // $data_array = $API->GetAPI_array($api_url);

            // echo '<pre>';
            // print_r($data_array);
            // echo '</pre>';
        }

        $api_url= "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/2565/Faculty/12";
        $API->get_api_info("ECON", $api_url);




        ?>
    </div>

</body>

</html>