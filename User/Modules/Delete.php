<?php
include "connection.php";

if (isset($_POST['PatientID'])) {
    session_start();
    
    // Fetch data from the form
    $slpID = $_SESSION['SLPID'];
    $PID = $_POST['PatientID'];

    // Prepare and execute the SQL INSERT statement
    $stmt = $conn->prepare("DELETE FROM patients where SLPID = ? and ID = ?");
    $stmt->bind_param("ii", $slpID, $PID);

    if ($stmt->execute()) {
        // Successful insertion
        echo "Patient information deleted successfully!";
    } else {
        // Error during insertion
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

} else {
    // Handle the case when not all form fields are set
    echo "Error: All form fields are required.";
}
?>