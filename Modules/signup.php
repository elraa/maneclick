<?php
include 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['txtfname'];
    $lname = $_POST['txtlname'];
    $email = $_POST['txtEmail'];
    $sex = $_POST['cbosex'];
    $birthdate = DateTime::createFromFormat('Y-m-d', $_POST['txtbdate'])->format('Y-m-d');
    $address = $_POST['txtAdd'];
    $contactNum = $_POST['txtPhone'];
    $idNumber = $_POST['txtIDNumber'];
    $SubsType = $_POST['SubsType'];
    $PayRef = "";

    // Insert user data into the slp table
    $stmt = $conn->prepare("INSERT INTO slp (fname, lname, email, Sex, birthdate, `address`, contactNum, IDNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssis", $fname, $lname, $email, $sex, $birthdate, $address, $contactNum, $idNumber);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        // Insert data into tbl_acc table
        $username = $_POST['txtuname'];  // You may need to adjust this based on your form
        $password = password_hash($_POST['txtpass'], PASSWORD_DEFAULT);  // Hash the password

        $stmt_acc = $conn->prepare("CALL sp_signup(?, ?, ?, ?, ?, ?)");
        $acc_type = 'SLP';  // You may adjust the AccType based on your needs
        $stmt_acc->bind_param("sssiss", $username, $password, $acc_type, $user_id, $SubsType, $PayRef );

        if ($stmt_acc->execute()) {
            // Copy the uploaded image to wwwroot/img folder
            $idPath = 'SLP_' . $user_id . '_' . basename($_FILES['fileUploader']['name']);
            $target_path = '../wwwroot/img/license/' . $idPath;

            if (move_uploaded_file($_FILES['fileUploader']['tmp_name'], $target_path)) {
                // Update the database with the filename
                $stmt_update = $conn->prepare("UPDATE slp SET IDPath = ? WHERE id = ?");
                $stmt_update->bind_param("si", $idPath, $user_id);

                if ($stmt_update->execute()) {
                    $response['status'] = 'success';

                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error updating IDPath: ' . $stmt_update->error;
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error moving the uploaded file: ' . $_FILES['fileUploader']['error'];
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error inserting data into tbl_acc table: ' . $stmt_acc->error;
        }
        
        $stmt_acc->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error inserting user data into the slp table: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Send the JSON response with the correct content type
header('Content-Type: application/json');
echo json_encode($response);
?>