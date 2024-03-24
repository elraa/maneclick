<?php
    include "Modules/auth.php";
    include "Modules/connection.php";

    if (isset($_GET['PID'], $_SESSION['SLPID'])) {
        
    $PID = $_GET['PID'];
    $slpID = $_SESSION['SLPID'];

    $stmt = $conn->prepare("SELECT * FROM patients WHERE ID = ? AND slpID = ?");
    $stmt->bind_param("ii", $PID, $slpID);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>
    <link rel="stylesheet" href="wwwroot/css/main.css">
    <link rel="stylesheet" href="wwwroot/css/addpatient.css">
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
            <a href="MyPatient.php" class="btn1">Back</a>
        </div>
    </nav>
    <main class="centered-layout">
        <section class="centered-section">
            <form method="post" onsubmit="event.preventDefault(); UpdateRecord();">
                <h1>Patient Information</h1>
                <div class="form-row">
                    <div class="form-group">
                        <label for="txtlname">Last Name</label>
                        <input type="text" name="txtlname"
                            value="<?php echo isset($row["lname"]) ? $row["lname"] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="txtfname">First Name</label>
                        <input type="text" name="txtfname"
                            value="<?php echo isset($row["fname"]) ? $row["fname"] : ''; ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="txtBdate">Birthdate</label>
                        <input type="date" name="txtBdate"
                            value="<?php echo isset($row["birthdate"]) ? $row["birthdate"] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="txtAdd">Address</label>
                        <input type="text" name="txtAdd"
                            value="<?php echo isset($row["address"]) ? $row["address"] : ''; ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="txtDisorder">Disorder</label>
                        <input type="text" name="txtDisorder"
                            value="<?php echo isset($row["disorder"]) ? $row["disorder"] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="txtGuardian">Guardian's Name</label>
                        <input type="text" name="txtGuardian"
                            value="<?php echo isset($row["guardian"]) ? $row["guardian"] : ''; ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cbosex">Sex</label>
                        <select name="cbosex" required>
                            <option value="Male"
                                <?php echo isset($row["sex"]) && $row["sex"] === "Male" ? 'selected' : ''; ?>>Male
                            </option>
                            <option value="Female"
                                <?php echo isset($row["sex"]) && $row["sex"] === "Female" ? 'selected' : ''; ?>>Female
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtCPNo">Contact Number</label>
                        <input type="tel" name="txtCPNo"
                            value="<?php echo isset($row["contactNum"]) ? $row["contactNum"] : ''; ?>" required>
                    </div>
                </div>

                <?php 
                      }
                        $result->close();
                        $stmt->close();
                        $conn->close();
                    } else {
                        echo "Error: Required session variables are not set.";
                    }
                ?>

                <input type="submit" name="btnsubmit" value="Save Patient">
            </form>
        </section>
    </main>
    <script src="wwwroot/js/SLP.js"></script>
</body>

</html>