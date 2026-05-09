<?php
session_start();
include "connect.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

/*
GET USER ID
*/
$username = $_SESSION['user'];

$userQuery = mysqli_query($conn, "SELECT * FROM user WHERE Username='$username'");
$userData = mysqli_fetch_assoc($userQuery);

$user_id = $userData['user_id'];

/*
ADD TASK
*/
if(isset($_POST['add_task'])){

    $location = $_POST['location'];
    $day = $_POST['day'];
    $target = $_POST['target'];
    $importance = $_POST['importance'];

    mysqli_query($conn, "
        INSERT INTO task
        (User_ID, Location_ID, Day_ID, Target_ID, Importance_ID, Status)

        VALUES
        ('$user_id','$location','$day','$target','$importance','Pending')
    ");

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>EcoWise Dashboard</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#3b6a8a;
}

.header{
    background:#32d74b;
    height:140px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#3b0050;
    font-size:60px;
    font-weight:bold;
    font-style:italic;
}

.container{
    display:flex;
    height:calc(100vh - 140px);
}

.sidebar{
    width:250px;
    background:#006d6d;
    color:white;
    padding:20px;
}

.sidebar h2{
    text-align:center;
}

.sidebar select,
.sidebar button{
    width:100%;
    padding:10px;
    margin-bottom:15px;
}

.main{
    flex:1;
    background:#2f5d83;
    padding:20px;
    color:white;
}

.table-box{
    background:white;
    color:black;
    padding:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}

.btn-group{
    margin-top:20px;
    display:flex;
    gap:20px;
}

.btn-group button{
    padding:10px 30px;
}

canvas{
    background:white;
    margin-top:20px;
    padding:20px;
}

</style>
</head>

<body>

<div class="header">
    Eco Wise
</div>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">

<h2>Maps</h2>

<form method="POST">

<select name="location">

<?php
$loc = mysqli_query($conn, "SELECT * FROM location");

while($row = mysqli_fetch_assoc($loc)){
?>

<option value="<?= $row['Location_ID']; ?>">
    <?= $row['Locationname']; ?>
</option>

<?php } ?>

</select>

<h2>Set Day</h2>

<select name="day">

<?php
$day = mysqli_query($conn, "SELECT * FROM day");

while($row = mysqli_fetch_assoc($day)){
?>

<option value="<?= $row['Day_ID']; ?>">
    <?= $row['Dayname']; ?>
</option>

<?php } ?>

</select>

<h2>Target</h2>

<select name="target">

<?php
$target = mysqli_query($conn, "SELECT * FROM target");

while($row = mysqli_fetch_assoc($target)){
?>

<option value="<?= $row['Target_ID']; ?>">
    <?= $row['Targetname']; ?>
</option>

<?php } ?>

</select>

<h2>Importance</h2>

<select name="importance">

<?php
$importance = mysqli_query($conn, "SELECT * FROM importance");

while($row = mysqli_fetch_assoc($importance)){
?>

<option value="<?= $row['Importance_ID']; ?>">
    <?= $row['Level']; ?>
</option>

<?php } ?>

</select>

<button type="submit" name="add_task">Set</button>

</form>

<a href="logout.php">
<button>Logout</button>
</a>

</div>

<!-- MAIN -->
<div class="main">

<h1>List of Task</h1>

<div class="table-box">

<table>

<tr>
    <th>Location</th>
    <th>Day</th>
    <th>Target</th>
    <th>Importance</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php

$sql = "
SELECT *
FROM task
JOIN location ON task.Location_ID = location.Location_ID
JOIN day ON task.Day_ID = day.Day_ID
JOIN target ON task.Target_ID = target.Target_ID
JOIN importance ON task.Importance_ID = importance.Importance_ID
WHERE User_ID = '$user_id'
";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
?>

<tr>

<td><?= $row['Locationname']; ?></td>
<td><?= $row['Dayname']; ?></td>
<td><?= $row['Targetname']; ?></td>
<td><?= $row['Level']; ?></td>
<td><?= $row['Status']; ?></td>

<td>

<a href="done.php?id=<?= $row['Task_ID']; ?>">
<button>Done</button>
</a>

<a href="delete.php?id=<?= $row['Task_ID']; ?>">
<button>Delete</button>
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<h2>Analytics</h2>

<canvas id="myChart"></canvas>

</div>

</div>

<script>

fetch('chart_data.php')
.then(response => response.json())
.then(data => {

    let labels = [];
    let values = [];

    data.forEach(item => {

        labels.push(item.Locationname);
        values.push(item.total);

    });

    new Chart(document.getElementById('myChart'), {

        type: 'bar',

        data: {

            labels: labels,

            datasets: [{
                label: 'Accomplished per Barangay',
                data: values
            }]
        }

    });

});

</script>

</body>
</html>