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

/*
FETCH CHART DATA DIRECTLY
*/
$chartQuery = "
    SELECT location.Locationname, COUNT(*) as total 
    FROM task 
    INNER JOIN location ON task.Location_ID = location.Location_ID 
    WHERE task.Status='Accomplished' 
    GROUP BY location.Locationname
";
$chartResult = mysqli_query($conn, $chartQuery);

$labels = [];
$counts = [];

while($row = mysqli_fetch_assoc($chartResult)){
    $labels[] = $row['Locationname'];
    $counts[] = $row['total'];
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

.table-box{
    background:white;
    color:black;
    padding;10px;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

td button{
    padding:5px 10px;
    margin:2px;
    cursor:pointer;
}

canvas{
    background:white;
    margin-top:20px;
    padding: 20px;
    max-height:400px;
}

</style>
</head>

<body>

<div class="header">
    EcoWise Dashboard
</div>

<div class="container">

<!-- SIDEBAR -->
<div class="sidebar">

<h2>Maps</h2>

<form method="POST">


<select name="location">

<option value="1">Agusan Canyon</option>
<option value="2">Alae</option>
<option value="3">Dahilayan</option>
<option value="4">Damilag</option>
<option value="5">Diclum</option>
<option value="6">Guilang-Guilang</option>
<option value="7">Kalugmanan</option>
<option value="8">Lindaban</option>
<option value="9">Lingion</option>
<option value="10">Lunocan</option>
<option value="11">Maluko</option>
<option value="12">Mambatangan</option>
<option value="13">Mampayag</option>
<option value="14">Mantibugao</option>
<option value="15">Minsuro</option>
<option value="16">San Miguel</option>
<option value="17">Sankanan</option>
<option value="18">Santiago</option>
<option value="19">Santo Niño</option>
<option value="20">Tankulan</option>
<option value="21">Ticala</option>

</select>

<h2>Set Day</h2>

<select name="day">

<option value="1">Monday</option>
<option value="2">Tuesday</option>
<option value="3">Wednesday</option>
<option value="4">Thursday</option>
<option value="5">Friday</option>
<option value="6">Saturday</option>
<option value="7">Sunday</option>

</select>

<h2>Target</h2>

<select name="target">

<option value="1">Recyclable</option>
<option value="2">Biodegradable</option>
<option value="3">Non-Biodegradable</option>

</select>

<h2>Importance</h2>

<select name="importance">

<option value="1">Priority</option>
<option value="2">Non-Priority</option>

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

/*
SQL QUERY FOR DISPLAYING TASK DATA

The task table only stores IDs such as:
- Location_ID
- Day_ID
- Target_ID
- Importance_ID

INNER JOIN is used to connect the task table
with other related tables in order to display
the actual names instead of numeric IDs.
*/

$sql = "
SELECT *
FROM task
INNER JOIN location ON task.Location_ID = location.Location_ID
INNER JOIN day ON task.Day_ID = day.Day_ID
INNER JOIN target ON task.Target_ID = target.Target_ID
INNER JOIN importance ON task.Importance_ID = importance.Importance_ID
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

<a href="move.php?id=<?= $row['Task_ID']; ?>">
<button>Move</button>
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
    // Injecting PHP arrays directly into JS variables
    const labels = <?php echo json_encode($labels); ?>;
    const values = <?php echo json_encode($counts); ?>;

    new Chart(document.getElementById('myChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Accomplished per Barangay',
                data: values,
                backgroundColor: '#32d74b', // Optional: adds color to the bars
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>