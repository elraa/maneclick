<?php
include "Modules/connection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM patients";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}
?>

<section class="section-top">
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
                    <a href="#" title="View Profile">View Profile</a>
                </td>
            </tr>
            <?php
                    }
                    ?>
        </tbody>
    </table>
</section>

<script>
$(document).ready(function() {
    $("#myDataTable").DataTable({
        "scrollX": true,
        "autoWidth": false
    });
});
</script>