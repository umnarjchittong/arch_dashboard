<?php
ini_set('display_errors', 1);

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
