<?php 
/*
$password = "admin";
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
echo $hashedPassword;
*/

$salt = bin2hex(random_bytes(16));

// Combine the password and salt
$password = "admin";
$combinedPassword = $password . $salt;

// Hash the combined password
$hashedPassword = password_hash($combinedPassword, PASSWORD_BCRYPT);
echo $hashedPassword;

?>