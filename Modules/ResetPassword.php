<?php
include "connection.php";

if (isset($_POST['txtpass'], $_POST['UID'])) {
    $password = password_hash($_POST['txtpass'], PASSWORD_DEFAULT); 
    $uid = mysqli_real_escape_string($conn, $_POST['UID']);
    $errors = array();

    $stmt = mysqli_prepare($conn, "UPDATE tbl_acc SET password_hash = ? WHERE UserID = ?");
    mysqli_stmt_bind_param($stmt, "ss", $password, $uid);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $response = array("status" => "success");
        echo json_encode($response);
    } else {
        $errors['login'] = "Password update failed.";
        echo json_encode(array('error' => $errors['login']));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
} else {
    echo json_encode(array('error' => 'Invalid request'));
    exit();
}
?>