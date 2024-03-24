<?php
include "connection.php";

if (isset($_POST['txtfname'], $_POST['txtlname'], $_POST['txtBdate'], $_POST['txtAdd'], $_POST['txtDisorder'], $_POST['txtGuardian'], $_POST['cbosex'], $_POST['txtCPNo'], $_POST['PatientID'])) {
    session_start();
    
    // Fetch data from the form
    $fname = $_POST['txtfname'];
    $lname = $_POST['txtlname'];
    $birthdate = $_POST['txtBdate'];
    $address = $_POST['txtAdd'];
    $disorder = $_POST['txtDisorder'];
    $guardian = $_POST['txtGuardian'];
    $sex = $_POST['cbosex'];
    $contactNum = $_POST['txtCPNo'];
    $slpID = $_SESSION['SLPID'];
    $PID = $_POST['PatientID'];

    // Prepare and execute the SQL INSERT statement
    $stmt = $conn->prepare("UPDATE patients SET fname = ?, lname = ?, birthdate = ?, `address` = ?, disorder = ?, guardian = ?, Sex = ?, contactNum = ? where SLPID = ? and ID = ?");
    $stmt->bind_param("ssssssssii", $fname, $lname, $birthdate, $address, $disorder, $guardian, $sex, $contactNum, $slpID, $PID);

    if ($stmt->execute()) {
        // Successful insertion
        echo "Patient information update successfully!";
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