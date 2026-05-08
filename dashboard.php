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

<h3><b>Welcome</b></h3>

<p>
<?php echo $_SESSION['user']; ?>
</p>


<hr>

<h3>Maps</h3>
<select id="location">
    <option>Tankulan</option>
    <option>Sankanan</option>
    <option>Damilag</option>
</select>

<h3>Set Day</h3>
<select id="day">
    <option>Monday</option>
    <option>Tuesday</option>
    <option>Wednesday</option>
    <option>Thursday</option>
    <option>Friday</option>
    <option>Saturday</option>
    <option>Sunday</option>
</select>

<h3>Target</h3>
<select id="target">
    <option>Recyclable</option>
    <option>Biodegradable</option>
    <option>Non-Biodegradable</option>
</select>

<h3>Importance</h3>
<select id="importance">
    <option>Priority</option>
    <option>Non-Priority</option>
</select>

<button onclick="addTask()">Set</button>

<a href="logout.php">
<button>Logout</button>
</a>

</div>


<div class="main">

<h2>List of Task</h2>

<table border="1" width="100%" id="taskTable">
    <tr>
        <th>Location</th>
        <th>Day</th>
        <th>Target</th>
        <th>Importance</th>
        <th>Status</th>
    </tr>
</table>

<br>

<button onclick="markDone()">Done</button>
<button onclick="deleteTask()">Delete</button>

</div>

</div>

</body>
</html>