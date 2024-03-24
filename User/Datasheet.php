<?php

    session_start();

    include "Modules/auth.php";
    include "Modules/connection.php";

    if (isset($_GET['PID'], $_SESSION['SLPID'])) {
        
    $PID = $_GET['PID'];
    $slpID = $_SESSION['SLPID'];

    $stmt = $conn->prepare("CALL sp_datasheet(?,?)");
    $stmt->bind_param("ii", $slpID, $PID);
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        
?>

<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>
    <link rel="stylesheet" href="wwwroot/css/main.css">
    <link rel="stylesheet" href="wwwroot/css/datasheet.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <nav>
        <div class="nav-left">
            <a href="Index.php" class="btn1">Home</a>
            <a href="MyPatient.php" class="btn1">Back</a>
        </div>
        <div class="nav-center">
            <h1>MANE Click</h1>
        </div>
        <div class="nav-right">
            <a id="saveButton" class="btn1" onclick="event.preventDefault(); createPatient();">Save</a>
            <a href="#" class="btn1">Print</a>
        </div>
    </nav>

    <main class="centered-layout">

        <form method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for=PName> Patient Name</label>
                    <input type="text" name="PName" value="<?php echo isset($row["PName"]) ? $row["PName"] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="PID"> Patient ID</label>
                    <input type="text" name="PID" value="<?php echo isset($row["PID"]) ? $row["PID"] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="PSex"> Patient Sex</label>
                    <input type="text" name="PSex" value="<?php echo isset($row["PSex"]) ? $row["PSex"] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="SLP"> SLP</label>
                    <input type="text" name="SLP" value="<?php echo isset($row["SLPName"]) ? $row["SLPName"] : ''; ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for=PDisorder> Disorder</label>
                    <input type="text" name="PDisorder"
                        value="<?php echo isset($row["PDisorder"]) ? $row["PDisorder"] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="DSID"> Datasheet ID</label>
                    <input type="text" name="DSID" value="">
                </div>
                <div class="form-group">
                    <label for="EvalDate"> Date of Evaluation</label>
                    <input type="date" name="EvalDate" value="">
                </div>
                <div class="form-group">
                    <label for="ValidDate"> Valid Until</label>
                    <input type="date" name="ValidDate" value="">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for=FTDate> First Therapy Date</label>
                    <input type="date" name="FTDate" value="">
                </div>
                <div class="form-group">
                    <label for="TargetDate"> Target Finish Date</label>
                    <input type="date" name="TargetDate" value="">
                </div>
                <div class="form-group"></div>
                <div class="form-group"></div>
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

            <hr>

            <div class="div-table">
                <table id="dataTable" class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Word</th>
                            <th>Score</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be dynamically added here -->
                    </tbody>
                </table>

                <button type="button" class="frmButton" id="addRowButton">Add New Row</button>

                <script src="wwwroot/js/datasheet.js"></script>
            </div>

            <hr>

            <div class="textarea-div-container">
                <div class=" div-textarea">
                    <label for="txtInterpretation"> Interpretation</label>
                    <textarea name="txtInterpretation"></textarea>
                </div>

                <div class="div-textarea">
                    <label for="txtFuncOut"> Functional Outcome</label>
                    <textarea name="txtFuncOut"></textarea>
                </div>
            </div>

        </form>
    </main>
</body>

</html>