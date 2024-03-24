<!DOCTYPE html>
<html>

<head>
    <title>Mane Click</title>
    <link rel="stylesheet" href="wwwroot/css/main.css">
    <link rel="stylesheet" href="wwwroot/css/ViewPlans.css">
</head>

<body>
    <nav>
        <div class="nav-left">
            <a href="Index.php" class="btn1">Home</a>
        </div>
        <div class="nav-left">
            <h1>Mane Click</h1>
        </div>
        <div class="nav-right">
            <a href="modules/logout.php" class="btn2">Logout</a>
        </div>
    </nav>
    <main class="centered-layout">
        <section class="centered-section">
            <h2> PHP 0 per month </h2>
            <h3> Free Trial </h3>
            <li> 5 Patients </li>
            <li> 5 Printable Progress Reports </li>
            <li> 1 Month Free Access </li>

            <a href="Signup.php?SID=Free" class="btn3" id="btn-get-free"> GET </a>
        </section>

        <section class="centered-section">
            <h2> PHP 499 per Month </h2>
            <h3> Standard Plan </h3>
            <li> 20 Patients </li>
            <li> Trending Graph Data Per Patient </li>
            <li> 10 Printable Progress Reports </li>
            <li> 10 years access to data progress reports </li>

            <a href="Signup.php?SID=Standard" class="btn3" id="btn-get-standard"> GET </a>
        </section>

        <section class="centered-section">
            <h2> PHP 1,299 per Month </h2>
            <h3> Premium Plan </h3>
            <li> Unlimited Patients </li>
            <li> Trending Graph Data Per Patient </li>
            <li> Unlimited Printable Progress Reports </li>
            <li> 10 years access to data progress reports </li>
            <li> Monthly statistical report of SLP Activity </li>

            <a href="Signup.php?SID=Premium" class="btn3" id="btn-get-premium"> GET </a>
        </section>
    </main>
</body>

</html>