<?php
session_start();
require 'Models/models.php';

$userId = 0;
$userName = '';
$isAdmin = false;
$showFav = false;

// проверка авторизации
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    
    if ($_SESSION['is_admin'] == 1) {
        $isAdmin = true;
    }
}

// проверка избранного
if (isset($_GET['show'])) {
    if ($_GET['show'] == 'favourites') {
        if ($userId > 0) {
            if ($isAdmin == false) {
                $showFav = true;
            }
        }
    }
}

$pdo = connectDB();

// какой список 
if ($showFav == true) {
    $places = getFavPlaces($pdo, $userId);
    $pageTitle = 'Избранные рестораны';
} else {
    $places = getAllPlaces($pdo);
    $pageTitle = 'Все рестораны';
}

include 'views/index.view.php';
?>