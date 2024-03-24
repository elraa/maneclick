<?php
$selectedRole = isset($_GET['role']) ? $_GET['role'] : 'SLP';

$roleFiles = [
    'SLP' => '../SLP.php',
    'Patient' => '../Patient.php',
];

if (array_key_exists($selectedRole, $roleFiles)) {
    include $roleFiles[$selectedRole];
} else {
    echo '<h2>Invalid role selected: ' . $selectedRole . '</h2>';
}
?>
