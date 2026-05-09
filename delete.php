<?php
include "connect.php";

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM task WHERE Task_ID='$id'");

header("Location: dashboard.php");
?>