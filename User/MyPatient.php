<?php
include "Modules/includes.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming $_SESSION['SLPID'] is set, and proper sanitization/validation is done
$slpID = mysqli_real_escape_string($conn, $_SESSION['SLPID']);

$query = "SELECT * FROM patients WHERE slpID = '$slpID'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav>
        <div class="nav-left">
            <a href="index.php" class="btn2">Home</a>
        </div>
        <div class="nav-center">
            <h1>MANE Click</h1>
        </div>
        <div class="nav-right">
            <a href="index.php" class="btn1">Back</a>
        </div>
    </nav>
    <main class="centered-layout">
        <section class="section-top">
            <h1> My Patients </h1>
            <a href="AddPatient.php"> Add Patient </a>

            <table id="myDataTable">
                <thead>
                    <tr>
                        <th hidden>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Birthdate</th>
                        <th>Disorder</th>
                        <th>Guardian</th>
                        <th>Status</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                    <tr>
                        <td hidden><?= $row['ID'] ?></td>
                        <td><?= $row['fname'] ?></td>
                        <td><?= $row['lname'] ?></td>
                        <td><?= $row['birthdate'] ?></td>
                        <td><?= $row['disorder'] ?></td>
                        <td><?= $row['guardian'] ?></td>
                        <td><?= $row['isActive'] ?></td>
                        <td>
                            <a href="ViewPatient.php?PID=<?= $row['ID'] ?>" title="View Profile">View Profile</a>
                            <a href="UpdatePatient.php?PID=<?= $row['ID'] ?>" title="Edit"><i class="fas fa-edit"
                                    title="Edit"></i></a>
                            <a href="#" title="Delete" onclick="deletePatient(<?= $row['ID'] ?>)"><i
                                    class="fas fa-trash" title="Delete"></i></a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <script src="wwwroot/js/SLP.js"></script>
        <script>
        $(document).ready(function() {
            $("#myDataTable").DataTable({});
        });
        </script>
    </main>

</body>

</html>