<?php
class config {
    var $host, $mysql_user, $mysql_passwd, $mysql_dbName;
    public $baseServer;
    
    public function __construct() {
        $this->host = "localhost";
        $this->mysql_user = "root";
        $this->mysql_passwd = "";
        $this->mysql_dbName = "ExpendiShare";
        $this->baseServer = "/ExpendiShare/";
        date_default_timezone_set('Asia/Kolkata');
    }
}
?>