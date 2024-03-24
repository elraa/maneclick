<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>
    <link rel="stylesheet" href="wwwroot/css/main.css">
    <link rel="stylesheet" href="wwwroot/css/Signup.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a href="login.php" class="btn1">Login</a>
        </div>
    </nav>
    <main class="centered-layout">
        <section>
            <img src="wwwroot/img/logo.png" alt="A descriptive alt text for the image">
        </section>

        <section class="centered-section">
            <form method="post" action="" enctype="multipart/form-data">
                <div id="Sign-up">
                    <h1>Sign-up</h1>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="txtfname">First Name</label>
                            <input type="text" name="txtfname" required>
                        </div>
                        <div class="form-group">
                            <label for="txtlname">Last Name</label>
                            <input type="text" name="txtlname" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="txtbdate">Birtdate</label>
                            <input type="date" name="txtbdate" required>
                        </div>
                        <div class="form-group">
                            <label for="txtAdd">Address</label>
                            <input type="text" name="txtAdd" required>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label for="txtPhone">Phone Number</label>
                            <input type="tel" name="txtPhone" required>
                        </div>

                        <div class="form-group">
                            <label for="cbosex">Sex</label>
                            <select name="cbosex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label for="txtEmail">Email</label>
                            <input type="email" name="txtEmail" required>
                        </div>

                        <div class="form-group">
                            <label for="txtuname">Username</label>
                            <input type="text" name="txtuname" required>
                        </div>
                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label for="txtpass">Password</label>
                            <input type="password" name="txtpass" required>
                        </div>

                        <div class="form-group">
                            <label for="txtConfirmPass">Confirm Password</label>
                            <input type="password" name="txtConfirmPass" required>
                        </div>
                    </div>

                    <button name="btnNext" class="button">Next</button>
                </div>




                <div id="PRCID">
                    <h1>Attach PRC ID</h1>

                    <label for="fileUploader">Upload Image</label>
                    <input type="file" name="fileUploader" accept="image/*" onchange="previewImage()" required>

                    <div class="form-row">
                        <div class="preview-main-container" id="fileLabel">
                            <div class="preview-container">
                                <img id="preview" class="preview" src="#" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <label for="txtIDNumber">ID Number</label>
                    <div class="form-row">
                        <input type="text" name="txtIDNumber" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <button name="btnBack" class="button">Back</button>
                        </div>
                        <div class="form-group">
                            <button type="button" onclick="saveUserData()" class="button">Submit</button>
                        </div>
                    </div>
                </div>




            </form>
        </section>
    </main>


    <script src="wwwroot/js/signup.js"></script>


</body>

</html>