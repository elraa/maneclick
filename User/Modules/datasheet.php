<?php
include "connection.php";

if (isset($_POST['PName'], $_POST['PID'], $_POST['PSex'], $_POST['SLP'], $_POST['PDisorder'], $_POST['DSID'], $_POST['EvalDate'], $_POST['ValidDate'], $_POST['FTDate'], $_POST['TargetDate'], $_POST['txtInterpretation'], $_POST['txtFuncOut'])) {
    session_start();

    $PName = $_POST['PName'];
    $PID = $_POST['PID'];
    $PSex = $_POST['PSex'];
    $SLP = $_POST['SLP'];
    $PDisorder = $_POST['PDisorder'];
    $DSID = $_POST['DSID'];
    $EvalDate = $_POST['EvalDate'];
    $ValidDate = $_POST['ValidDate'];
    $FTDate = $_POST['FTDate'];
    $TargetDate = $_POST['TargetDate'];
    $slpID = $_SESSION['SLPID'];
    $txtInterpretation = $_POST['txtInterpretation'];
    $txtFuncOut = $_POST['txtFuncOut'];

    $stmtPatients = $conn->prepare("INSERT INTO datasheet (PatientID, SLPID, Eval_Date, Valid_Til, Interpretation, FuncOutcome) VALUES (?, ?, ?, ?, ?, ?)");
    $stmtPatients->bind_param("iissss", $PID, $slpID, $EvalDate, $ValidDate, $txtInterpretation, $txtFuncOut);

    $stmtDatasheetItems = $conn->prepare("INSERT INTO datasheet_items (DSID, Particular, PromptID, Remarks) VALUES (?, ?, ?, ?)");

    $conn->begin_transaction();

    try {
        $stmtPatients->execute();

        if ($stmtPatients->error) {
            throw new Exception("Error in patients table query: " . $stmtPatients->error);
        }

        $lastInsertID = $conn->insert_id;

        for ($i = 0; $i < count($_POST['inputText']); $i++) {
            $Particular = $_POST['inputText'][$i];
            $PromptID = $_POST['dropdown'][$i];
            $Remarks = $_POST['inputText'][$i];

            $stmtDatasheetItems->bind_param("isss", $lastInsertID, $Particular, $PromptID, $Remarks);
            $stmtDatasheetItems->execute();

            if ($stmtDatasheetItems->error) {
                throw new Exception("Error in datasheet_items table query: " . $stmtDatasheetItems->error);
            }
        }

        $conn->commit();

        echo "Data inserted successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $stmtPatients->close();
    $stmtDatasheetItems->close();
    $conn->close();
} else {
    echo "Error: All form fields are required.";
}
?>