<?php
session_start();
require 'Models/models.php';

$userId = 0;
$userName = '';
$isAdmin = false;

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userName = $_SESSION['user_name'];
    if ($_SESSION['is_admin'] == 1) {
        $isAdmin = true;
    }
}

$pdo = connectDB();
$placeId = $_GET['id'];
$place = getPlaceById($pdo, $placeId);

if (!$place) {
    header('Location: index.php');
    exit;
}

$dishes = getDishes($pdo, $placeId);
$reviews = getReviews($pdo, $placeId);

// фото отзыва
foreach ($reviews as $key => $review) {
    $sql = "SELECT id, photo FROM review_photos WHERE review_id = :review_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['review_id' => $review['id']]);
    $reviews[$key]['photos'] = $stmt->fetchAll();
}

$inFav = false;
if ($userId > 0) {
    if ($isAdmin == false) {
        $inFav = isFav($pdo, $userId, $placeId);
    }
}

// +отзыв с фото
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_review'])) {
        if ($userId > 0) {
            if ($isAdmin == false) {
                // ДОБАВЛЯЕМ ОТЗЫВ
                $sql = "INSERT INTO reviews (place_id, user_id, comment, visit_date) VALUES (:place_id, :user_id, :comment, :visit_date)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'place_id' => $placeId,
                    'user_id' => $userId,
                    'comment' => $_POST['comment'],
                    'visit_date' => $_POST['visit_date']
                ]);
                
                // id нового рест
                $reviewId = $pdo->lastInsertId();
                
                // +фото
                if ($_POST['photo'] != '') {
                    $sql2 = "INSERT INTO review_photos (review_id, photo) VALUES (:review_id, :photo)";
                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->execute([
                        'review_id' => $reviewId,
                        'photo' => $_POST['photo']
                    ]);
                }
                
                header("Location: restaurant.php?id=$placeId");
                exit;
            }
        }
    }
}

// удал 
if (isset($_GET['delete_review'])) {
    if ($userId > 0) {
        deleteReview($pdo, $_GET['delete_review']);
        header("Location: restaurant.php?id=$placeId");
        exit;
    }
}

// +избран
if (isset($_GET['add_fav'])) {
    if ($userId > 0) {
        if ($isAdmin == false) {
            addFav($pdo, $userId, $placeId);
            header("Location: restaurant.php?id=$placeId");
            exit;
        }
    }
}

// удал
if (isset($_GET['remove_fav'])) {
    if ($userId > 0) {
        if ($isAdmin == false) {
            removeFav($pdo, $userId, $placeId);
            header("Location: restaurant.php?id=$placeId");
            exit;
        }
    }
}

include 'views/restaurant.view.php';
?>