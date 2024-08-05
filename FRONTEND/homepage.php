<?php
session_start(); // Start the session to manage user login state
include '../BACKEND/config/db.php';
// Check if the user is not logged in (no session exists)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'SLP') {
    header("Location: dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user's ID exists in the subscription table
$stmt = $conn->prepare("SELECT * FROM subscription WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$subscription = $stmt->fetch(PDO::FETCH_ASSOC);

// If subscription doesn't exist
if (!$subscription) {
    header("Location: getplans.php");
    exit;
}

$subscription_type = $subscription['type'];
$subscription_status = $subscription['status'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/index.css">

    <style>
        #container {
            display: flex;
            /* border: 1px solid red; */
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
    </style>
</head>

<body>
    <div id="header">
        <?php include './component/pageHeader.php' ?>
    </div>
    <div id="container">
        <div style="border:1px solid white; justify-content:center; padding:20px 15px; width:50%; background-color:white; box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px; border-radius:.5rem;">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        </div>
        <div style="display: flex; width:50%; margin-top:10px; font-size:24px; font-weight:600;">
            <div style="display: flex; flex-direction:column; background-color:white; width:48%; margin-right:2%; padding:10px; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; border-radius:.5rem;">
                <text>Subscription: <?php echo $subscription_type; ?></text>
                <text>
                    Payment Status:
                    <span style="color: <?php echo ($subscription['status'] == 0) ? 'gray' : 'green'; ?>;">
                        <?php echo ($subscription['status'] == 0) ? 'Pending' : 'Accepted'; ?>
                    </span>
                </text>
            </div>
            <div style="background-color: white; width: 50%; padding: 10px; display: flex; flex-direction: row; align-items: center; box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px; border-radius:.5rem;">
                <?php if ($subscription['status'] == 1) { ?>
                    <button onclick="navigate()" style="width: 100%;  height:100%; padding: 10px; border: none; background-color: #133A1B; color: white; font-size: 16px; cursor: pointer; font-size:large; margin-right:1%">My Patients</button>
                <?php } else { ?>
                    <button onclick="showPendingMessage()" style="width: 100%;  height:100%; padding: 10px; border: none; background-color: #133A1B; color: white; font-size: 16px; cursor: pointer; font-size:large; margin-right:1%">My Patients</button>
                <?php } ?>
                <button onclick="navigateProfile()" style="width: 100%; height:100%; padding: 10px; border: none; background-color: #133A1B; color: white; font-size: 16px; cursor: pointer; font-size:large">Profile</button>
            </div>
        </div>
    </div>

    <script>
        function navigate() {
            window.location.href = "patients.php";
        }

        function navigateProfile() {
            window.location.href = "slp-profile.php";
        }

        function showPendingMessage() {
            Swal.fire({
                title: 'Please wait for admin to confirm your subscription',
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        }
    </script>

</body>

</html>