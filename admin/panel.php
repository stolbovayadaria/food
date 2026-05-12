<?php
session_start();
require '../Models/models.php';

$userId = 0;
$isAdmin = false;

// проверка авторизации
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    if ($_SESSION['is_admin'] == 1) {
        $isAdmin = true;
    }
}

// юзер то главная
if ($isAdmin == false) {
    header('Location: ../index.php');
    exit;
}

$pdo = connectDB();

// какое действие
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'list';
}

// +рест
if ($action == 'add_place') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $menuPhoto = '';
        
        if (isset($_POST['menu_photo']) && $_POST['menu_photo'] != '') {
            $menuPhoto = $_POST['menu_photo'];
        }
        
        addPlace($pdo, $_POST['name'], $_POST['address'], $_POST['cuisine'], $menuPhoto);
        header('Location: panel.php');
        exit;
    }
}

// редакт рест
if ($action == 'edit_place') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $menuPhoto = '';
        if (isset($_POST['menu_photo']) && $_POST['menu_photo'] != '') {
            $menuPhoto = $_POST['menu_photo'];
        }
        updatePlace($pdo, $_POST['id'], $_POST['name'], $_POST['address'], $_POST['cuisine'], $menuPhoto);
        header('Location: panel.php');
        exit;
    }
}

// удал
if ($action == 'delete_place') {
    deletePlace($pdo, $_GET['id']);
    header('Location: panel.php');
    exit;
}

// +блюдо
if ($action == 'add_dish') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photo = '';
        
        if (isset($_POST['photo']) && $_POST['photo'] != '') {
            $photo = $_POST['photo'];
        }
        
        addDish($pdo, $_POST['place_id'], $_POST['name'], $_POST['price'], $photo);
        header("Location: panel.php?action=dishes&place_id=" . $_POST['place_id']);
    exit;
    }
}

// проверка добавления 
if (isset($_POST['action']) && $_POST['action'] == 'add_dish') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photo = '';
        
        if (isset($_POST['photo']) && $_POST['photo'] != '') {
            $photo = $_POST['photo'];
        }
        
        addDish($pdo, $_POST['place_id'], $_POST['name'], $_POST['price'], $photo);
        header("Location: panel.php?action=dishes&place_id=" . $_POST['place_id']);
        exit;
    }
}

// удал
if ($action == 'delete_dish') {
    deleteDish($pdo, $_GET['id']);
    header("Location: panel.php?action=dishes&place_id=" . $_GET['place_id']);
    exit;
}

// форма редакт блюд
if ($action == 'edit_dish') {
    if (isset($_GET['id'])) {
        $sql = "SELECT id, place_id, name, price, photo FROM dishes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $_GET['id']]);
        $dish = $stmt->fetch();
        
        include '../views/admin/dish.edit.view.php';
        exit;
    }
}

// редакт блюдо
if ($action == 'update_dish') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $photo = '';
        if (isset($_POST['photo']) && $_POST['photo'] != '') {
            $photo = $_POST['photo'];
        }
        
        $sql = "UPDATE dishes SET name = :name, price = :price, photo = :photo WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'photo' => $photo
        ]);
        
        header("Location: panel.php?action=dishes&place_id=" . $_POST['place_id']);
        exit;
    }
}

// форма рест 
if ($action == 'add_place') {
    include '../views/admin/add.view.php';
    exit;
}

// форма редакт
if ($action == 'edit_place') {
    if (isset($_GET['edit_id'])) {
        $place = getPlaceById($pdo, $_GET['edit_id']);
        include '../views/admin/edit.view.php';
        exit;
    }
}

// вывод блюд
if ($action == 'dishes') {
    if (isset($_GET['place_id'])) {
        $dishes = getDishes($pdo, $_GET['place_id']);
        $placeData = getPlaceById($pdo, $_GET['place_id']);
        $placeName = $placeData['name'];
        include '../views/admin/dishes.view.php';
        exit;
    }
}

// главная админ панель
$places = getAllPlaces($pdo);
include '../views/admin/list.view.php';
?>