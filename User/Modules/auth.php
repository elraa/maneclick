<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== 'SLP') {
    header("Location: ../restricted.php");
    exit;
}