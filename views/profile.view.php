<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Мой профиль</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.php">FoodTracker</a>
        <div class="navbar-nav ms-auto">
            <span class="nav-link text-white">Привет, <?php echo $user['name']; ?></span>
            <a class="nav-link" href="profile.php">Профиль</a>
            <a class="nav-link" href="../index.php?show=favourites">Избранное</a>
            <a class="nav-link btn btn-outline-danger btn-sm ms-2" href="../logout.php">Выйти</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4>Мой профиль</h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>ID:</th>
                            <td><?php echo $user['id']; ?></td>
                        </tr>
                        <tr>
                            <th>Имя:</th>
                            <td><?php echo $user['name']; ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?php echo $user['email']; ?></td>
                        </tr>
                        <tr>
                            <th>Роль:</th>
                            <td><span class="badge bg-secondary">Пользователь</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>