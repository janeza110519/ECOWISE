<?php
include "connect.php";

$id = $_GET['id'];

mysqli_query($conn,
"UPDATE task SET Status='Accomplished' WHERE Task_ID='$id'");

header("Location: dashboard.php");
?>