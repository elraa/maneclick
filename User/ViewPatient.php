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
    <link rel="stylesheet" href="wwwroot/css/viewpatient.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <nav>
        <div class="nav-left">
            <a href="Index.php" class="btn1">Home</a>
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
            <div class="centered-section-columns">
                <div class="centered-section-row">
                    <div class="buttons-container">
                        <button class="buttons" id="btnMyPatient" name="btnData"
                            onclick="window.location.href='MyPatient.php'">
                            Data Sheet </button>
                    </div>

                    <div class="buttons-container">
                        <button class="buttons" id="btnMyPatient" name="btnGraph"
                            onclick="window.location.href='MyPatient.php'">
                            Graph Sheet </button>
                    </div>

                    <div class="buttons-container">
                        <button class="buttons" id="btnMyPatient" name="btnSummative"
                            onclick="window.location.href='MyPatient.php'">
                            Generate Summative Report </button>
                    </div>

                    <div class="buttons-container">
                        <button class="buttons" id="btnMyPatient" name="btnSession"
                            onclick="window.location.href='Datasheet.php?PID=<?php echo $PID; ?>';">
                            New Session
                        </button>
                    </div>
                </div>
            </div>

            <div class="centered-section-columns">
                <div class="centered-section-columns-columns">
                    <div class="centered-section-row">
                        <h1> Patient Info </h1>
                        <hr>
                    </div>
                    <div class="centered-section-columns-columns-row">
                        <div class="centered-section-columns-columns-row-columns">
                            <label> Last Name: </label>
                        </div>
                        <div class="centered-section-columns-columns-row-columns">

                            <label> <?php echo $row["lname"]; ?></label>
                        </div>
                    </div>
                    <div class="centered-section-columns-columns-row">
                        <div class="centered-section-columns-columns-row-columns">
                            <label> First Name: </label>
                        </div>
                        <div class="centered-section-columns-columns-row-columns">
                            <label> <?php echo $row["fname"]; ?></label>
                        </div>
                    </div>
                    <div class="centered-section-columns-columns-row">
                        <div class="centered-section-columns-columns-row-columns">
                            <label> Birth Date: </label>
                        </div>
                        <div class="centered-section-columns-columns-row-columns">
                            <label> <?php echo $row["birthdate"]; ?></label>
                        </div>
                    </div>
                    <div class="centered-section-columns-columns-row">
                        <div class="centered-section-columns-columns-row-columns">
                            <label> Address: </label>
                        </div>
                        <div class="centered-section-columns-columns-row-columns">
                            <label> <?php echo $row["address"]; ?></label>
                        </div>
                    </div>
                    <div class="centered-section-columns-columns-row">
                        <div class="centered-section-columns-columns-row-columns">
                            <label> Disorder: </label>
                        </div>
                        <div class="centered-section-columns-columns-row-columns">
                            <label> <?php echo $row["disorder"]; ?></label>
                        </div>
                    </div>
                    <div class="centered-section-columns-columns-row">
                        <div class="centered-section-columns-columns-row-columns">
                            <label> Guardian: </label>
                        </div>
                        <div class="centered-section-columns-columns-row-columns">
                            <label> <?php echo $row["guardian"]; ?></label>
                        </div>
                    </div>
                    <div class="centered-section-columns-columns-row">
                        <div class="centered-section-columns-columns-row-columns">
                            <label> Contact Number: </label>
                        </div>
                        <div class="centered-section-columns-columns-row-columns">
                            <label> <?php echo $row["contactNum"]; ?></label>
                        </div>
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

                <div class="centered-section-columns-columns">
                    <div class="centered-section-row">
                        <h1> Therapy History </h1>
                        <hr>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <script src="wwwroot/js/login.js"></script>
</body>

</html>