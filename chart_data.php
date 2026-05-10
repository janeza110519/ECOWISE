<?php
include "connect.php";

/*
SQL QUERY FOR ANALYTICS CHART

Purpose:
Counts the number of accomplished tasks
for each barangay/location.
*/

$sql = "

SELECT
location.Locationname,
COUNT(*) as total

FROM task

INNER JOIN location
ON task.Location_ID = location.Location_ID

WHERE task.Status='Accomplished'

GROUP BY location.Locationname

";

$result = mysqli_query($conn, $sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){

    $data[] = $row;

}

echo json_encode($data);
?>