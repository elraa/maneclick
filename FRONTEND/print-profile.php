<?php
session_start(); // Start the session to manage user login state
include '../BACKEND/config/db.php';
// Check if the user is not logged in (no session exists)
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'SLP') {
    header("Location: dashboard.php");
    exit;
}


$user_id = $_SESSION['user_id'];

$patientId = isset($_GET['pid']) ? $_GET['pid'] : null;

$stmt = $conn->prepare("SELECT * FROM therapy WHERE patient_id = :patientId");
$stmt->bindParam(':patientId', $patientId, PDO::PARAM_INT);
$stmt->execute();
$therapyDets = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM t_sessions WHERE patient_id = :patientId ");
$stmt->bindParam(':patientId', $patientId, PDO::PARAM_INT);
$stmt->execute();
$existSession = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        .page-break {
            page-break-before: always;
        }
        .bodypage{
            background-color:#555555
        }
        .printbtn{
            position: absolute;
            top: 10px;
            right: 10px;
            font-size:larger; 
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body class='bodypage'>
    <button class="printbtn" id="printButton">Print PDF</button>
    <div id="mainContainer" style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <div id="viewTherapyDetails" style="display: flex; justify-content:center; align-items:center; width:600px; border:2x solid #B7BF96; background-color:white; height:750px; ">
            <div class="card" style="border:1px solid black; width:100%; padding:4px">
                <div class="card-header bg-light">
                    <h5 class="card-title" style="font-size: x-large; font-weight:800; color:#415E35; font-family: 'Roboto', sans-serif;">Therapy Details <span><?php echo $therapyDets['DSI'] ?></span></h5>
                </div>
                <div class="card-body" style="font-size: large; font-family: 'Roboto', sans-serif;">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Patient Name:</span></strong>
                        <span class="align-middle"><?php echo $therapyDets['name']; ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Sex:</span></strong>
                        <span class="align-middle"><?php echo $therapyDets['sex']; ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">SLP:</span></strong>
                        <span class="align-middle"><?php echo $therapyDets['SLP']; ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Disorder:</span></strong>
                        <span class="align-middle"><?php echo $therapyDets['disorders']; ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Created At:</span></strong>
                        <span class="align-middle"><?php echo date('F j, Y', strtotime($therapyDets['createdAt'])); ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Valid Until:</span></strong>
                        <span class="align-middle"><?php echo date('F j, Y', strtotime($therapyDets['valid_until'])); ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">First Therapy Date:</span></strong>
                        <span class="align-middle"><?php echo date('F j, Y', strtotime($therapyDets['FTD'])); ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Target Finish Date:</span></strong>
                        <span class="align-middle"><?php echo date('F j, Y', strtotime($therapyDets['TFD'])); ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Date of Evaluation;:</span></strong>
                        <span class="align-middle"><?php echo date('F j, Y', strtotime($therapyDets['DOE'])); ?></span>
                    </p>
                    <hr class="gray-line">
                    <p style="border: 2px solid gray;">
                        <strong><span style="display: inline-block; width: 250px; border-right: 2px solid gray; padding-right: 5px;">Status:</span></strong>
                        <span class="align-middle"><?php echo $therapyDets['status']; ?></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="page-break col-md-12" style="display: block; justify-content:center; align-items:center; width:600px; border:2x solid #B7BF96; background-color:white; height:auto;">
                    <h3 style="color:#133A1B">Overall Session Reviews</h3>
                    <?php foreach ($existSession as $session) : ?>
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">Word Details</h5>
                                <p class="card-text"><strong>Word: </strong><?php echo $session['word']; ?></p>
                                <p class="card-text"><strong>Prompt: </strong><?php echo $session['prompt']; ?></p>
                                <p class="card-text"><strong>Interpretation: </strong><?php echo $session['interpretation']; ?></p>
                                <p class="card-text"><strong>Remarks: </strong><?php echo $session['remarks']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
        <div id="chartContainer" class='page-break' style="display:flex; justify-content:center; align-items:center; width:600px; height:500px; background-color:white" >
            <canvas id="myChart"></canvas>
        </div>
    </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var logs = <?php echo json_encode($therapyDets); ?>

        // Retrieve chart data from session storage
        const chartData = JSON.parse(sessionStorage.getItem('chartData'));

        // Descriptions for the prompt values
        const descriptions = {
            100: "Showing Correct Independent Production",
            80: "Visual Prompt",
            60: "Verbal Prompt",
            40: "Tactile Prompt",
            20: "Hand under Hand Assistance"
        };

        // Render the chart
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.dates,
                datasets: [{
                    label: 'Prompt Values',
                    data: chartData.values,
                    backgroundColor: (context) => {
                        return context.raw === chartData.values[chartData.values.length - 1] ? 'rgba(255, 99, 132, 0.2)' : 'rgba(75, 192, 192, 0.2)';
                    },
                    borderColor: (context) => {
                        return context.raw === chartData.values[chartData.values.length - 1] ? 'rgba(255, 99, 132, 1)' : 'rgba(75, 192, 192, 1)';
                    },
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Prompts Average & Forecasted Value for Next Session'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                tooltips: {
                    callbacks: {
                        title: function(tooltipItems) {
                            return 'Predicted Value: ' + tooltipItems[0].label;
                        },
                        label: function(tooltipItem) {
                            const predicted = tooltipItem.raw;
                            return 'Description: ' + descriptions[predicted];
                        }
                    }
                }
            }
        });

        function generatePDF() {
            const element = document.getElementById('mainContainer'); 

            html2pdf().from(element).set({
                margin: 1,
                filename: 'therapy-details.pdf',
                html2canvas: { scale: 2 },
                jsPDF: { orientation: 'portrait', unit: 'in', format: 'letter' },
                pagebreak: { mode: ['css', 'legacy'], before: '.page-break' }
            }).save();
        }
        document.getElementById('printButton').addEventListener('click', generatePDF);
    </script>
</body>
</html>
