<?php
session_start(); // Start the session to access session variables

if ($_SESSION['role'] !== 'SLP') {
    header("Location: dashboard.php");
    exit;
}
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}


// Get the user ID and username from the session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Plans</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .scale-up {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        .list-unstyled {
            font-size: 20px;
        }
    </style>

</head>

<body style="background-color: #E4DEAE;">
    <?php include './component/pageHeader.php' ?>
    <div style="padding: 10px; ">
        <h1>CHOOSE YOUR PLAN</h1>
        <div style="display:flex; ">
            <div class="container mt-5" style="width:60%">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">PHP 1.00 per month</h2>
                                <p class="card-text" style="font-size: xx-large;">1 Peso Trial</p>
                                <ul class="list-unstyled">
                                    <li>* 5 Patients</li>
                                    <li>* 5 Printable Progress Reports</li>
                                    <li>* 1 Month Free Access</li>
                                </ul>
                                <button class="btn btn-primary btn-block plan-btn" data-plan-type="Free Trial" data-plan-cost="1" style="background-color: #133A1B">Get This Plan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">PHP 499.00 per Month</h2>
                                <p class="card-text" style="font-size: xx-large;">Standard Plan</p>
                                <ul class="list-unstyled">
                                    <li>* 20 Patients</li>
                                    <li>* Trending Graph Data Per Patient</li>
                                    <li>* 10 Printable Progress Reports</li>
                                </ul>
                                <button class="btn btn-primary btn-block plan-btn" data-plan-type="Standard Plan" data-plan-cost="499" style="background-color: #133A1B">Get This Plan</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">PHP 1299.00 per Month</h2>
                                <p class="card-text" style="font-size: xx-large;">Premium Plan</p>
                                <ul class="list-unstyled">
                                    <li>* Unlimited Patients</li>
                                    <li>* Trending Graph Data Per Patient</li>
                                    <li>* Unlimited Printable Progress Reports</li>
                                    <li>* 10 years access to data progress reports</li>
                                    <li>* Monthly statistical report of SLP Activity</li>
                                </ul>
                                <button class="btn btn-primary btn-block plan-btn" data-plan-type="Premium Plan" data-plan-cost="1299" style="background-color: #133A1B">Get This Plan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="P-3 m-8" style="border: 1px solid black; width: 20%; display: flex; justify-content: center; align-items: center; background-color: white;">
                <div id="paypal-button-container"></div>
            </div>


        </div>

        <script
            src="https://www.paypal.com/sdk/js?client-id=AXxGfSK3mhlmMp539dsB73sP4urViy1dlqoLuqetvcoMoSC0Ch2X7EX0CxM8pQN8QyiyzS1zDvYle6-d"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let planCost = null;
                let planType = null;
                const user_id = "<?php echo $user_id; ?>";

                var planButtons = document.querySelectorAll('.plan-btn');
                planButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        planCost = this.getAttribute('data-plan-cost');
                        planType = getPlanType(planCost); 
                        updatePayPalButton(planCost);
                    });
                });

                function getPlanType(cost) {
                    switch (cost) {
                        case '1':
                            return 'Free Trial';
                        case '499':
                            return 'Standard Plan';
                        case '1299':
                            return 'Premium Plan';
                        default:
                            return 'Unknown';
                    }
                }

                function updatePayPalButton(planCost) {
                    const paypalButtonContainer = document.getElementById('paypal-button-container');
                    paypalButtonContainer.innerHTML = ''; // Clear previous button

                    renderPayPalButton(planCost);
                }

                function renderPayPalButton(planCost) {
                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: planCost
                                    }
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                    
                                const formData = new FormData();
                                formData.append('user_id', user_id);
                                formData.append('type', planType); 
                                formData.append('plan_cost', planCost);

                                fetch('../BACKEND/routes/subscription_process.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => {
                                    if (response.ok) {
                                        return response.json();
                                    } else {
                                        throw new Error('Network response was not ok.');
                                    }
                                })
                                .then(data => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Successfully subscribed to the plan'
                                    }).then(function() {
                                        window.location.href = 'homepage.php';
                                    });
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Subscription failed'
                                    });
                                });
                            });
                        }
                    }).render('#paypal-button-container');
                }
            });
        </script>

    </body>
</html>