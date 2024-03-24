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
            <form method="post" onsubmit="event.preventDefault(); Create();">
                <h1>Patient Information</h1>
                <div class="form-row">
                    <div class="form-group">
                        <label for="txtlname">Last Name</label>
                        <input type="text" name="txtlname" required>
                    </div>
                    <div class="form-group">
                        <label for="txtfname">First Name</label>
                        <input type="text" name="txtfname" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="txtBdate">Birthdate</label>
                        <input type="date" name="txtBdate" required>
                    </div>
                    <div class="form-group">
                        <label for="txtAdd">Address</label>
                        <input type="text" name="txtAdd" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="txtDisorder">Discorder</label>
                        <input type="text" name="txtDisorder" required>
                    </div>
                    <div class="form-group">
                        <label for="txtGuardian">Guardian's Name</label>
                        <input type="text" name="txtGuardian" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cbosex">Sex</label>
                        <select name="cbosex" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtCPNo">Contact Number</label>
                        <input type="tel" name="txtCPNo" required>
                    </div>
                </div>

                <input type="submit" name="btnsubmit" value="Save Patient">
            </form>
        </section>
    </main>
    <script src="wwwroot/js/SLP.js"></script>
</body>

</html>