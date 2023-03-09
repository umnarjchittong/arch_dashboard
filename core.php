<?php
session_start();
$_SESSION['coding_indent'] = 0;

ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');

class Constants
{
    public $system_name = "ARCH DASHBOARD";
    public $system_org = "Arch@Maejo University";
    public $system_version = 'Alpha 01';
    public $system_path = '/dev/arch_dashboard/';
    public $system_debug = true;
    public $database_sample = false;
    public $system_meta_refresh = 0; // default 3
    public $month_name = array(1 => "ม.ค.", 2 => "ก.พ.", 3 => "มี.ค.", 4 => "เม.ย.", 5 => "พ.ค.", 6 => "มิ.ย.", 7 => "ก.ค.", 8 => "ส.ค.", 9 => "ก.ย.", 10 => "ต.ค.", 11 => "พ.ย.", 12 => "ธ.ค.");
    public $month_fullname = array(1 => "มกราคม", 2 => "กุมภาพันธ์", 3 => "มีนาคม", 4 => "เมษายน", 5 => "พฤษภาคม", 6 => "มิถุนายน", 7 => "กรกฎาคม", 8 => "สิงหาคม", 9 => "กันยายน", 10 => "ตุลาคม", 11 => "พฤศจิกายน", 12 => "ธันวาคม");
    public $auth_lv = array("1" => "guest", "3" => "Member", "5" => "board", "7" => "officer", "9" => "developer");
    public $list_limit = 20;
    public $dept = array("ar", "la", "lt", "mep", "murp");
    public $department = array("ar" => "1904", "la" => "1901", "lt" => "1902", "mep" => "1903", "murp" => "1905");
    public $department_name = array("ar" => "สถาปัตยกรรม", "la" => "ภูมิสถาปัตยกรรม", "lt" => "เทคโนโลยีภูมิทัศน์", "mep" => "การออกแบบและวางแผนสิ่งแวดล้อม", "murp" => "การวางผังเมืองและสภาพแวดล้อม");

    // chart configured
    public $chart_bg_color = array(
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(201, 203, 207, 0.2)',
        'rgba(255, 205, 86, 0.2)'
    );
    public $chart_bd_color = array(
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(255, 159, 64)',
        'rgb(255, 99, 132)',
        'rgb(201, 203, 207)',
        'rgb(255, 205, 86)'
    );
}

class CommonFnc extends Constants
{
    public function debug_console($val1, $val2 = null)
    {
        if ($this->system_debug || $_SESSION["ics_member"]["auth_lv"] <= 9) {
            if (is_array($val1)) {
                // $val1 = implode(',', $val1);
                $val1 = str_replace(
                    chr(34),
                    '',
                    json_encode($val1, JSON_UNESCAPED_UNICODE)
                );
                $val1 = str_replace(chr(58), chr(61), $val1);
                $val1 = str_replace(chr(44), ', ', $val1);
                $val1 = 'Array:' . $val1;
            }
            if (is_array($val2)) {
                // $val2 = implode(',', $val2);
                $val2 = str_replace(
                    chr(34),
                    '',
                    json_encode($val2, JSON_UNESCAPED_UNICODE)
                );
                $val2 = str_replace(chr(58), chr(61), $val2);
                $val2 = str_replace(chr(44), ', ', $val2);
                $val2 = 'Array:' . $val2;
            }
            if (isset($val1) && isset($val2) && !is_null($val2)) {
                echo '<script>console.log("' .
                    $val1 .
                    '\\n' .
                    $val2 .
                    '");</script>';
            } else {
                echo '<script>console.log("' . $val1 . '");</script>';
            }
        }
    }

    public function get_client_info()
    {
        $data = array();
        foreach ($_SERVER as $key => $value) {
            // $data .= '$_SERVER["' . $key . '"] = ' . $value . '<br />';
            array_push($data, '$_SERVER["' . $key . '"] = ' . $value);
        }
        return $data;
    }

