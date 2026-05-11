<?php
session_start();
require 'Models/models.php';

$pdo = connectDB();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = 'login';
}

$error = '';

if ($action == 'login') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = getUser($pdo, $_POST['email'], $_POST['password']);
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

if ($action == 'register') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $emailExists = emailExists($pdo, $_POST['email']);
        if ($emailExists == true) {
            $error = 'Пользователь с таким email уже существует';
        } else {
            addUser($pdo, [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ]);
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
    <title>FoodTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4>Вход в систему</h4>
                </div>
                <div class="card-body">
                    
                    <?php if ($error != '') { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>
                    
                    <form method="post">
                        <?php if ($action == 'register') { ?>
                            <input type="text" name="name" class="form-control mb-2" placeholder="Ваше имя" required>
                        <?php } ?>
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Пароль" required>
                        <button type="submit" class="btn btn-success w-100">
                            <?php if ($action == 'login') { echo 'Войти'; } else { echo 'Зарегистрироваться'; } ?>
                        </button>
                    </form>
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