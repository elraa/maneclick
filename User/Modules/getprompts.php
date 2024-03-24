<?php
include "connection.php";

$query = "SELECT promptID, promptName FROM prompt";
$result = $conn->query($query);

$prompts = array();
while ($row = $result->fetch_assoc()) {
    $prompts[] = $row;
}

echo json_encode($prompts);

$conn->close();
?>