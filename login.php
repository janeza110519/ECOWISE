<?php
session_start();
include "connect.php";

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
            echo "<script>alert('Invalid Password');</script>";
        }

    } else {
        echo "<script>alert('User Not Found');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>EcoWise Login</title>

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
    margin:10px 0;
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
    <h1><i>EcoWise</i></h1>
</div>

<div class="right">

<form method="POST">

<h3>Username</h3>
<input type="text" name="username" required>

<h3>Password</h3>
<input type="password" name="password" required>

<button type="submit"><b>Login</b></button>

<a href="register.php">
<button type="button"><b>Sign Up</b></button>
</a>

</form>

</div>
</div>

</body>
</html>