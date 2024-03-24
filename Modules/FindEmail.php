<?php
include "connection.php";

if (isset($_POST['txtEmail'])) {
    $username = mysqli_real_escape_string($conn, $_POST['txtEmail']);
    $errors = array();

    $stmt = mysqli_prepare($conn, "SELECT t1.UserID, t2.email FROM tbl_acc t1 INNER JOIN slp t2 ON t2.id = t1.userid WHERE t2.email = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $UID = $row['UserID'];
            $UEmail = $row['email'];

            $response = array(
                'uid' => $UID,
                'uemail' => $UEmail);
            echo json_encode($response);
            exit();
        } else {
            $errors['login'] = "Email does not match to our records!";
        }
    } else {
        $errors['database'] = "Error executing the query: " . mysqli_error($conn);
    }

    echo json_encode(array('error' => $errors['login']));
    exit();
}

mysqli_close($conn);
?>