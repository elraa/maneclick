<?php
include "Modules/includes.php";

$monthlyTotalSLP = getMonthlyCountSLP($conn);
$yearlyTotalSLP = getYearlyCountSLP($conn);
$monthlyTotalPatient = getMonthlyCountPatient($conn);
$yearlyTotalPatient = getYearlyCountPatient($conn);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>
</head>

<body>
    <nav>
        <div class="nav-left">
            <a href="index.php" class="btn2">Home</a>
            <h1>Mane Click - Admin Dashboard</h1>

            <select id="roleDropdown">
                <option value="SLP">SLP</option>
                <option value="Patient">Patient</option>
            </select>
        </div>
        <div class="nav-right">
            <a href="modules/logout.php" class="btn2">Logout</a>
        </div>
    </nav>
    <main class="centered-layout">
        <section id="mainContent">
        </section>
    </main>

    <footer class="footer ">
        <section class="section-left">
            <h1> Monthly Report </h1>
            <table>
                <tr>
                    <td>New Regististrations</td>
                    <td><?php echo $monthlyTotalSLP; ?></td>
                </tr>
                <tr>
                    <td>New Clients</td>
                    <td><?php echo $yearlyTotalPatient; ?></td>
                </tr>
            </table>
        </section>

        <section class="section-right">
            <h1> Annual Report </h1>
            <table>
                <tr>
                    <td>New Regististrations</td>
                    <td><?php echo $yearlyTotalSLP; ?></td>
                </tr>
                <tr>
                    <td>New Clients</td>
                    <td><?php echo $yearlyTotalPatient; ?></td>
                </tr>
            </table>
        </section>
    </footer>

    <script src="wwwroot/js/main.js"></script>
</body>

</html>