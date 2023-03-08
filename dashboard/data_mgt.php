<?php

include_once('../core.php');
$fnc = new CommonFnc();
$jsonQ = new jsonQuery();

echo '<a href="?p=session_clear">clear sessoin</a> / <a href="?p=per_read">personal</a> / <a href="?p=std_read">student</a> / <a href="?p=kpi_read">KPI</a> / 
<a href="?p=fin_read">Finance</a> / <a href="?p=act_read">Activity</a> / <a href="?p=actstd_read">Activity Student</a> / <a href="?p=congrated_read">Congrate from ' . ($fnc->get_education_year() - 1) . '</a>
/ <a href="?p=retries_read">Retries</a><hr><br>';

if (isset($_GET["p"]) && $_GET["p"] == "json_table") {
    gen_json_table($_GET["api"]);
}

if (isset($_GET["p"]) && $_GET["p"] == "session_clear") {
    $_SESSION["data"] = array();
}

if (isset($_GET["p"]) && $_GET["p"] == "std_read") {
    if (!isset($_SESSION["data"]["personal"])) {
        $_SESSION["data"]["personal"] = "";
    }
    echo '<a href="?p=std_write">Write student data</a> / <a href="?p=std_update">Student update data</a>';
    $_SESSION["data"]["student"] = json_read('../data/student.json', true);
}
if (isset($_GET["p"]) && $_GET["p"] == "per_read") {
    echo '<a href="?p=per_write">Write personal data</a> / <a href="?p=per_update">Personal update data</a><hr><br>';
    $_SESSION["data"]["personal"] = json_read('../data/personal.json', true);
    $fnc->debug_console("session personal", $_SESSION["data"]["personal"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "kpi_read") {
    $_SESSION["data"]["kpi"] = json_read('../data/kpi.json');
    echo '<a href="?p=kpi_write">Write KPI data</a> / <a href="?p=kpi_update">update KPI data</a>';
    $fnc->debug_console("session KPI", $_SESSION["data"]["kpi"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "fin_read") {
    $_SESSION["data"]["finance"] = json_read('../data/finance.json');
    echo '<a href="?p=fin_write">Write finance data</a> / <a href="?p=fin_update">update finance data</a>';
    $fnc->debug_console("session finance", $_SESSION["data"]["finance"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "act_read") {
    $_SESSION["data"]["activity"] = json_read('../data/activity.json');
    echo '<a href="?p=act_write">Write activity data</a> / <a href="?p=act_update">update activity data</a>';
    $fnc->debug_console("session activity", $_SESSION["data"]["activity"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "actstd_read") {
    $_SESSION["data"]["activity_student"] = json_read('../data/activity_student.json');
    echo '<a href="?p=actstd_write">Write activity Student data</a> / <a href="?p=actstd_update">update activity Student data</a>';
    $fnc->debug_console("session activity_student", $_SESSION["data"]["activity_student"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "congrated_read") {
    $_SESSION["data"]["congrated_student"] = json_read('../data/congrated.json');
    echo '<a href="?p=congrated_write">Write congrated data</a> / <a href="?p=congrated_update">update congrated data</a>';
    $fnc->debug_console("session congrated_student", $_SESSION["data"]["congrated_student"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "retries_read") {
    $_SESSION["data"]["retries_student"] = json_read('../data/retries.json');
    echo '<a href="?p=retries_write">Write retries data</a> / <a href="?p=retries_update">update retries data</a>';
    $fnc->debug_console("session retries_student", $_SESSION["data"]["retries_student"]);
}

if (isset($_GET["p"]) && $_GET["p"] == "std_write") {
    json_write($_SESSION["data"]["students"], '../data/student.json', true);
}
if (isset($_GET["p"]) && $_GET["p"] == "per_write") {
    $fnc->debug_console("personal", $_SESSION["data"]["personals"]);
    json_write($_SESSION["data"]["personals"], '../data/personal.json', true);
}
if (isset($_GET["p"]) && $_GET["p"] == "kpi_write") {
    $fnc->debug_console("kpi", $_SESSION["data"]["kpi"]);
    json_write($_SESSION["data"]["kpi"], '../data/kpi.json', true);
}
if (isset($_GET["p"]) && $_GET["p"] == "fin_write") {
    $fnc->debug_console("finance", $_SESSION["data"]["finance"]);
    json_write($_SESSION["data"]["finance"], '../data/finance.json', true);
}

// if (isset($_GET["p"]) && $_GET["p"] == "std_write") {
//     json_write($_SESSION["data"]["students"], '../data/student.json', true);
// }
if (isset($_GET["p"]) && $_GET["p"] == "std_update") {
    $_SESSION["data"]["student"] = student_api_update();
    $fnc->debug_console("students", $_SESSION["data"]["student"]);
    // $_SESSION["data"]["students"] = student_api_student();
}
if (isset($_GET["p"]) && $_GET["p"] == "per_update") {
    $_SESSION["data"]["personal"] = personal_api_update();
    $fnc->debug_console("personal", $_SESSION["data"]["personal"]);
    // $_SESSION["data"]["personals"] = student_api_personal();
}
if (isset($_GET["p"]) && $_GET["p"] == "kpi_update") {
    $_SESSION["data"]["kpi"] = kpi_api_update();
    $fnc->debug_console("kpi", $_SESSION["data"]["kpi"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "fin_update") {
    $_SESSION["data"]["finance"] = fin_api_update();
    $fnc->debug_console("finance", $_SESSION["data"]["finance"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "act_update") {
    $_SESSION["data"]["activity"] = act_api_update();
    $fnc->debug_console("activity", $_SESSION["data"]["activity"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "actstd_update") {
    $_SESSION["data"]["activity_student"] = act_api_update();
    $fnc->debug_console("activity_student", $_SESSION["data"]["activity_student"]);
}
if (isset($_GET["p"]) && $_GET["p"] == "congrated_update") {
    $_SESSION["data"]["congrated"] = congrated_api_update(($fnc->get_education_year() - 1));
    $fnc->debug_console("congrated", $_SESSION["data"]["congrated"]);
}

function gen_json_table($api_url)
{
    $API = new MJU_API();
    $data_array = $API->GetAPI_array($api_url);
    // $data_array = $API->gen_array_filter($data_array, "statusName", "กำลังศึกษา");


    $col_title = array_keys($data_array[0]);
    echo "#row: " . count($data_array);
?>
    <div class="table-responsive">
        <table class="table table-primary table-bordered table-striped" style="font-size: 0.75em;">
            <thead>
                <tr>
                    <?php
                    echo '<th scope="col">#</th>';
                    foreach ($col_title as $col) {
                        echo '<th scope="col">' . $col . '</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $x = 0;
                foreach ($data_array as $row) {
                    $x++;
                    echo '<tr class="">';
                    echo '<td scope="row">' . $x . '</td>';
                    foreach ($col_title as $col) {
                        echo '<td>' . $row[$col] . '</td>';
                    }
                }
                ?>
                </tr>
            </tbody>
        </table>
    </div>


<?php
}

function student_api_update($year = null)
{
    global $fnc;
    $API = new MJU_API();
    $jsonQ = new jsonQuery();
    if (!$year) {
        $year = $fnc->get_education_year();
    }

    $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Faculty/19";
    $api_array = $API->GetAPI_array($api_url);

    // $api_array = $API->gen_array_filter($api_array, "statusName", "สำเร็จการศึกษา");
    // $data_array["finish"] = ($year - 1) . "," . count($API->GetAPI_array("https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/" . ($year - 1) . "/Faculty/19"));
    for ($i = ($year - 1); $i > ($year - 11); $i--) {
        // echo "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/" . ($i) . "/Faculty/19" . "<br>";
        $data_array["finish"][$i] = count($API->GetAPI_array("https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/" . ($i) . "/Faculty/19"));
        //  echo count($API->GetAPI_array("https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/" . ($i) . "/Faculty/19")) . "<br>";   
    }

    // $api_studying = $API->gen_array_filter($api_array, "statusName", "กำลังศึกษา");
    $api_studying = $jsonQ->where($api_array, "statusName = กำลังศึกษา");
    $data_array["studying"] = count($api_studying);
    // $data_array["bachelor"] = count($API->gen_array_filter($api_studying, "levelName", "ปริญญาตรี"));
    $data_array["bachelor"] = count($jsonQ->where($api_studying, "levelName = ปริญญาตรี"));

    // $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Program/" . $fnc->department["ar"];
    // $api_studying_ar = $API->gen_array_filter($API->GetAPI_array($api_url), "statusName", "กำลังศึกษา");
    $api_studying_ar = $jsonQ->where($api_studying, "programCode = " . $fnc->department["ar"]);
    $data_array["bachelor_department"]["ar"] = count($api_studying_ar);
    $year_over = $data_array["bachelor_department"]["ar"];
    for ($i = 1; $i <= $api_studying_ar[0]["studyYear"]; $i++) {
        // $data_array["bachelor_department"]["ar_year_" . $i] = count($API->gen_array_filter($api_studying_ar, "studentyear", $i));
        $data_array["bachelor_department"]["ar_year_" . $i] = count($jsonQ->where($api_studying_ar, "studentyear = " . $i));
        $year_over -= $data_array["bachelor_department"]["ar_year_" . $i];
    }
    $data_array["bachelor_department"]["ar_year_over"] = $year_over;

    // $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Program/" . $fnc->department["la"];
    // $api_studying_la = $API->gen_array_filter($API->GetAPI_array($api_url), "statusName", "กำลังศึกษา");
    $api_studying_la = $jsonQ->where($api_studying, "programCode = " . $fnc->department["la"]);
    $data_array["bachelor_department"]["la"] = count($api_studying_la);
    $year_over = $data_array["bachelor_department"]["la"];
    for ($i = 1; $i <= $api_studying_la[0]["studyYear"]; $i++) {
        // $data_array["bachelor_department"]["la_year_" . $i] = count($API->gen_array_filter($api_studying_la, "studentyear", $i));
        $data_array["bachelor_department"]["la_year_" . $i] = count($jsonQ->where($api_studying_la, "studentyear = " . $i));
        $year_over -= $data_array["bachelor_department"]["la_year_" . $i];
    }
    $data_array["bachelor_department"]["la_year_over"] = $year_over;

    // $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Program/" . $fnc->department["lt"];
    // $api_studying_lt = $API->gen_array_filter($API->GetAPI_array($api_studying), "statusName", "กำลังศึกษา");
    $api_studying_lt = $jsonQ->where($api_studying, "programCode = " . $fnc->department["lt"]);
    // $api_studying_lt4 = $API->gen_array_filter($api_studying_lt, "studyYear", "4");
    $api_studying_lt4 = $jsonQ->where($api_studying_lt, "studyYear = 4");
    $data_array["bachelor_department"]["lt"] = count($api_studying_lt4);
    $year_over = $data_array["bachelor_department"]["lt"];
    for ($i = 1; $i <= $api_studying_lt4[0]["studyYear"]; $i++) {
        // $data_array["bachelor_department"]["lt_year_" . $i] = count($API->gen_array_filter($api_studying_lt4, "studentyear", $i));
        $data_array["bachelor_department"]["lt_year_" . $i] = count($jsonQ->where($api_studying_lt4, "studentyear = " . $i));
        $year_over -= $data_array["bachelor_department"]["lt_year_" . $i];
    }
    $data_array["bachelor_department"]["lt_year_over"] = $year_over;

    // $api_studying_lt2 = $API->gen_array_filter($api_studying_lt, "studyYear", "2");
    $api_studying_lt2 = $jsonQ->where($api_studying_lt, "studyYear = 2");
    $data_array["bachelor_department"]["lt2"] = count($api_studying_lt2);
    $year_over = $data_array["bachelor_department"]["lt2"];
    for ($i = 1; $i <= $api_studying_lt2[0]["studyYear"]; $i++) {
        // $data_array["bachelor_department"]["lt2_year_" . $i] = count($API->gen_array_filter($api_studying_lt2, "studentyear", $i));
        $data_array["bachelor_department"]["lt2_year_" . $i] = count($jsonQ->where($api_studying_lt2, "studentyear = " . $i));
        $year_over -= $data_array["bachelor_department"]["lt2_year_" . $i];
    }
    $data_array["bachelor_department"]["lt2_year_over"] = $year_over;

    // $data_array["master"] = count($API->gen_array_filter($api_studying, "levelName", "ปริญญาโท"));
    $data_array["master"] = count($jsonQ->where($api_studying, "levelName = ปริญญาโท"));
    // $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Program/" . $fnc->department["murp"];
    // $api_studying_murp = $API->gen_array_filter($API->GetAPI_array($api_url), "statusName", "กำลังศึกษา");
    $api_studying_murp = $jsonQ->where($api_studying, "programCode = " . $fnc->department["murp"]);
    $data_array["master_department"]["murp"] = count($api_studying_murp);
    $year_over = $data_array["master_department"]["murp"];
    for ($i = 1; $i <= $api_studying_murp[0]["studyYear"]; $i++) {
        // $data_array["master_department"]["murp_year_" . $i] = count($API->gen_array_filter($api_studying_murp, "studentyear", $i));
        $data_array["master_department"]["murp_year_" . $i] = count($jsonQ->where($api_studying_murp, "studentyear = " . $i));
        $year_over -= $data_array["master_department"]["murp_year_" . $i];
    }
    $data_array["master_department"]["murp_year_over"] = $year_over;

    // $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Program/" . $fnc->department["mep"];
    // $api_studying_mep = $API->gen_array_filter($API->GetAPI_array($api_url), "statusName", "กำลังศึกษา");
    $api_studying_mep = $jsonQ->where($api_studying, "programCode = " . $fnc->department["mep"]);
    $data_array["master_department"]["mep"] = count($api_studying_mep);
    $year_over = $data_array["master_department"]["mep"];
    for ($i = 1; $i <=  $api_studying_mep[0]["studyYear"]; $i++) {
        // $data_array["master_department"]["mep_year_" . $i] = count($API->gen_array_filter($api_studying_mep, "studentyear", $i));
        $data_array["master_department"]["mep_year_" . $i] = count($jsonQ->where($api_studying_mep, "studentyear = " . $i));
        $year_over -= $data_array["master_department"]["mep_year_" . $i];
    }
    $data_array["master_department"]["mep_year_over"] = $year_over;

    // $data_array["doctor"] = count($API->gen_array_filter($api_studying, "levelName", "ปริญญาเอก"));
    $data_array["doctor"] = count($jsonQ->where($api_studying, "levelName = ปริญญาเอก"));


    echo '<a href="?p=std_read">Read student data</a>';
    echo "<h3>Data Array:</h3>";
    echo '<pre>';
    print_r($data_array);
    echo '</pre><hr>';
    // die();
    json_write($data_array, '../data/student.json', true);
    // $API->get_api_info("Student in Study", $api_url,true);
}

function personal_api_update()
{
    $API = new MJU_API();
    $jsonQ = new jsonQuery();

    $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";

    $api_array = $API->GetAPI_array($api_url);
    $data_array["personals"] = count($api_array);
    $data_array["on_education"] = count($jsonQ->where($api_array, "studyTypeName LIKE น"));

    $api_teacher = $jsonQ->where($api_array, "positionTypeId = ก");
    $data_array["teacher"] = count($api_teacher);
    $data_array["teacher_degree"]["doctor"] = count($jsonQ->where($api_teacher, "educationLevelId = 10"));
    $data_array["teacher_degree"]["master"] = count($jsonQ->where($api_teacher, "educationLevelId = 20"));
    $data_array["teacher_degree"]["bachelor"] = count($jsonQ->where($api_teacher, "educationLevelId = 30"));
    $data_array["teacher_degree"]["professor"] = count($jsonQ->where($api_teacher, "positionId = 004"));
    $data_array["teacher_degree"]["assoc_prof"] = count($jsonQ->where($api_teacher, "positionId = 003"));
    $data_array["teacher_degree"]["assist_prof"] = count($jsonQ->where($api_teacher, "positionId = 002"));
    $data_array["teacher_degree"]["teacher"] = count($jsonQ->where($api_teacher, "positionId = 001"));

    $api_officer = $jsonQ->where($api_array, "positionTypeId = ค");
    $data_array["officer"] = count($api_officer);
    $data_array["officer_degree"]["doctor"] = count($jsonQ->where($api_officer, "educationLevelId = 10"));
    $data_array["officer_degree"]["master"] = count($jsonQ->where($api_officer, "educationLevelId = 20"));
    $data_array["officer_degree"]["bachelor"] = count($jsonQ->where($api_officer, "educationLevelId = 30"));
    $data_array["officer_degree"]["under_bachelor"] = $data_array["officer"] - ($data_array["officer_degree"]["doctor"] + $data_array["officer_degree"]["master"] + $data_array["officer_degree"]["bachelor"]);

    $data_array["officer_degree"]["manager"] = count($jsonQ->where($api_officer, "positionLevelId = 26")); // ผอ
    $data_array["officer_degree"]["chief"] = count($jsonQ->where($api_officer, "positionLevel = หัวหน้างาน"));
    // $data_array["officer_degree"]["chief"] = $data_array["officer"] - $data_array["officer_degree"]["operating"] - $data_array["officer_degree"]["none"];
    $data_array["officer_degree"]["operating"] = count($jsonQ->where_or($api_officer, "positionLevel = ปฏิบัติการ OR positionLevel = ปฏิบัติงาน"));
    $data_array["officer_degree"]["none"] = count($jsonQ->where($api_officer, "positionLevelId = 0"));

    $data_array["personal_type"]["university_employee"] = count($jsonQ->where($api_officer, "personnelType = พนักงานมหาวิทยาลัย"));
    $data_array["personal_type"]["department_employee"] = count($jsonQ->where($api_officer, "personnelType = พนักงานส่วนงาน"));

    echo '<a href="?p=per_read">Read personal data</a>';
    echo "<h3>Personal Updated Array:</h3>";
    echo '<pre>';
    print_r($data_array);
    echo '</pre><hr>';

    json_write($data_array, '../data/personal.json', true);

    // $API->get_api_info("Student in Study", $api_url,true);
    return $data_array;
}

function kpi_api_update($year = null)
{
    $API = new MJU_API();
    if (!$year) {
        $year = 2566;

        for ($y = $year; $y >= 2564; $y--) {
            $api_url = "https://api.mju.ac.th/KPI/API/KPIMode14e89d1e7d4c39a482cf455c97ea60/Dimension/12/" . $y;
            $data_array[$y] = $API->GetAPI_array($api_url);

            for ($i = 0; $i < count($data_array[$y]); $i++) {
                $api_url = "https://api.mju.ac.th/KPI/API/KPIMode14e89d1e7d4c39a482cf455c97ea60/Group/12/" . $y . "/" . $data_array[$y][$i]["kpiDimensionID"];
                // echo $api_url . "<br>";
                $data_array[$y][$i]["KpiDimension"] = $API->GetAPI_array($api_url);

                for ($j = 0; $j < count($data_array[$y][$i]["KpiDimension"]); $j++) {
                    // echo "kpiGroupID: " . $data_array[$y][$i]["KpiDimension"][$j]["kpiGroupID"] . "<br>";
                    $api_url = "https://api.mju.ac.th/KPI/API/KPIMode14e89d1e7d4c39a482cf455c97ea60/12/" . $y . "/" . $data_array[$y][$i]["kpiDimensionID"] . "/" . $data_array[$y][$i]["KpiDimension"][$j]["kpiGroupID"];
                    // echo $api_url . "<br>";
                    $data_array[$y][$i]["KpiDimension"][$j]["kpiGroup"] = $API->GetAPI_array($api_url);
                }
            }
        }
    } else {

        $api_url = "https://api.mju.ac.th/KPI/API/KPIMode14e89d1e7d4c39a482cf455c97ea60/Dimension/12/" . $year;
        $data_array = $API->GetAPI_array($api_url);

        for ($i = 0; $i < count($data_array); $i++) {
            $api_url = "https://api.mju.ac.th/KPI/API/KPIMode14e89d1e7d4c39a482cf455c97ea60/Group/12/" . $year . "/" . $data_array[$i]["kpiDimensionID"];
            // echo $api_url . "<br>";
            $data_array[$i]["KpiDimension"] = $API->GetAPI_array($api_url);

            for ($j = 0; $j < count($data_array[$i]["KpiDimension"]); $j++) {
                // echo "kpiGroupID: " . $data_array[$i]["KpiDimension"][$j]["kpiGroupID"] . "<br>";
                $api_url = "https://api.mju.ac.th/KPI/API/KPIMode14e89d1e7d4c39a482cf455c97ea60/12/" . $year . "/" . $data_array[$i]["kpiDimensionID"] . "/" . $data_array[$i]["KpiDimension"][$j]["kpiGroupID"];
                // echo $api_url . "<br>";
                $data_array[$i]["KpiDimension"][$j]["kpiGroup"] = $API->GetAPI_array($api_url);
            }
        }
    }

    echo '<a href="?p=kpi_read">Read KPI data</a>';
    // echo '<hr><h3>DATA ARRAY</h3><pre>';
    // print_r($data_array);
    // echo '</pre>';

    json_write($data_array, '../data/kpi.json', true);

    return $data_array;
}

function fin_api_update($year = null)
{
    $API = new MJU_API();
    if (!$year) {
        $year = 2566;
    }

    $api_url = "https://api.mju.ac.th/Budget/API/BUDGET2985d4cfa2se84810b4c003d29fdff37923052020/" . $year . "/913";
    $data_array = $API->GetAPI_array($api_url);


    echo '<a href="?p=fin_read">Read Finance data</a>';
    echo '<hr><h3>DATA ARRAY</h3><pre>';
    print_r($data_array);
    echo '</pre>';

    json_write($data_array, '../data/finance.json', true);

    return $data_array;
}

function act_api_update($year = null)
{
    $API = new MJU_API();
    if (!$year) {
        $year = 2565;
    }

    $api_url = "https://api.mju.ac.th/Activity/API/ACTIVITY10ccf8b71be54adcbe1ac4462c07750e23052020/" . $year . "/303";
    $data_array = $API->GetAPI_array($api_url);


    echo '<a href="?p=fin_read">Read Activity data</a>';
    echo '<hr><h3>DATA ARRAY</h3><pre>';
    print_r($data_array);
    echo '</pre>';

    json_write($data_array, '../data/activity.json', true);

    return $data_array;
}

function act_student_api_update($year = null)
{
    $API = new MJU_API();
    if (!$year) {
        $year = 2565;
    }

    $api_url = "https://api.mju.ac.th/Activity/API/ACTIVITY10ccf8b71be54adcbe1ac4462c07750e23052020/Student/" . $year . "/303";
    $data_array = $API->GetAPI_array($api_url);


    echo '<a href="?p=actstd_read">Read Activity Student data</a>';
    echo '<hr><h3>DATA ARRAY</h3><pre>';
    print_r($data_array);
    echo '</pre>';

    json_write($data_array, '../data/activity.json', true);

    return $data_array;
}

function congrated_api_update($year = null)
{
    global $fnc;
    $API = new MJU_API();
    if (!$year) {
        $year = ($fnc->get_education_year() - 1);
    }

    for ($i = $year; $i >= ($year - 5); $i--) {
        $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/" . $i . "/Faculty/19";
        $data_array[$i] = count($API->GetAPI_array($api_url));

        foreach ($fnc->dept as $d) {
            $api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Grad/" . $i . "/Program/" . $fnc->department[$d];
            echo $api_url . " - " . $i . "/" . $d . "<br>";
            echo count($API->GetAPI_array($api_url)) . "<hr>";
            // $data_array[$i][$d] = count($API->GetAPI_array($api_url));
            // ! ***********************
        }
    }



    echo '<a href="?p=congrated_read">Read Congrated data</a>';
    echo '<hr><h3>DATA ARRAY</h3><pre>';
    print_r($data_array);
    echo '</pre>';

    json_write($data_array, '../data/activity.json', true);

    return $data_array;
}

function retries_api_update($year = null)
{
    global $fnc;
    $API = new MJU_API();

        $api_url = "https://api.mju.ac.th/Person/API/PERSON9486bba19bca462da44dc8ac447dea9723052020/Department/21000";
        $data_array = count($API->GetAPI_array($api_url));

        foreach ($data_array[0] as $person) {
            // $person
            
            
        }



    echo '<a href="?p=congrated_read">Read Congrated data</a>';
    echo '<hr><h3>DATA ARRAY</h3><pre>';
    print_r($data_array);
    echo '</pre>';

    json_write($data_array, '../data/activity.json', true);

    return $data_array;
}

function json_read($json_file, $display = false)
{
    global $fnc;

    // Read the JSON file 
    $json_text = file_get_contents($json_file);

    // Decode the JSON file
    $json_array = json_decode($json_text, true);
    // if (strpos($json_file, 'personal')) {        
    //     $json_array = $json_array["personals"];

    // } else if (strpos($json_file, 'student')) {
    //     $json_array = $json_array["students"];
    // } else if (strpos($json_file, 'kpi')) {
    //     $json_array = $json_array["kpi"];
    // } else if (strpos($json_file, 'finance')) {
    //     $json_array = $json_array["finance"];
    // }

    // $_SESSION["data"]["personal"] = $json_array;
    // $fnc->debug_console("student", $json_array);

    // Display data
    if ($display) {
        echo '<h3>read display</h3><pre>';
        print_r($json_array);
        echo '</pre>';
    }
    return $json_array;
}

function json_write($json_array, $json_file, $display = false)
{
    global $fnc;

    // Convert JSON data from an array to a string
    $json_text = json_encode($json_array, JSON_PRETTY_PRINT);
    // if (strpos($json_file, 'personal')) {
    //     $json_text = '{
    //         "personals": ' . $json_text . '
    //     }';
    // } else if (strpos($json_file, 'student')) {
    //     $json_text = '{
    //         "students": ' . $json_text . '
    //     }';
    // }

    // Write in the file
    $fp = fopen($json_file, 'w');
    fwrite($fp, $json_text);
    fclose($fp);

    // Display data
    if ($display) {
        echo '<h3>writed</h3>';
        echo '<pre>';
        print_r($json_text);
        echo '</pre>';
    } else {
        return $json_text;
    }
}

echo '<hr><h3>SESSION DATA</h3><pre>';
print_r($_SESSION["data"]);
echo '</pre>';
