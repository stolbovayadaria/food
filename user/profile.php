<?php
session_start();
require '../Models/models.php';

$userId = 0;
$isAdmin = false;

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    if ($_SESSION['is_admin'] == 1) {
        $isAdmin = true;
    }
}

if ($userId == 0) {
    header('Location: ../login.php');
    exit;
}

if ($isAdmin == true) {
    header('Location: ../admin/panel.php');
    exit;
}

$pdo = connectDB();
$user = getUserById($pdo, $userId);

include '../views/profile.view.php';
?>