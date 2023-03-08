<!DOCTYPE html>
<?php
// include ('../core.php');
// $fnc = new CommonFnc();
// $API = new MJU_API;


include ('json_engine.php');
$jsonQuery = new jsonQuery();

$api_url = "https://api.mju.ac.th/Student/API/STUDENTe8ee4f3759cc4763a8f231965a2da6db23052020/Faculty/19";
$jsonData = $jsonQuery->get($api_url);

$jsonQuery->info_url($api_url);
echo "<br><hr><br>";
$jsonQuery->info_array($jsonData);

$jsonData = $jsonQuery->where_or($jsonData, "programCode = 1901 OR programCode = 1904");
$jsonQuery->info_array($jsonData);
$jsonData = $jsonQuery->where_and($jsonData, "status >= 10 AND studentyear = 4");
$jsonQuery->info_array($jsonData);
$jsonData = $jsonQuery->where($jsonData, "status >= 60");
$jsonQuery->info_array($jsonData);
$jsonQuery->gen_table_array($jsonData);


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php



?>
    
</body>
</html>