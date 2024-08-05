<?php
session_start();

// Check if session exists
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="./css/index.css"> -->
    <link rel="stylesheet" href="./css/signup.css">
    <title>Document</title>
</head>

<body style="background-color: #E4DEAE;">
    <div id="header">
        <?php include './component/loginHeader.php' ?>
    </div>

    <div class="main-content" style="display: flex;">
        <div class="img-container">
            <img src="./img/maneclick_logo.png" alt="Mane Click Logo">
        </div>
        <div class="signup-container" style="background-color: rgba(255, 255, 255, 0.5);">
            <div class="signup-main">
                <form method="post" id="signupForm">
                    <h1>Sign Up</h1>
                    <div class="input-row">
                        <input type="text" name="firstname" placeholder="First Name" required>
                        <input type="text" name="lastname" placeholder="Last Name" required>
                    </div>
                    <div class="input-row">
                        <input type="date" name="birthdate" placeholder="Birthdate" required>
                        <input type="text" name="address" placeholder="Address" required>
                    </div>
                    <div class="input-row">
                        <input type="text" name="phone" placeholder="Phone Number (e.g. 09123456789) " pattern="[0-9]{11}" required>
                        <select name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="input-row">
                        <input type="text" name="email" placeholder="Email" required>
                        <input type="text" name="username" placeholder="Username" minlength="6" required >
                    </div>
                    <div class="input-row">
                        <input type="password" name="password" placeholder="Password" minlength="6" required >
                        <input type="password" name="cpassword" placeholder="Confirm Password" minlength="6" required>
                    </div>
                    <button type="submit">Next</button>
                </form>
                <p>Already have an account? <a href="login.php">Log in here</a></p>
            </div>
        </div>
    </div>
    <div class="submit-id" style="display: none;" id="submit-id">
        <div class="id-container">
            <form method="post" id="prcId">
                <h3 style="margin-bottom: 10px; text-align: center;">PLEASE SUBMIT YOUR PRC ID</h3>
                <input type="file" name="idFile" placeholder="Upload ID" required>
                <input type="text" name="id-no" placeholder="ID NUMBER" minlength="8" maxlength="8" required>
                <p style="color: gray;">The id will be used by admin to verify your account.</p>
                <button type="submit">Sign up</button>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById("signupForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var form = this;
            fetch('../BACKEND/routes/signup_process.php', {
                    method: form.method,
                    body: new FormData(form)
                })
                .then(response => {
                    return response;
                })
                .then(response => {
                    if (response.status === 200) {
                        var username = form.querySelector('input[name="username"]').value;
                        sessionStorage.setItem('username', username);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Saved Successfully',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            var submitId = document.querySelector(".submit-id");
                            var mainContent = document.querySelector(".main-content");
                            submitId.style.display = "flex";
                            mainContent.style.display = "none";
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'User already exist',
                        });
                    }  
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing the request'
                    });
                });
        });

        document.getElementById("prcId").addEventListener("submit", function(event) {
            event.preventDefault();
            var form = this;
            var username = sessionStorage.getItem('username'); // Retrieve username from sessionStorage
            var formData = new FormData(form);
            formData.append('username', username); // Append username to form data
            fetch('../BACKEND/routes/prcId_process.php', {
                    method: form.method,
                    body: formData
                })
                .then(response => {
                    if (response.status === 200) {
                        // PRC ID submitted successfully
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'PRC ID submitted successfully, Please wait for admin to confirm.',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            window.location.href = 'index.php';
                            sessionStorage.removeItem('username');
                        });
                    } else {
                        // Error occurred during submission
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred during the submission'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred during the submission'
                    });
                });
        });
    </script>

</body>

</html>