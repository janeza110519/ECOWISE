<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE Username='$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['Password'])) {

            $_SESSION['user'] = $user['Username'];
            header("Location: dashboard.php");
            exit();

        } else {
            echo "Invalid password";
        }

    } else {
        echo "User not found";
    }
}
?>