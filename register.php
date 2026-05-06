<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Check existing
    $check = mysqli_query($conn, "SELECT * FROM user WHERE Username='$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "Username already exists!";
        exit();
    }

    $query = "INSERT INTO user (Fullname, Username, Password)
              VALUES ('$fullname', '$username', '$hashed')";

    if (mysqli_query($conn, $query)) {
        echo "Registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>