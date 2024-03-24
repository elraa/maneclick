<?php
include "connection.php";

if (isset($_POST['txtuname']) && isset($_POST['txtpass'])) {
    $username = mysqli_real_escape_string($conn, $_POST['txtuname']);
    $password = mysqli_real_escape_string($conn, $_POST['txtpass']);
    $errors = array();

    $sql = "CALL sp_login('$username')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $storedHashedPassword = $row['Password_hash'];
            $accrole = $row['AccType'];
            $isActive = $row['isActive'];
            $USERID = $row['USERID'];
            $SubsType = $row['SubsType'];
            $Fname = $row['Fname'];

            if (password_verify($password, $storedHashedPassword)) {
                if ($isActive == 1) {
                    session_start();
                    $_SESSION['loggedin'] = $accrole;
                    $response = array('role' => $accrole);

                  if (strtoupper($accrole) === 'SLP') {
                    
                    $_SESSION['SubsType'] = $SubsType;
                    $_SESSION['Fname'] = $Fname;
                    $_SESSION['SLPID'] = $USERID;
                }
                    echo json_encode($response);
                    exit();
                } else {
                    $errors['login'] = "Account verification is still in progress!";
                }
            } else {
                $errors['login'] = "Incorrect password";
            }
        } else {
            $errors['login'] = "Incorrect username or password";
        }
    } else {
        $errors['database'] = "Error executing the query: " . mysqli_error($conn);
    }

    echo json_encode(array('error' => $errors['login']));
    exit();
}

mysqli_close($conn);
?>