<?php
session_start();

if (!isset($_SESSION['user'])) {

    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#3b6a8a;
}

header{
    background:#2ecc71;
    padding:15px;
    text-align:center;
    font-size:30px;
    font-weight:bold;
}

.container{
    display:flex;
    height:90vh;
}

.sidebar{
    width:250px;
    background:#0f6b5b;
    color:white;
    padding:20px;
}

.main{
    flex:1;
    padding:20px;
    background:white;
}

button{
    padding:10px 20px;
    margin-top:10px;
    cursor:pointer;
}

</style>
</head>

<body>

<header>
EcoWise Dashboard
</header>

<div class="container">

<div class="sidebar">

<h3>Welcome</h3>

<p>
<?php echo $_SESSION['user']; ?>
</p>

<a href="logout.php">
<button>Logout</button>
</a>

</div>

<div class="main">

<h2>Successfully Logged In!</h2>

<p>Your dashboard is now connected.</p>

</div>

</div>

</body>
</html>