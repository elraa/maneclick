<?php
session_start(); // Start the session to manage user login state
include '../BACKEND/config/db.php';

// Check if the user is not logged in (no session exists)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the user is not an admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: homepage.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'SLP'");
$stmt->execute();
$slpUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM patients");
$stmt->execute();
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

$todayDateTime = date('Y-m-d H:i:s');

$todayDate = date('Y-m-d', strtotime($todayDateTime));
$this_month = date('Y-m');

// Query to count the rows in the users table where createdAt date is today
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE DATE(createdAt) = :today_date");
$stmt->bindParam(':today_date', $todayDate);
$stmt->execute();
$userCountToday = $stmt->fetchColumn();

// Query to count the rows in the patients table where createdAt date is today
$stmt = $conn->prepare("SELECT COUNT(*) FROM patients WHERE DATE(created_at) = :today_date");
$stmt->bindParam(':today_date', $todayDate);
$stmt->execute();
$patientCountToday = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM subscription WHERE DATE_FORMAT(createdAt, '%Y-%m') = :this_month");
$stmt->bindParam(':this_month', $this_month);
$stmt->execute();
$subcriptionCount = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT SUM(plan_cost) FROM subscription WHERE DATE_FORMAT(createdAt, '%Y-%m') = :this_month");
$stmt->bindParam(':this_month', $this_month);
$stmt->execute();
$subscriptionSum = $stmt->fetchColumn();

?>


