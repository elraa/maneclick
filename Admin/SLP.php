<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<?php
include "Modules/connection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "CALL get_slp";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}
?>

<section class="section-top">
    <table id="myDataTable">

        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Birthdate</th>
                <th>Email</th>
                <th>contactNum</th>
                <th>isActive</th>
                <th>subscriptiontype</th>
                <th>PRC License No</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
            <tr>
                <td><?= $row['ID'] ?></td>
                <td><?= $row['Fname'] ?></td>
                <td><?= $row['Lname'] ?></td>
                <td><?= $row['Username'] ?></td>
                <td><?= $row['Birthdate'] ?></td>
                <td><?= $row['Email'] ?></td>
                <td><?= $row['contactNum'] ?></td>
                <td><?= $row['SLPStatus'] ?></td>
                <td><?= $row['subscriptiontype'] ?></td>
                <td><a href="#" class="openModalBtn"
                        data-modal-id="myModal<?= $row['ID'] ?>"><?= $row['IDNumber'] ?></a></td>
                <td>
                    <a href="#" title="Edit"><i class="fas fa-edit" title="Edit"></i></a>
                    <a href="#" title="Delete"><i class="fas fa-trash" title="Delete"></i></a>
                </td>
            </tr>

            <div id="myModal<?= $row['ID'] ?>" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeModalBtn">&times;</span>
                    <h2>PRC License ID Preview</h2>
                    <p>ID Number: <?= $row['IDNumber'] ?> </p>
                    <div class="preview-container">
                        <img src="../wwwroot/img/license/<?= $row['IDPath'] ?>" alt="PRC ID Preview" class="preview"
                            id="preview">
                    </div>



                    <?php
            if ($row['isActive'] == 0) {
            ?>
                    <div class="PRCbuttons">
                        <button class="approveBtn" data-modal-id="<?= $row['ID'] ?>">Approve</button>
                        <button class="disapproveBtn" data-modal-id="<?= $row['ID'] ?>">Disapprove</button>
                    </div>
                    <?php
            }
            ?>
                </div>


            </div>

            <?php
            }
            ?>
        </tbody>
    </table>
</section>

<script src="wwwroot/js/modal.js"></script>

<script>
$(document).ready(function() {

    $("#myDataTable").DataTable({
        "scrollX": true,
        "autoWidth": false
    });
});
</script>