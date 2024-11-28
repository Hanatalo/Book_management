<?php
if (!isset($_SESSION)) {
    session_start();
}
if (empty($_POST['token'])) {
    header("Location: logout.php");
    exit;
}
if (!(hash_equals($_SESSION['token'], $_POST['token']))) {
    header("Location: logout.php");
    exit;
}
