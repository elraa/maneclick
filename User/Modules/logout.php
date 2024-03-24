<?php 
   session_start();
   $_SESSION = array();
   session_destroy();
   if (session_status() === PHP_SESSION_NONE) {
      header("Location: ../../index.php");
      exit;
   } else {
      echo "Error destroying session";
   }
   ?>