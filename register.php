<?php
include 'connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

// check if user exists
$check = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) > 0) {
    echo "exists";
} else {
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>