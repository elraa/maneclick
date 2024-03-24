<?php
    include "Modules/auth.php";

?>

<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>
    <link rel="stylesheet" href="wwwroot/css/main.css">
    <link rel="stylesheet" href="wwwroot/css/index.css">

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
            <a href="viewplans.php" class="btn2">View Plans</a>
            <a href="modules/logout.php" class="btn2">Logout</a>
        </div>
    </nav>
    <main class="centered-layout">
        <section class="centered-section">
            <div class="centered-section-welcome">
                <h1> WELCOME, <?php echo $_SESSION['Fname']; ?>!</h1>
            </div>

            <div class="centered-section-row">
                <div class="centered-section-columns">
                    <h3> Substription: <?php echo $_SESSION['SubsType']; ?></h3>
                    <h3> Payment Status: </h3>
                </div>

                <div class="centered-section-columns">
                    <div class="buttons-container">
                        <button class="buttons" id="btnMyPatient" name="btnMyPatient"
                            onclick="window.location.href='MyPatient.php'"> My
                            Patients </button>
                        <button class="buttons" id="btnMyProfile" name="btnMyProfile"> My Profile </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <h3> Contact us </h3>

            <div class="footer-columns">
                <div class="footer-rows">
                    <p><i class="fas fa-envelope"></i> abc@gmail.com</p>
                    <p><i class="fas fa-envelope"></i> abc@gmail.com</p>
                </div>

                <div class="footer-rows">
                    <p><i class="fas fa-envelope"></i> abc@gmail.com</p>
                    <p><i class="fas fa-envelope"></i> abc@gmail.com</p>
                </div>
            </div>
        </div>

    </footer>
</body>

</html>