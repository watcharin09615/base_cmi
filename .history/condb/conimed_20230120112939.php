<?php

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Bangkok");
$sqlimed = "host=172.17.19.231  port=5432 dbname=imed_code7 user=postgres password=postgreswpa";
$conimed = pg_connect($sqlimed) or die("Connection Error");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>