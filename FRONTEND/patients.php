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
$stmt = $conn->prepare("SELECT * FROM subscription WHERE user_id = :user_id AND status = 1");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$subscription = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM patients WHERE slp_id =  $user_id ");
$stmt->execute();
$patientsInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If subscription doesn't exist
if (!$subscription) {
    header("Location: homepage.php");
    exit;
}

$selectedStatus = $_POST['patientStatus'] ?? 'active';

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);  
$stmt->execute();
$userDets = $stmt->fetch(PDO::FETCH_ASSOC);

// Filter patients based on the selected status
$filteredPatients = array_filter($patientsInfo, function($patient) use ($selectedStatus) {
    return $patient['status'] === $selectedStatus;
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
</head>

<body>
    <div id="header">
        <?php include './component/pageHeader.php' ?>
    </div>
    <div style="padding:20px; background-color: #E4DEAE; font-family: Arial, sans-serif;">
        <div style="display: flex; flex-direction: row; align-items:center; justify-content:space-between">
            <h1>My Patients</h1>
            <div style="display:flex; flex-direction:row; align-items:center;">
                <form method="POST" action="" class="mb-3 mr-4">
                    <select class="form-control" id="patientStatusFilter" name="patientStatus" onchange="this.form.submit()">
                        <option value="active" <?= ($selectedStatus === 'active') ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($selectedStatus === 'inactive') ? 'selected' : '' ?>>Archived</option>
                    </select>
                </form>
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPatientModal" style="background-color:#133A1B">
                    Add Patient
                </button>
               
            </div>
        </div>

        <div class="table-responsive" style="width: 100%; max-height: 560px; overflow-y: auto; background-color:white; padding:10px; box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px; border-radius:.5rem;">
            <table class="table table-bordered" id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Disorder</th>
                        <th>Sex</th>
                        <th>Birthdate</th>
                        <th>Address</th>
                        <th>Guardian</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($filteredPatients as $patient) : ?>
                        <tr data-id="<?php echo $patient['id']; ?>">
                            <td><?php echo $patient['id'] ?></td>
                            <td><?php echo $patient['fname'] ?></td>
                            <td><?php echo $patient['lname'] ?></td>
                            <td><?php echo $patient['email'] ?></td>
                            <td><?php echo $patient['disorder'] ?></td>
                            <td><?php echo $patient['sex'] ?></td>
                            <td><?php echo $patient['birthdate'] ?></td>
                            <td><?php echo $patient['address'] ?></td>
                            <td><?php echo $patient['guardian'] ?></td>
                            <td><?php echo $patient['status'] ?></td>
                            <td><?php echo date('M d, Y h:i A', strtotime($patient['created_at'] . ' +8 hours')); ?></td>
                            <td>
                                <!-- Action icons -->
                                <a href="#" class="text-info mr-2" name="viewPatientBtn" id="viewPatientBtn"><i class="fas fa-eye"></i></a> <!-- View icon -->
                                <a href="#" id="editPatientBtn" name="editPatientBtn" class="text-primary editPatientBtn" data-id="<?php echo $patient['id']; ?>"><i class="fas fa-edit"></i></a>
                                <a href="#" class="text-danger delete-btn" data-id="<?php echo $patient['id']; ?>"><i class="fas fa-trash-alt"></i></a> <!-- Delete icon -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Patient Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to edit patient details -->
                    <form id="editPatientForm" method="post">
                        <!-- Hidden input field to store patient ID -->
                        <input type="hidden" id="editPatientId" name="id">
                        <!-- First Name -->
                        <div class="form-group">
                            <label for="editFirstName">First Name</label>
                            <input type="text" class="form-control" id="editFirstName" name="editfname" readonly required>
                        </div>
                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="editLastName">Last Name</label>
                            <input type="text" class="form-control" id="editLastName" name="editlname" 
                                 readonly required>
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="editemail" required>
                        </div>
                        <!-- Disorder -->
                        <div class="form-group">
                            <label for="editDisorder">Disorder</label>
                            <input type="text" class="form-control"  id="editDisorder" name="editdisorder" required>
                        </div>
                        <!-- Sex -->
                        <div class="form-group">
                            <label for="editSex">Sex</label>
                            <select class="form-control" id="editSex" name="editsex"  value="<?php echo htmlspecialchars($userDets['sex']);?>" readonly required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <!-- Birthdate -->
                        <div class="form-group">
                            <label for="editBirthdate">Birthdate</label>
                            <input type="date" class="form-control" id="editBirthdate" name="editbirthdate" readonly required>
                        </div>
                        <!-- Address -->
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="editaddress" required>
                        </div>
                        <!-- Guardian -->
                        <div class="form-group">
                            <label for="editGuardian">Guardian</label>
                            <input type="text" class="form-control" id="editGuardian" name="editguardian" required>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus" name="editstatus" required>
                                <option value="active">Active</option>
                                <option value="inactive">Archive</option>
                            </select>
                        </div>
                        <!-- Submit and close modal buttons -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Patient Modal -->
    <div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to add a new patient -->
                    <form id="addPatientForm" method="post">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="disorder">Disorder</label>
                            <input type="text" class="form-control" id="disorder" name="disorder" required>
                        </div>
                        <div class="form-group">
                            <label for="sex">Sex</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Birthdate</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="form-group">
                            <label for="guardian">Guardian</label>
                            <input type="text" class="form-control" id="guardian" name="guardian" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" style="background-color:#133A1B">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>



        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#userTable').DataTable();
            });
            //add nyo lang to
            document.addEventListener('DOMContentLoaded', function() {
                var today = new Date().toISOString().split('T')[0];
                document.getElementById('birthdate').setAttribute('max', today);
            });
            //

            $(document).on("click", ".editPatientBtn", function() {
                // Retrieve data from the clicked row
                var patientId = $(this).data("id");
                var row = $(this).closest('tr');
                var firstName = row.find('td:nth-child(2)').text();
                var lastName = row.find('td:nth-child(3)').text();
                var email = row.find('td:nth-child(4)').text();
                var disorder = row.find('td:nth-child(5)').text();
                var sex = row.find('td:nth-child(6)').text();
                var birthdate = row.find('td:nth-child(7)').text();
                var address = row.find('td:nth-child(8)').text();
                var guardian = row.find('td:nth-child(9)').text();
                var status = row.find('td:nth-child(10)').text();

                // Populate modal inputs with retrieved data
                $('#editPatientId').val(patientId);
                $('#editFirstName').val(firstName);
                $('#editLastName').val(lastName);
                $('#editEmail').val(email);
                $('#editDisorder').val(disorder);
                $('#editSex').val(sex);
                $('#editBirthdate').val(birthdate);
                $('#editAddress').val(address);
                $('#editGuardian').val(guardian);
                $('#editStatus').val(status);

                // Open the edit patient modal
                $('#editPatientModal').modal('show');
            });

            document.getElementById('patientStatusFilter').addEventListener('change', function() {
                    this.form.submit();
            });

            $(document).on("click", "#viewPatientBtn", function(event) {
                event.preventDefault(); // Prevent default link behavior

                // Retrieve data from the clicked row
                var patientId = $(this).closest('tr').data("id");

                // // Set the patient ID in localStorage
                // localStorage.setItem('patientId', patientId);

                // Redirect to patient-profile.php
                window.location.href = 'patient-profile.php?pid=' + encodeURIComponent(patientId);
            });

            $(document).on("click", "#viewPatientBtn", function(event) {
                event.preventDefault(); // Prevent default link behavior

                // Retrieve data from the clicked row
                var patientId = $(this).closest('tr').data("id");

                // Redirect to session-profile.php
                window.location.href = 'patient-profile.php?pid=' + encodeURIComponent(patientId);
            });


            $('#editPatientForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Serialize the form data
                var formData = $(this).serialize();
                console.log(formData)

                // Send a POST request using AJAX
                $.ajax({
                    url: '../BACKEND/routes/update_patient_process.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Display success message using Swal.fire
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response,
                        }).then(function() {
                            window.location.reload()
                        })
                    },
                    error: function(xhr, status, error) {
                        // Display error message using Swal.fire
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while updating patient details',
                        });
                        console.error('Error:', error);
                    }
                });
            });

            document.getElementById("addPatientForm").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission

                var form = this; // Reference to the form element
                var formData = new FormData(form);

                // Send a POST request using fetch
                fetch('../BACKEND/routes/add_patient_process.php', {
                        method: form.method,
                        body: formData
                    })
                    .then(function(response) {
                        // Check if the response status is 200
                        if (response.status === 200) {
                            // Display success message using Swal.fire
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'New patient added successfully',
                            }).then(function() {
                                window.location.reload()
                            })
                        } else {
                            // Display error message using Swal.fire
                            //eto gawin nyong ganito oks
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Birthdate cannot be in the future.',
                            });
                        }
                    })
                    .catch(function(error) {
                        // Handle errors
                        // Display error message using Swal.fire
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while adding the patient',
                        });
                        console.error('Error:', error);
                    });
            });

            $(document).on("click", ".delete-btn", function() {
                var patientId = $(this).data("id");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../BACKEND/routes/delete_patient_process.php',
                            method: 'POST',
                            data: {
                                id: patientId
                            },
                            success: function(response) {
                                // If the deletion is successful, remove the row from the table
                                if (response) {
                                    Swal.fire(
                                        'Deleted!',
                                        'The patient has been deleted.',
                                        'success'
                                    ).then(function() {
                                        window.location.reload()
                                    })
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete the patient.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the patient.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        </script>
</body>

</html>