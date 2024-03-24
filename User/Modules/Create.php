<?php
include "connection.php";

if (isset($_POST['txtfname'], $_POST['txtlname'], $_POST['txtBdate'], $_POST['txtAdd'], $_POST['txtDisorder'], $_POST['txtGuardian'], $_POST['cbosex'], $_POST['txtCPNo'])) {
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

    // Prepare and execute the SQL INSERT statement
    $stmt = $conn->prepare("INSERT INTO patients (fname, lname, birthdate, `address`, disorder, guardian, Sex, contactNum,slpID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $fname, $lname, $birthdate, $address, $disorder, $guardian, $sex, $contactNum, $slpID);

    if ($stmt->execute()) {
        // Successful insertion
        echo "Patient information saved successfully!";
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