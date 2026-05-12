<?php
session_start();
require 'Models/models.php';

$pdo = connectDB();

// проверка авторизации
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// определение формы 
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'login';
}

$error = '';

// обработка входа
if ($action == 'login') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $user = getUser($pdo, $email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Неверный email или пароль';
        }
    }
}

// обработка регистрации
if ($action == 'register') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $emailExists = emailExists($pdo, $email);
        
        if ($emailExists == true) {
            $error = 'Пользователь с таким email уже существует';
        } else {
            addUser($pdo, $name, $email, $password);
            header('Location: login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php if ($action == 'login') { echo 'Вход'; } else { echo 'Регистрация'; } ?> - FoodTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header 
                    <?php if ($action == 'login') { echo 'bg-success'; } else { echo 'bg-info'; } ?> text-white">
                    <h4><?php if ($action == 'login') { echo 'Вход в систему'; } else { echo 'Регистрация'; } ?></h4>
                </div>
                <div class="card-body">
                    
                    <?php if ($error != '') { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    
                    <?php if ($action == 'login') { ?>
                        <!-- вход -->
                        <form method="post">
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Пароль" required>
                            <button type="submit" class="btn btn-success w-100">Войти</button>
                        </form>
                    <?php } else { ?>
                        <!-- регистрация -->
                        <form method="post">
                            <input type="text" name="name" class="form-control mb-2" placeholder="Ваше имя" required>
                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Пароль" required>
                            <button type="submit" class="btn btn-info w-100">Зарегистрироваться</button>
                        </form>
                    <?php } ?>
                    
                </div>
                <div class="card-footer text-center">
                    <?php if ($action == 'login') { ?>
                        <a href="login.php?action=register">Нет аккаунта? Зарегистрироваться</a>
                    <?php } else { ?>
                        <a href="login.php?action=login">Уже есть аккаунт? Войти</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>