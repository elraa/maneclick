<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== 'ADMIN') {
    header("Location: ../restricted.php");
    exit;
}
?>