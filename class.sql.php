<?php
include_once('class.config.php');
class sql extends config {
    private $link;
    public $query;

    public function __construct() {
        parent::__construct();
        $this->link = mysqli_connect($this->host, $this->mysql_user, $this->mysql_passwd, $this->mysql_dbName) or die(mysqli_error(0));
    }

    public function process() {
        $result = mysqli_query($this->link, $this->query) or die(mysqli_error($this->link));
        return $result;
    }

    public function getData($column_name, $table, $field, $value, $field1=1, $value1=1, $field2=1, $value2=1) {
        $this->query = "SELECT $column_name FROM $table WHERE $field = '$value' and $field1 = '$value1' and '$field2' = '$value2' ";
        $result = $this->process();
        $row = mysqli_fetch_assoc($result);
        return $row[$column_name];
    }

    public function getDistinctDatas($column_name, $table, $field=1, $value=1) {
        $this->query = "SELECT $column_name from $table WHERE $field = '$value'";
        $result = $this->process();
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            array_push($rows, $row[$column_name]);
        }
        return $rows;
    }

    public function getDataOnlyOne($table, $field=1, $value=1, $field1=1, $value1=1, $field2=1, $value2=1) {
        $this->query = "SELECT *from $table WHERE $field = '$value' and $field1 = '$value1' and $field2 = '$value2' ";
        $result = $this->process();
        $row = mysqli_fetch_assoc($result);
        return $row;                            // returns associative array 
    } 

    public function getDatas($table, $field=1, $value=1, $field1=1, $value1=1, $field2=1, $value2=1) {
        $this->query = "SELECT * from $table WHERE $field = '$value' and $field1 = '$value1' and $field2 = '$value2'";
        $result = $this->process();
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            array_push($rows, $row);
        }
        return $rows;
    }

    public function countData($table, $column_name1=1, $column_value1=1, $column_name2=1, $column_value2=1, $column_name3=1, $column_value3=1) {
        $this->query = "SELECT * FROM $table WHERE $column_name1 = '$column_value1' and $column_name2 = '$column_value2' and $column_name3 = $column_value3 ";
        $result = $this->process();
        return mysqli_num_rows($result);
    }

    public function searchData($table,$column_name, $field, $data) {
        $this->query = "SELECT * FROM $table WHERE $field LIKE '%".$data."%'";
        $result = $this->process();
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            array_push($rows, $row[$column_name]);
        }
        return $rows;
    }

    public function escape($string) {
        return mysqli_real_escape_string($this->link, $string);
    }
    
    public function close() {
        mysqli_close($this->link);
    }
}   
?>