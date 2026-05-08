<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];

    if ($password != $confirm) {

        echo "<script>alert('Passwords do not match!');</script>";

    } else {

        $check = mysqli_query($conn,
        "SELECT * FROM user WHERE Username='$username'");

        if (mysqli_num_rows($check) > 0) {

            echo "<script>alert('Username already exists!');</script>";

        } else {

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO user
            (Fullname, Username, Password)

            VALUES
            ('$fullname','$username','$hashed')";

            if (mysqli_query($conn, $query)) {

                echo "<script>
                alert('Registered Successfully!');
                window.location.href='login.php';
                </script>";

            } else {

                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>EcoWise Register</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#2ecc71;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.container{
    display:flex;
    width:600px;
    box-shadow:0 0 10px rgba(0,0,0,0.3);
}

.left{
    width:40%;
    background:#0f6b5b;
    color:white;
    text-align:center;
    padding:30px;
}

.left img{
    width:100px;
}

.right{
    width:60%;
    background:#2ecc71;
    padding:30px;
}

input{
    width:100%;
    padding:10px;
    margin:8px 0;
}

button{
    padding:10px 20px;
    margin:10px 5px;
    cursor:pointer;
}

</style>
</head>

<body>

<div class="container">

<div class="left">
    <img src="logo.png">
    <h1>EcoWise</h1>
</div>

<div class="right">

<form method="POST">

<h3>Fullname</h3>
<input type="text" name="fullname" required>

<h3>Username</h3>
<input type="text" name="username" required>

<h3>Password</h3>
<input type="password" name="password" required>

<h3>Confirm Password</h3>
<input type="password" name="confirmPassword" required>

<button type="submit"><b>Register</b></button>

<a href="login.php">
<button type="button"><b>Back to Login</b></button>
</a>

</form>

</div>
</div>

</body>
</html>