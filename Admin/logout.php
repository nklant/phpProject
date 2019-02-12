<?php

session_start();

session_destroy(); // Destroy the session and logout the user

header('Location: ../index.php'); // Redirect to index page

?>