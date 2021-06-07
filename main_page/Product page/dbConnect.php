<?php
$dbConnection = mysqli_connect("localhost","root","","php_shop");

//check connection status
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
#echo "connect success";


mysqli_set_charset($dbConnection, "utf8");