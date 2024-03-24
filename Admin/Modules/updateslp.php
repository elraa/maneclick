<?php
include "connection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modalId = $_POST["modalId"];
    $action = $_POST["action"];

    // Validate $action to prevent SQL injection
    $validActions = ["approve", "disapprove"];
    if (!in_array($action, $validActions)) {
        die("Invalid action");
    }

    // Update the status in the slp table
    $status = ($action === "approve") ? 1 : 2;

    $updateQuery = "UPDATE tbl_acc SET isActive = ? WHERE USERID = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ii", $status, $modalId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method";
}
?>