<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>
    <link rel="stylesheet" href="wwwroot/css/main.css">
    <link rel="stylesheet" href="wwwroot/css/Login.css">

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
            <a href="" class="btn1">Login</a>
            <a href="Signup.php" class="btn2">Sign-Up</a>
        </div>
    </nav>
    <main class="centered-layout">
        <section class="centered-section">
            <form method="post" onsubmit="event.preventDefault(); processLogin();">
                <h1>Login</h1>
                <label for="txtuname">Username</label>
                <input type="text" name="txtuname" required>
                <label for="txtpass">Password</label>
                <input type="password" name="txtpass" required>
                <a class="a" href="FindAccount.php">Forgot Password</a>
                <input type="submit" name="btnsubmit" value="Login">
            </form>
        </section>
    </main>
    <script src="wwwroot/js/login.js"></script>
</body>
</html>