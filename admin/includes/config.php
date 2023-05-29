<?php
define('DB_HOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','saloon_management');
//connect
$dbconn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
//test connection
if(mysqli_connect_errno()){
    echo ' Failed to connect to the database: Error ' . mysqli_connect_errno();
    exit();
}
?>