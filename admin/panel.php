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

if ($isAdmin == false) {
    header('Location: ../index.php');
    exit;
}

$pdo = connectDB();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'list';
}

// ДОБАВЛЕНИЕ РЕСТОРАНА
if ($action == 'add_place') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $menuPhoto = '';
        if (isset($_POST['menu_photo']) && $_POST['menu_photo'] != '') {
            $menuPhoto = $_POST['menu_photo'];
        }
        addPlace($pdo, [
            'name' => $_POST['name'],
            'address' => $_POST['address'],
            'cuisine' => $_POST['cuisine'],
            'photo' => $menuPhoto
        ]);
        header('Location: panel.php');
        exit;
    }
}

// РЕДАКТИРОВАНИЕ РЕСТОРАНА
if ($action == 'edit_place') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $menuPhoto = '';
        if (isset($_POST['menu_photo']) && $_POST['menu_photo'] != '') {
            $menuPhoto = $_POST['menu_photo'];
        }
        updatePlace($pdo, [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'address' => $_POST['address'],
            'cuisine' => $_POST['cuisine'],
            'photo' => $menuPhoto
        ]);
        header('Location: panel.php');
        exit;
    }
}

// УДАЛЕНИЕ РЕСТОРАНА
if ($action == 'delete_place') {
    deletePlace($pdo, $_GET['id']);
    header('Location: panel.php');
    exit;
}

// ДОБАВЛЕНИЕ БЛЮДА - ИСПРАВЛЕНО
if ($action == 'add_dish') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photo = '';
        if (isset($_POST['photo']) && $_POST['photo'] != '') {
            $photo = $_POST['photo'];
        }
        addDish($pdo, [
            'place_id' => $_POST['place_id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'photo' => $photo
        ]);
        header("Location: panel.php?action=dishes&place_id=" . $_POST['place_id']);
        exit;
    }
}

// ЕСЛИ ACTION ПРИШЁЛ ЧЕРЕЗ POST (ДЛЯ КНОПКИ С name="action")
if (isset($_POST['action']) && $_POST['action'] == 'add_dish') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photo = '';
        if (isset($_POST['photo']) && $_POST['photo'] != '') {
            $photo = $_POST['photo'];
        }
        addDish($pdo, [
            'place_id' => $_POST['place_id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'photo' => $photo
        ]);
        header("Location: panel.php?action=dishes&place_id=" . $_POST['place_id']);
        exit;
    }
}

// УДАЛЕНИЕ БЛЮДА
if ($action == 'delete_dish') {
    deleteDish($pdo, $_GET['id']);
    header("Location: panel.php?action=dishes&place_id=" . $_GET['place_id']);
    exit;
}

// ПОКАЗ ФОРМЫ ДОБАВЛЕНИЯ РЕСТОРАНА
if ($action == 'add_place') {
    include '../views/admin/add.view.php';
    exit;
}

// ПОКАЗ ФОРМЫ РЕДАКТИРОВАНИЯ РЕСТОРАНА
if ($action == 'edit_place') {
    if (isset($_GET['edit_id'])) {
        $place = getPlaceById($pdo, $_GET['edit_id']);
        include '../views/admin/edit.view.php';
        exit;
    }
}

// ПОКАЗ БЛЮД
if ($action == 'dishes') {
    if (isset($_GET['place_id'])) {
        $dishes = getDishes($pdo, $_GET['place_id']);
        $placeData = getPlaceById($pdo, $_GET['place_id']);
        $placeName = $placeData['name'];
        include '../views/admin/dishes.view.php';
        exit;
    }
}

// ГЛАВНАЯ АДМИНКИ
$places = getAllPlaces($pdo);
include '../views/admin/list.view.php';
?>