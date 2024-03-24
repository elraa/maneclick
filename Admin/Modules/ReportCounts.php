<?php
// SLP REPORTS ====================================
function getMonthlyCountSLP($connection) {
    $queryMonthly = "SELECT COUNT(*) AS monthly_total FROM slp WHERE EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE) AND EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)";
    $resultMonthly = mysqli_query($connection, $queryMonthly);
    $rowMonthly = mysqli_fetch_assoc($resultMonthly);
    return $rowMonthly['monthly_total'];
}

function getYearlyCountSLP($connection) {
    $queryYearly = "SELECT COUNT(*) AS yearly_total FROM slp WHERE EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)";
    $resultYearly = mysqli_query($connection, $queryYearly);
    $rowYearly = mysqli_fetch_assoc($resultYearly);
    return $rowYearly['yearly_total'];
}

// PATIENTS REPORTS ====================================
function getMonthlyCountPatient($connection) {
    $queryMonthly = "SELECT COUNT(*) AS monthly_total FROM Patients WHERE EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE) AND EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)";
    $resultMonthly = mysqli_query($connection, $queryMonthly);
    $rowMonthly = mysqli_fetch_assoc($resultMonthly);
    return $rowMonthly['monthly_total'];
}

function getYearlyCountPatient($connection) {
    $queryYearly = "SELECT COUNT(*) AS yearly_total FROM Patients WHERE EXTRACT(YEAR FROM created_at) = EXTRACT(YEAR FROM CURRENT_DATE)";
    $resultYearly = mysqli_query($connection, $queryYearly);
    $rowYearly = mysqli_fetch_assoc($resultYearly);
    return $rowYearly['yearly_total'];
}
?>