<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div id="header">
        <?php include './component/pageHeader.php' ?>
    </div>

    <div id="loader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.7); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <img src="../FRONTEND/img/load.gif" alt="Loader" style="width:20px; height:20px">
            <p>Loading...</p>
        </div>
    </div>
    <div style="padding:20px; background-color: #E4DEAE; font-family: Arial, sans-serif;">
        <div style="display: flex; justify-content:space-between; margin-bottom:10px;">
            <h1>Welcome, Admin</h1>
        </div>


        <div id="slpTableContainer" class="table-responsive" style="width: 100%; max-height: 550px; overflow-y: auto; background-color:white; padding:10px; box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; border-radius:.5rem;">
            <table class="table table-bordered" id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Gender</th>
                        <th>Birthdate</th>
                        <th>PRC ID Number</th>
                        <th>Subcription</th>

                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($slpUsers as $user) : ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td><?php echo $user['firstname']; ?></td>
                            <td><?php echo $user['lastname']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['gender']; ?></td>
                            <td><?php echo $user['birthdate']; ?></td>
                            <td><a href="#" style="text-decoration: underline;" onclick="showPrcIdImage('<?php echo $user['prc_id']; ?>')"><?php echo $user['prc_id_no']; ?></a></td>
                            <td>
                                <?php
                                // Check if the user exists in the subscription table
                                $stmt = $conn->prepare("SELECT COUNT(*) FROM subscription WHERE user_id = :user_id");
                                $stmt->bindParam(':user_id', $user['id']);
                                $stmt->execute();
                                $subscriptionExists = $stmt->fetchColumn();

                                // Render the "View" button if the subscription exists
                                if ($subscriptionExists) {
                                    echo '<a href="#" style="text-decoration: underline;" onclick="viewSubscriptionDescription(' . $user['id'] . ')">View</a>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($user['status'] == 0) : ?>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" style="background-color: #133A1B;" type="button" id="dropdownMenuButton<?php echo $user['id']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Pending
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $user['id']; ?>">
                                            <a class="dropdown-item" href="#" onclick="confirmStatusUpdate(<?php echo $user['id']; ?>, 1)">Approve</a>
                                            <a class="dropdown-item" href="#" onclick="confirmStatusUpdate(<?php echo $user['id']; ?>, 2)">Reject</a>
                                            <a class="dropdown-item" href="#" onclick="confirmDelete(<?php echo $user['id'];?>)">Terminate</a>
                                        </div>
                                    </div>
                                <?php elseif ($user['status'] == 1) : ?>
                                    Approved
                                <?php elseif ($user['status'] == 2) : ?>
                                    Rejected
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('M d, Y h:i A', strtotime($user['createdAt'] . ' +8 hours')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="display: flex; margin-top: 1%; justify-content: space-between;">
            <div style="color: white; border: 1px solid white; padding: 10px; width: 40%;  margin-left: 5%; border-radius:.5rem; background-color:#B7BF96; box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;">
                <h2 style="font-weight:700; color:white; text-align: center;">Daily User Report</h2>
                <div style="display: flex; color:#133A1B;">
                    <div style="display: flex; justify-content: space-between; width:90%;">
                        <div>
                            <div style="font-size: 20px; padding: 10px; margin-bottom: 10px;">New Registered SLP</div>
                            <div style="font-size: 20px; padding: 10px; ">New Registered Patient</div>
                        </div>
                        <div>
                            <div style="font-size: 20px; padding: 10px; background-color: white; justify-content: center; text-align: center; margin-bottom: 10px; border-radius:.2rem;"><?php echo $userCountToday; ?></div>
                            <div style="font-size: 20px; padding: 10px; background-color: white; justify-content: center; text-align: center; border-radius:.2rem;"><?php echo $patientCountToday; ?></div>
                        </div>
                    </div>

                </div>
            </div>
            <div style="color:white; border: 1px solid white; padding: 10px; width: 40%; margin-right: 5%; border-radius:.5rem; background-color:#133A1B; box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;">
                <h2 style="font-weight:700; color:white; text-align: center;">Monthly Plans Availed</h2>
                <div style="display: flex;">
                    <div style="display: flex; justify-content: space-between; width:90%;">
                        <div>
                            <div style="font-size: 20px; padding: 10px; margin-bottom: 10px;">No. of Subscription Availed</div>
                            <div style="font-size: 20px; padding: 10px; ">Total Subscription</div>
                        </div>
                        <div style="color: #133A1B;">
                            <div style="font-size: 20px; padding: 10px; background-color: white; justify-content: center; text-align: center; margin-bottom: 10px; border-radius:.2rem;"><?php echo $subcriptionCount; ?></div>
                            <div style="font-size: 20px; padding: 10px; background-color: white; justify-content: center; text-align: center; border-radius:.2rem;">₱ <?php echo $subscriptionSum; ?></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="prcIdModal" tabindex="-1" aria-labelledby="prcIdModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prcIdModalLabel">PRC ID Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="prcIdImage" src="" class="img-fluid" alt="PRC ID Image" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subscriptionModalLabel">Subscription Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="subscriptionDetails">
                    <!-- Subscription details will be populated here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            document.getElementById('loader').style.display = 'none';
        });

        $(document).ready(function() {
            $('#userTable').DataTable();
        });

        $(document).ready(function() {
            $('#patientsTable').DataTable();
        });


        var slpTableContainer = document.getElementById('slpTableContainer');
        var userTypeSelector = document.getElementById('userTypeSelector');

        function showPrcIdImage(prcIdFilePath) {
            // Set the image source attribute
            console.log(prcIdFilePath)
            document.getElementById('prcIdImage').src = prcIdFilePath;
            // Show the modal
            $('#prcIdModal').modal('show');
        }

        function confirmStatusUpdate(userId, newStatus) {
            var confirmation = confirm("Are you sure you want to change the status?");
            if (confirmation) {
                // Construct the request body
                const formData = new FormData();
                formData.append('user_id', userId);
                formData.append('new_status', newStatus);
                // console.log(newStatus)

                // Send the fetch request
                fetch('../BACKEND/routes/update_status_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.status === 200) {
                            // Show success message using SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'User status updated successfully.'
                            }).then((result) => {
                                // Reload the page after successful update
                                location.reload();
                            });
                        } else {
                            // Show error message using SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update user status.'
                            });
                        }
                    })
                    .catch(error => {
                        // Show error message using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your request.'
                        });
                        console.error('Error:', error);
                    });
            }
        }

        function confirmDelete(userId) {
            var confirmation = confirm("Are you sure you want to delete this user?");
         
            if (confirmation) {
                const formData = new FormData();
                formData.append('id', userId);
                console.log(formData)

                // Send the fetch request
                fetch('../BACKEND/routes/delete_slp_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.status === 200) {
                            // Show success message using SweetAlert
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'User deleted successfully.'
                            }).then((result) => {
                                // Reload the page after successful update
                                location.reload();
                            });
                        } else {
                            // Show error message using SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete user.'
                            });
                        }
                    })
                    .catch(error => {
                        // Show error message using SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while processing your request.'
                        });
                        console.error('Error:', error);
                    });
            }
        }

        function viewSubscriptionDescription(userId) {
            // Make AJAX request to get subscription information
            $.ajax({
                url: '../BACKEND/routes/get_subscription.php',
                type: 'GET',
                data: {
                    user_id: userId
                },
                dataType: 'json',
                success: function(response) {
                    // Update the Bootstrap modal with subscription details
                    if (response.error) {
                        alert('Error: ' + response.error);
                    } else {
                        var createdAtDate = new Date(response.createdAt);

                        createdAtDate.setHours(createdAtDate.getHours() + 8);
                        var formattedCreatedAt = createdAtDate.toLocaleString();
                        // Construct the HTML for the subscription details
                        var html = '<p><strong>Subscription Type:</strong> ' + response.type + '</p>';
                        html += '<p><strong>Subscription Cost:</strong> ' + response.plan_cost + '</p>';
                        // html += '<p><strong>Account Number:</strong> ' + response.s_account_number + '</p>';
                        // html += '<p><strong>Account Name:</strong> ' + response.s_account_name + '</p>';
                        // html += '<p><strong>Payment Reference Number:</strong> ' + response.payrefnumber + '</p>';
                        html += '<p><strong>Created At:</strong> ' + formattedCreatedAt + '</p>';

                        // Update the modal body with the subscription details
                        $('#subscriptionDetails').html(html);

                        // Show the Bootstrap modal
                        $('#subscriptionModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while fetching subscription information.');
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>

</html>