    public function get_page_info($parameter = null)
    {
        if (!$parameter) {
            $indicesServer = [
                'PHP_SELF',
                'argv',
                'argc',
                'GATEWAY_INTERFACE',
                'SERVER_ADDR',
                'SERVER_NAME',
                'SERVER_SOFTWARE',
                'SERVER_PROTOCOL',
                'REQUEST_METHOD',
                'REQUEST_TIME',
                'REQUEST_TIME_FLOAT',
                'QUERY_STRING',
                'DOCUMENT_ROOT',
                'HTTP_ACCEPT',
                'HTTP_ACCEPT_CHARSET',
                'HTTP_ACCEPT_ENCODING',
                'HTTP_ACCEPT_LANGUAGE',
                'HTTP_CONNECTION',
                'HTTP_HOST',
                'HTTP_REFERER',
                'HTTP_USER_AGENT',
                'HTTPS',
                'REMOTE_ADDR',
                'REMOTE_HOST',
                'REMOTE_PORT',
                'REMOTE_USER',
                'REDIRECT_REMOTE_USER',
                'SCRIPT_FILENAME',
                'SERVER_ADMIN',
                'SERVER_PORT',
                'SERVER_SIGNATURE',
                'PATH_TRANSLATED',
                'SCRIPT_NAME',
                'REQUEST_URI',
                'PHP_AUTH_DIGEST',
                'PHP_AUTH_USER',
                'PHP_AUTH_PW',
                'AUTH_TYPE',
                'PATH_INFO',
                'ORIG_PATH_INFO',
            ];

            // $data = '<table cellpadding="10">';
            $val = "page info : \\n";
            foreach ($indicesServer as $arg) {
                if (isset($_SERVER[$arg])) {
                    // $data .= '<tr><td>' .
                    //     $arg .
                    //     '</td><td>' .
                    //     $_SERVER[$arg] .
                    //     '</td></tr>';
                    // $this->debug_console($arg . " = " . $_SERVER[$arg]);
                    $val .= $arg . ' = ' . $_SERVER[$arg] . "\\n";
                } else {
                    // $data .= '<tr><td>' . $arg . '</td><td>-</td></tr>';
                    // $this->debug_console($arg . " = -");
                    $val .= $arg . ' = -' . "\\n";
                }
            }
            // $data .= '</table>';            
            $this->debug_console($val);
            return $val;
        } else {
            switch ($parameter) {
                case 'dev_site':
                    if (strripos($_SERVER['PHP_SELF'], 'dev/')) {
                        $data = true;
                    } else {
                        $data = false;
                    }
                    // $this->debug_console("this file name = " . $data);
                    return $data;
                    break;
                case 'thisfilename':
                    if (strripos($_SERVER['PHP_SELF'], '/')) {
                        $data = substr(
                            $_SERVER['PHP_SELF'],
                            strripos($_SERVER['PHP_SELF'], '/') + 1
                        );
                    } else {
                        $data = substr(
                            $_SERVER['PHP_SELF'],
                            strripos($_SERVER['PHP_SELF'], '/')
                        );
                    }
                    // $this->debug_console("this file name = " . $data);
                    return $data;
                    break;
                case 'parameter':
                    if (strripos($_SERVER['REQUEST_URI'], '?')) {
                        parse_str(
                            substr(
                                $_SERVER['REQUEST_URI'],
                                strripos($_SERVER['REQUEST_URI'], '?') + 1
                            ),
                            $data
                        );
                    } else {
                        parse_str(substr($_SERVER['REQUEST_URI'], 0), $data);
                    }
                    // print_r($data);
                    return $data;
                    break;
            }
        }
    }

    public function get_url_filename($val = true)
    {
        if ($val === true) {
            $val = $_SERVER['PHP_SELF'];
        }
        if (isset($val)) {
            if (strpos($val, '?')) {
                $val = substr($val, 0, strpos($val, '?'));
            }

            if (stristr($val, '/')) {
                $val = substr($val, strripos($val, '/') + 1);
            } else {
                $val = substr($val, strripos($val, '/'));
            }
            return $val;
        }
    }

    public function get_url_parameter($val = true, $data_array = false)
    {
        if ($val === true) {
            $val = $_SERVER['REQUEST_URI'];
        }
        if (isset($val) && stristr($val, '?')) {
            if (isset($data_array) && $data_array === true) {
                parse_str(substr($val, strpos($val, '?') + 1), $data);
                // print_r($data);
            } else {
                $data = substr($val, strpos($val, '?') + 1);
            }
            return $data;
        }
    }

