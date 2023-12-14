<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webdienmay";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("Kết nối không thành công: " . $connect->connect_error);
}

mysqli_set_charset($connect, "utf8");
?>
