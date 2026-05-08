<?php
include "connect.php";

/*

we use inner join to combine the task + location table
to get the REAL NAME of barangay
*/

$sql = "SELECT location.Location_Name, COUNT(*) as total
        FROM task
        JOIN location ON task.Location_ID = location.Location_ID
        WHERE task.Status = 'Accomplished'
        GROUP BY location.Location_Name";

$result = mysqli_query($conn, $sql);

$data = [];

while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>