    public function get_time_th($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = getdate(date("U"));
        }
        return $current_date["hours"] . ":" . $current_date["minutes"] . ":" . $current_date["seconds"] . " น.";
    }

    /**
     * It takes a date in the format of YYYY-MM-DD and returns a date in the format of DD MMM YY
     * 
     * @param current_date The date you want to convert. If you don't specify it, it will use the current
     * date.
     */
    public function get_date_semi_th($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        echo date("j", strtotime($current_date));
        echo " ";
        echo $this->month_name[(int) date("m", strtotime($current_date))];
        echo " ";
        echo substr((date("Y", strtotime($current_date)) + 543), 2);
    }

    /**
     * It takes a start date and an end date and returns a string that represents the date range in a
     * semi-thai format
     * 
     * @param start_date The start date of the event
     * @param end_date The end date of the range.
     */
    public function gen_date_range_semi_th($start_date, $end_date = "")
    {
        // echo date("M j, Y", strtotime($start_date));
        if (empty($end_date) || $end_date <= 0) {
            echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
        } else {
            if (date("Y", strtotime($start_date)) == date("Y", strtotime($end_date))) {
                if (date("n", strtotime($start_date)) == date("n", strtotime($end_date))) {
                    if (date("j", strtotime($start_date)) == date("j", strtotime($end_date))) {
                        echo date("j ", strtotime($start_date)) . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
                    } else {
                        echo date("j", strtotime($start_date)) . date("-j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
                    }
                } else {
                    echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " - " . date("j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543);
                }
            } else {
                echo date("j", strtotime($start_date)) . " " . $this->month_name[date("n", strtotime($start_date))] . " " . (date("Y", strtotime($start_date)) + 543) . " - " . date("j", strtotime($end_date)) . " " . $this->month_name[date("n", strtotime($end_date))] . " " . (date("Y", strtotime($end_date)) + 543);
            }
        }
    }

    public function gen_date_semi_en($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        echo date("M j, Y", strtotime($current_date));
    }

    public function gen_date_range_semi_en($start_date, $end_date = "")
    {
        // echo date("M j, Y", strtotime($start_date));
        if (empty($end_date) || $end_date <= 0) {
            echo date("M j, Y", strtotime($start_date));
        } else {
            if (date("Y", strtotime($start_date)) == date("Y", strtotime($end_date))) {
                if (date("n", strtotime($start_date)) == date("n", strtotime($end_date))) {
                    if (date("j", strtotime($start_date)) == date("j", strtotime($end_date))) {
                        echo date("M j, Y", strtotime($start_date));
                    } else {
                        echo date("M j", strtotime($start_date)) . date("-j,", strtotime($end_date)) . date(" Y", strtotime($start_date));
                    }
                } else {
                    echo date("M j", strtotime($start_date)) . date("-M j,", strtotime($end_date)) . date(" Y", strtotime($start_date));
                }
            } else {
                echo date("M j, Y", strtotime($start_date)) . date("-M j, Y", strtotime($end_date));
            }
        }
    }

    public function get_date_full_thai($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        $data = date("j", strtotime($current_date));
        $data .= " ";
        $data .= $this->month_fullname[(int) date("m", strtotime($current_date))];
        $data .= " ";
        $data .= (date("Y", strtotime($current_date)) + 543);
        return $data;
    }

    public function gen_date_full_thai($current_date = NULL)
    {
        if (!isset($current_date)) {
            $current_date = date("Y-m-d");
        }
        echo date("j", strtotime($current_date));
        echo " ";
        echo $this->month_fullname[(int) date("m", strtotime($current_date))];
        echo " ";
        echo (date("Y", strtotime($current_date)) + 543);
    }

    public function get_fiscal_year($date = NULL)
    {
        if ($date == NULL) {
            $date = date('Y-m-d H:i:s');
        }
        // echo "date= " . $date;
        // echo ", month= " . $date_m = date("m", strtotime($date));
        // echo ", year= " . $date_y = (date("Y", strtotime($date))+543);
        if (date("m", strtotime($date)) >= 10) {
            return (date("Y", strtotime($date)) + 543) + 1;
        }
        return (date("Y", strtotime($date)) + 543);
    }

    public function get_education_year($date = NULL)
    {
        if ($date == NULL) {
            $date = date('Y-m-d H:i:s');
        }
        // echo "date= " . $date;
        // echo ", month= " . $date_m = date("m", strtotime($date));
        // echo ", year= " . $date_y = (date("Y", strtotime($date))+543);
        if (date("m", strtotime($date)) >= 6) {
            return (date("Y", strtotime($date)) + 543);
        }
        return (date("Y", strtotime($date)) + 543) - 1;
    }

    // public function gen_alert($alert_sms, $alert_title = 'Alert!!', $alert_style = 'danger')
    // {
    //     // echo '<div class="app-wrapper">';
    //     echo '<div class="container col-12 mt-3">';
    //     // echo '<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">';
    //     echo '<div class="alert alert-' . $alert_style . ' alert-dismissible fade show" role="alert">';
    //     echo '<div class="inner">';
    //     echo '<div class="app-card-body p-3 p-lg-4">';
    //     echo '<h3 class="mb-3 text-' .
    //         $alert_style .
    //         '">' .
    //         $alert_title .
    //         '</h3>';
    //     echo '<div class="row gx-5 gy-3">';
    //     echo '<div class="col-12">';
    //     echo '<div class="text-center">' . $alert_sms . '</div>';
    //     echo '</div>';
    //     echo '</div>';
    //     echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    //     echo '</div>';
    //     echo '</div>';
    //     echo '</div>';
    //     echo '</div>';
    //     // echo '</div>';
    //     $this->debug_console($alert_sms);
    // }

    // public function get_alert($method)
    // {
    //     switch ($method) {
    //         case "replied":
    //             $this->gen_alert("ทำการส่งอีเมลตอบกลับเรียบร้อย.", "Email Sent", "info");
    //     }
    // }

    public function date_diff($date1)
    {
        $date1 = date_create($date1);
        $date2 = date_create(date("Y") . "-" . date("m") . "-" . date("d"));
        $diff = date_diff($date2, $date1);
        //echo $diff->format("%R%a days");
        //        $this->debug_console($diff->format("%R%a"));
        if ($diff->format("%R%a") < 0) {
            //            $this->debug_console("false");
            // return false;
        } else {
            // $this->debug_console("true: " . $diff->format("%R%a"));
            //            $this->debug_console("true");
            // return $diff->format("%R%a");
            return true;
        }
    }

    public function get_time_ago($time)
    {
        $time_difference = time() - $time;

        if ($time_difference < 1) {
            return 'less than 1 second ago';
        }
        // $condition = array(
        //     12 * 30 * 24 * 60 * 60 =>  'year',
        //     30 * 24 * 60 * 60       =>  'month',
        //     24 * 60 * 60            =>  'day',
        //     60 * 60                 =>  'hour',
        //     60                      =>  'minute',
        //     1                       =>  'second'
        // );
        $condition = array(
            12 * 30 * 24 * 60 * 60 =>  'yr',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hr',
            60                      =>  'min',
            1                       =>  'sec'
        );

        foreach ($condition as $secs => $str) {
            $d = $time_difference / $secs;

            if ($d >= 1) {
                $t = round($d);
                // return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
                return '' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
            }
        }
    }

    public function gen_titlePosition_short($titlePosition)
    {
        $titlePosition = str_replace('รองศาสตราจารย์ ', 'รศ.', $titlePosition);
        $titlePosition = str_replace('รองศาสตราจารย์', 'รศ.', $titlePosition);
        $titlePosition = str_replace('ผู้ช่วยศาสตราจารย์ ', 'ผศ.', $titlePosition);
        $titlePosition = str_replace('ผู้ช่วยศาสตราจารย์', 'ผศ.', $titlePosition);
        $titlePosition = str_replace('ศาสตราจารย์ ', 'ศ.', $titlePosition);
        $titlePosition = str_replace('ศาสตราจารย์', 'ศ.', $titlePosition);
        $titlePosition = str_replace('อาจารย์ ', 'อ.', $titlePosition);
        $titlePosition = str_replace('อาจารย์', 'อ.', $titlePosition);
        return trim($titlePosition);
    }

    // text file
    function read_logs()
    {
        $fp = 'logs.txt';
        // echo $fp;
        if (file_exists($fp)) {
            $file = fopen($fp, "r");
            $json_text = fread($file, filesize($fp));
            fclose($file);

            // echo "<h3>array:</h3><hr>";
            $json_text = '[' . $json_text . ']';
            $json_text = json_decode($json_text, true);
            // print_r($json_text);

            // extract($json_text);
            return $json_text;
        }
    }

    function write_logs($username, $method, $val = "")
    {
        $json_text = ',
    {
        "datetime":"' . date("d/m/Y H:i:s") . '",
        "username":"' . $username . '",
        "method":"' . $method . '",
        "value":"' . $val . '"
     }';

        $fp = 'logs.txt';

        $file = fopen($fp, "a");
        fwrite($file, $json_text);
        fclose($file);
    }

    function read_default_config($fp)
    {
        $fp = "profile/" . $fp;


        $file = fopen($fp, "r");
        $json_text = fread($file, filesize($fp));
        fclose($file);

        // echo "<h3>array:</h3><hr>";
        $json_text = json_decode($json_text, true);
        // print_r($json_text);

        // extract($json_text);
        return $json_text;
    }

    function write_default_config($fp, $json_text)
    {
        $fp = "profile/" . $fp;
        // $json_text = json_encode($json_text);

        $file = fopen($fp, "w");
        fwrite($file, $json_text);
        fclose($file);
    }

    function read_form5($fp)
    {
        $fp = "../data/" . $fp;


        $file = fopen($fp, "r");
        $json_text = fread($file, filesize($fp));
        fclose($file);

        // echo "<h3>array:</h3><hr>";
        $json_text = json_decode($json_text, true);
        // print_r($json_text);

        // extract($json_text);
        return $json_text;
    }

    function write_form5($fp, $json_text)
    {
        $fp = "../data/" . $fp;
        // $json_text = json_encode($json_text);
        if (file_exists($fp)) {
            $json_text = ',
            ' . $json_text;
        }

        $file = fopen($fp, "a");
        fwrite($file, $json_text);
        fclose($file);
    }

    function upload_image($files, $path = "umnarj/", $overwrite = false, $filesize = null)
    {
        $target_dir = "uploads/signature/";
        $target_file = $target_dir . basename($_FILES["signature"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        // if (isset($_POST["submit"])) {
        //     $check = getimagesize($_FILES["signature"]["tmp_name"]);
        //     if ($check !== false) {
        //         echo "File is an image - " . $check["mime"] . ".";
        //         $uploadOk = 1;
        //     } else {
        //         echo "File is not an image.";
        //         $uploadOk = 0;
        //     }
        // }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        // if ($_FILES["signature"]["size"] > 500000) {
        //     echo "Sorry, your file is too large.";
        //     $uploadOk = 0;
        // }

        // Allow certain file formats
        // if (
        //     $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        //     && $imageFileType != "gif"
        // ) {
        //     echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        //     $uploadOk = 0;
        // }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["signature"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

class database extends CommonFnc
{
    protected $mysql_server = "10.1.3.5:3306";
    // protected $mysql_server = "10.1.245.167:3306";
    protected $mysql_user = "arch_dashboard";
    protected $mysql_pass = "faedadmin";
    protected $mysql_name = "arch_dashboard";

    public function open_conn()
    {
        // $conn = mysqli_connect('10.1.3.5', 'faed_ddm', 'faedadmin', 'faed_ddm');        
        // $conn = new mysqli($this->mysql_server, $this->mysql_user, $this->mysql_pass, $this->mysql_name);
        //$conn = new mysqli("10.1.3.5:3306","rims","faedamin","research_rims");
        if ($this->database_sample) {
            $mysql_name = "alumni_sample";
        }
        $conn = mysqli_connect($this->mysql_server, $this->mysql_user, $this->mysql_pass, $this->mysql_name);
        if (mysqli_connect_errno()) {
            // die("Failed to connect to MySQL: " . mysqli_connect_error());
            $this->debug_console("MySQL Error!" . mysqli_connect_error());
        }
        mysqli_set_charset($conn, "utf8");
        return $conn;
    }

    public function get_result($sql)
    {
        $result = $this->open_conn()->query($sql);
        return $result;
    }

    public function sql_execute($sql)
    {
        //$this->open_conn()->query($sql);
        $conn = $this->open_conn();
        $conn->query($sql);
        return $conn->insert_id;
    }

    public function sql_execute_multi($sql)
    {
        $conn = $this->open_conn();
        $conn->multi_query($sql);
    }

    public function sql_execute_debug($st = "", $sql)
    {
        if ($st != "") {
            if ($st == "die") {
                $this->debug_console("SQL: " . $sql);
            } else {
                $this->debug_console("SQL: " . $sql);
            }
        } else {
            //$this->open_conn()->query($sql);
            $conn = $this->open_conn();
            $conn->query($sql);
            return $conn->insert_id;
        }
    }

    public function sql_secure_string($str)
    {
        return mysqli_real_escape_string($this->open_conn(), $str);
    }

    public function get_db_row($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            if ($result->num_rows > 0) {;
                return $result->fetch_assoc();
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_rows($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            if ($result->num_rows > 0) {;
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_col_name($sql)
    {
        if (isset($sql)) {
            // $column = array("name", "orgname", "table", "orgtable", "def", "db", "catalog", "max_length", "length", "charsetnr", "flags", "type", "decimals");
            $column = array();
            $result = $this->get_result($sql);
            while ($col = $result->fetch_field()) {
                array_push($column, $col->name);
            }
            return $column;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_db_array($sql)
    {
        if (isset($sql)) {
            $result = $this->get_result($sql);
            // $this->debug_console("554:\\n" . $sql);
            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_dataset_array($sql, $method = "MYSQLI_NUM")
    {        // * method = MYSQLI_NUM, MYSQLI_ASSOC, MYSQLI_BOTH
        return $this->open_conn()->query($sql)->fetch_all(MYSQLI_BOTH);
        // return $this->open_conn()->query($sql)->fetch_all(MYSQLI_NUM);
    }

    // public function get_dataset_array($sql)
    // {
    //     $dataset = array();
    //     if (isset($sql)) {
    //         $result = $this->get_result($sql);
    //         if ($result->num_rows > 0) {
    //             while ($row = $result->fetch_array()) {
    //                 array_push($dataset, array($row[0], $row[1]));
    //             }
    //             return $dataset;
    //         }
    //         //return NULL;
    //     } else {
    //         die("fnc get_db_col no sql parameter.");
    //     }
    // }

    public function get_db_col($sql)
    {
        if (isset($sql)) {
            //echo $this->debug("", "fnc get_db_col sql: " . $sql);
            $result = $this->get_result($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_array();
                return $row[0];
            }
            return NULL;
        } else {
            die("fnc get_db_col no sql parameter.");
        }
    }

    public function get_last_id($tbl = "activity", $col = "act_id")
    {
        $sql = "select " . $col . " from " . $tbl;
        $sql .= " order by " . $col . " Desc Limit 1";
        return $this->get_db_col($sql);
    }

    public function get_log($method, $act, $usr, $note = NULL)
    {
        if (is_null($note)) {
            $sql = "call log_add ('$method', '$act', '$usr', NULL)";
        } else {
            $sql = "call log_add ('$method', '$act', '$usr', '$note')";
        }
        // die($sql);
        if ($this->sql_execute($sql)) {
            return true;
        } else {
            return false;
        }
    }
}

class Main extends CommonFnc
{
}

class MJU_API extends CommonFnc
{
    private $api_url = "";
    public function get_api_info($title = "", $api_url, $print_r = false)
    {
        $array_data = $this->GetAPI_array($api_url);
        echo "<h3 style='color:#1f65cf'>API Information: $title</h3>";
        echo "<h4 style='color:#cf1f7a'>#row: " . $this->get_row_count($array_data) . "</br>";
        echo "#column: " . $this->get_col_count($array_data) . "</br>";
        echo "@column name: <br><span style='color:#741fcf; font-size:0.8em'>";
        $this->get_col_name($array_data, true);
        echo "</span></h4><hr>";
        if ($print_r) {
            print_r($array_data);
            echo "<hr>";
        }
    }

    public function get_row_count($array, $print_r = false)
    {
        return count($array);
    }

    public function get_col_count($array, $print_r = false)
    {
        return count($array[0]);
    }

    public function get_col_name($array, $print_r = false)
    {
        if ($print_r) {
            print_r(array_keys($array[0]));
        }
        return array_keys($array[0]);
    }

    public function gen_array_filter($array, $key, $value)
    {
        $result = array();
        foreach ($array as $k => $val) {
            if ($val[$key] == $value) {
                array_push($result, $array[$k]);
            }
        }
        return $result;
    }

    public function gen_array_filter_instr($array, $key, $value)
    {
        $expected = array_filter($array, function ($var) use ($value) {
            global $key;
            if (strpos($var[$key], $value) !== false) {
                echo $var[$key];
                return true;
            }
        });
        return ($expected);
    }

    public function get_array_filter()
    {
        $json = '[{"name":"Juar","Sex":"Male","ID":"1100"},{"name":"Maria","Sex":"Female","ID":"2513"},{"name":"Pedro","Sex":"Male","ID":"2211"}]';
        $array = json_decode($json, 1);
        $ID = "ar";
        $expected = array_filter($array, function ($var) use ($ID) {
            if (strpos($var['name'], $ID) !== false) {
                echo $var['name'];
                return true;
            }
        });
        print_r($expected);
    }

    public function get_array_filters($array, $key1, $value1, $key2 = null, $value2 = null, $key3 = null, $value3 = null, $key4 = null, $value4 = null, $key5 = null, $value5 = null)
    {
        $result = $array;
        $this->debug_console("get_array_filter2 started");

        if ($key5 && $value5) {
            $result = $this->gen_array_filter($result, $key5, $value5);
            $this->debug_console("gen_array_filter condition #5 completed");
        }
        if ($key4 && $value4) {
            $result = $this->gen_array_filter($result, $key4, $value4);
            $this->debug_console("gen_array_filter condition #4 completed");
        }
        if ($key3 && $value3) {
            $result = $this->gen_array_filter($result, $key3, $value3);
            $this->debug_console("gen_array_filter condition #3 completed");
        }
        if ($key2 && $value2) {
            $result = $this->gen_array_filter($result, $key2, $value2);
            $this->debug_console("gen_array_filter condition #2 completed");
        }
        if ($key1 && $value1) {
            $result = $this->gen_array_filter($result, $key1, $value1);
            $this->debug_console("gen_array_filter condition #1 completed");
        }

        if (count($result)) {
            $this->debug_console("#row of result : " . count($result));
            return $result;
        } else {
            return null;
        }
    }

    public function get_row($array_data, $num_row = 1, $print_r = false)
    {
        if (isset($array_data) && isset($num_row)) {
            return $array_data[$num_row];
        } else {
            return null;
        }
    }

    public function get_col($array_data, $num_row, $col_name, $print_r = false)
    {
        if (isset($array_data) && isset($num_row) && isset($col_name)) {
            if ($print_r) {
                print_r($array_data[$num_row][$col_name]);
            }
            return $array_data[$num_row][$col_name];
        } else {
            return null;
        }
    }

    public function get_last_id($tbl = "activity", $col = "act_id")
    {
        $sql = "select " . $col . " from " . $tbl;
        $sql .= " order by " . $col . " Desc Limit 1";
        // return $this->get_db_col($sql);
        // $database = new $this->database();
        // return $database->get_db_col($sql);
    }

    function arraysearch_rownum($key, $value, $array)
    {
        foreach ($array as $k => $val) {
            if ($val[$key] == $value) {
                return $k;
            }
        }
        return null;
    }

    // not Supported for SSL
    /*
    Function GetAPI_array($API_URL) {
        $data = file_get_contents($API_URL); // put the contents of the file into a variable            
        $array_data = json_decode($data, true);

        return $array_data;
    }
    */

    // update for SSL
    function GetAPI_array($API_URL)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $data = file_get_contents($API_URL, false, stream_context_create($arrContextOptions)); // put the contents of the file into a variable                   
        $array_data = json_decode($data, true);

        return $array_data;
    }

    function GetAPI_object($API_URL)
    {
        $data = file_get_contents($API_URL); // put the contents of the file into a variable    
        $obj_data = json_decode($data); // decode the JSON to obj        
        return $obj_data;
    }
}

class Fnc_json_service extends CommonFnc
{
    public function json_read($json_file, $display = false)
    {
        global $fnc;

        // Read the JSON file 
        $json_text = file_get_contents($json_file);

        // Decode the JSON file
        $json_array = json_decode($json_text, true);

        // Display data
        if ($display) {
            echo '<h3>read display</h3><pre>';
            print_r($json_array);
            echo '</pre>';
        }
        return $json_array;
    }
}

class jsonQuery
{
    private function GetAPI_array($API_URL)
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $data = file_get_contents($API_URL, false, stream_context_create($arrContextOptions)); // put the contents of the file into a variable                   
        $array_data = json_decode($data, true);

        return $array_data;
    }

    private function get_row_count($array, $print_r = false)
    {
        return count($array);
    }

    private function get_col_count($array, $print_r = false)
    {
        return count($array[0]);
    }

    private function get_col_name($array, $print_r = false)
    {
        if ($print_r) {
            print_r(array_keys($array[0]));
        }
        return array_keys($array[0]);
    }

    private function get_array_filter($data_array, $key, $operator = "=", $value)
    {
        $result = array();
        foreach ($data_array as $k => $val) {
            switch (trim($operator)) {
                case "=":
                    if ($val[$key] == $value) {
                        array_push($result, $data_array[$k]);
                        // echo $val[$key] . " = " .  $value . "<br>";
                    }
                    break;
                case "!=":
                    if ($val[$key] != $value) {
                        array_push($result, $data_array[$k]);
                    }
                    break;
                case "<>":
                    if ($val[$key] != $value) {
                        array_push($result, $data_array[$k]);
                    }
                    break;
                case "<":
                    if ($val[$key] < $value) {
                        array_push($result, $data_array[$k]);
                    }
                    break;
                case "<=":
                    if ($val[$key] <= $value) {
                        array_push($result, $data_array[$k]);
                    }
                    break;
                case ">":
                    if ($val[$key] > $value) {
                        array_push($result, $data_array[$k]);
                        // echo $val[$key] . " > " .  $value . "<br>";
                    }
                    break;
                case ">=":
                    if ($val[$key] >= $value) {
                        array_push($result, $data_array[$k]);
                    }
                    break;
                case "LIKE":
                    if (strstr($val[$key], $value)) {
                        array_push($result, $data_array[$k]);
                    }
                    break;
            }
        }
        // echo "<hr>count: " . count($result) . "<hr>";
        return $result;
    }

    public function gen_table_url($api_url)
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

    /**
     * It takes an array of arrays and outputs a table.
     * 
     * @param data_array The array of data you want to display in the table.
     */
    public function gen_table_array($data_array)
    {
        $col_title = array_keys($data_array[0]);
        echo "<hr><h3>#ROW: " . count($data_array) . "</h3>";
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

    private function debug_console($val1, $val2 = null)
    {
        if (is_array($val1)) {
            // $val1 = implode(',', $val1);
            $val1 = str_replace(
                chr(34),
                '',
                json_encode($val1, JSON_UNESCAPED_UNICODE)
            );
            $val1 = str_replace(chr(58), chr(61), $val1);
            $val1 = str_replace(chr(44), ', ', $val1);
            $val1 = 'Array:' . $val1;
        }
        if (is_array($val2)) {
            // $val2 = implode(',', $val2);
            $val2 = str_replace(
                chr(34),
                '',
                json_encode($val2, JSON_UNESCAPED_UNICODE)
            );
            $val2 = str_replace(chr(58), chr(61), $val2);
            $val2 = str_replace(chr(44), ', ', $val2);
            $val2 = 'Array:' . $val2;
        }
        if (isset($val1) && isset($val2) && !is_null($val2)) {
            echo '<script>console.log("' .
                $val1 .
                '\\n' .
                $val2 .
                '");</script>';
        } else {
            echo '<script>console.log("' . $val1 . '");</script>';
        }
    }

    public function get($api_url)
    {
        return $this->GetAPI_array($api_url);
    }

    public function info_url($api_url, $title = "INFO", $print_r = false)
    {
        $json_array = $this->GetAPI_array($api_url);
        echo "<h3 style='color:#1f65cf'>API Information: $title</h3>";
        echo "<h4 style='color:#cf1f7a'>#row: " . $this->get_row_count($json_array) . "</br>";
        echo "#column: " . $this->get_col_count($json_array) . "</br>";
        echo "@column name: <br><span style='color:#741fcf; font-size:0.8em'>";
        $this->get_col_name($json_array, true);
        echo "</span></h4><hr>";
        if ($print_r) {
            print_r($json_array);
            echo "<hr>";
        }
    }

    public function info_array($data_array, $title = "INFO", $print_r = false)
    {
        echo "<h3 style='color:#1f65cf'>API Information: $title</h3>";
        echo "<h4 style='color:#cf1f7a'>#row: " . $this->get_row_count($data_array) . "</br>";
        echo "#column: " . $this->get_col_count($data_array) . "</br>";
        echo "@column name: <br><span style='color:#741fcf; font-size:0.8em'>";
        $this->get_col_name($data_array, true);
        echo "</span></h4><hr>";
        if ($print_r) {
            print_r($data_array);
            echo "<hr>";
        }
    }

    public function where_or($data_array, $condition)
    {
        // $condition = "programCode = 1901 OR programCode = 1904";
        $this->debug_console("json where_or : \\n" . $condition);
        $cond_or = explode(" OR ", $condition);
        if (isset($cond_or) && is_array($cond_or)) {
            $dataArrayOr = array();
            for ($i = 0; $i < count($cond_or); $i++) {
                $exp = explode(" ", $cond_or[$i]);
                $dataArrayOr[$i] = $this->get_array_filter($data_array, $exp[0], $exp[1], $exp[2]);
                // echo "<hr>OR Table (" . $cond_or[$i] . "): #" . count($dataArrayOr[$i]);
                // $this->gen_table_array($dataArrayOr[$i]);
            }
            $result = $dataArrayOr[0];
            for ($i = 1; $i < count($dataArrayOr); $i++) {
                $result = array_merge($result, $dataArrayOr[$i]);
            }
            // $this->gen_table_array($result);
        }
        return $result;
    }

    public function where_and($data_array, $condition)
    {
        // $condition = "status > 40 AND programCode = 1901 AND studentyear = 5";
        $this->debug_console("json where_and : \\n" . $condition);
        $result = $data_array;
        if (strpos($condition, " AND ")) {
            $cond_and = explode(" AND ", $condition);
            $dataArrayAnd = array();
            for ($i = 0; $i < count($cond_and); $i++) {
                $exp = explode(" ", $cond_and[$i]);
                $result = $this->get_array_filter($result, $exp[0], $exp[1], $exp[2]);
                // echo "<hr>AND Table (" . $cond_and[$i] . "):";
            }
        }

        return $result;
    }

    public function where($data_array, $condition)
    {
        // $condition = "status = 40";
        $this->debug_console("json where : \\n" . $condition);
        $exp = explode(" ", $condition);
        $result = $this->get_array_filter($data_array, $exp[0], $exp[1], $exp[2]);
        // echo "<hr>AND Table (" . $cond_and[$i] . "):";

        return $result;
    }
}


class Fnc_ChartJS extends CommonFnc
{
    public function gen_Chart_Doughnut($title = 'sample doughnut chart', $labels_array = array('Red', 'Blue', 'Yellow'), $data_array = array(30, 60, 90), $element_id = null)
    {
        global $fnc;
        if (!$element_id) {
            $element_id = 'PersonalSummary';
        }
    ?>
        <div class="card">
            <div class="card-title p-3">
                <h4 class="mb-0 pt-2 text-bold"><?= $title ?></h4>
            </div>
            <div class="card-body p-3 px-5">
                <canvas id="<?= $element_id ?>" style="max-height: 20em"></canvas>
            </div>
        </div>

        <script>
            const Chart_<?= $element_id ?> = document.getElementById('<?= $element_id ?>');
            const dataset_<?= $element_id ?> = {
                labels: <?= json_encode($labels_array) ?>,
                datasets: [{
                    label: '<?= $title ?>',
                    data: <?= json_encode($data_array) ?>,
                    backgroundColor: <?= json_encode($fnc->chart_bg_color) ?>,
                    borderColor: <?= json_encode($fnc->chart_bd_color) ?>,
                    hoverOffset: 4
                }]
            };
            new Chart(Chart_<?= $element_id ?>, {
                type: 'doughnut',
                data: dataset_<?= $element_id ?>
            });
        </script>

    <?php
    }

    public function gen_Chart_Bar($title = 'sample doughnut chart', $labels_array = array('Red', 'Blue', 'Yellow'), $data_array = array(30, 60, 90), $element_id = null)
    {
        if (!$element_id) {
            $element_id = 'PersonalSummary';
        }
    ?>
        <div class="card">
            <div class="card-title p-3">
                <h4 class="mb-0 pt-2 text-bold"><?= $title ?></h4>
            </div>
            <div class="card-body p-3 px-5">
                <canvas id="<?= $element_id ?>" style="max-height: 20em"></canvas>
            </div>
        </div>

        <script>
            const Chart_<?= $element_id ?> = document.getElementById('<?= $element_id ?>');
            const dataset_<?= $element_id ?> = {
                labels: <?= json_encode($labels_array) ?>,
                datasets: [{
                    label: '<?= $title ?>',
                    data: <?= json_encode($data_array) ?>,
                    backgroundColor: <?= json_encode($this->chart_bg_color) ?>,
                    borderColor: <?= json_encode($this->chart_bd_color) ?>,
                    borderWidth: 2
                }]
            };
            new Chart(Chart_<?= $element_id ?>, {
                type: 'bar',
                data: dataset_<?= $element_id ?>,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 2,
                                precision: 0
                            }
                        }
                    },
                    legend: {
                        display: true,
                        lable: {
                            color: 'rgb(255, 99, 132)'
                        }
                    }
                }
            });

            window.addEventListener('afterprint', () => {
                Chart_<?= $element_id ?>.resize();
            });
        </script>

<?php
    }
}
?>