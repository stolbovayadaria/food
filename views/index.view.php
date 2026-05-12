<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>FoodTracker - <?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- все кнопки -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">FoodTracker</a>
        <div class="navbar-nav ms-auto">
            
            <?php if ($userId > 0) { ?>
                <!-- пользователь -->
                <span class="nav-link text-white">Привет, <?php echo $userName; ?></span>
                
                <?php if ($isAdmin == false) { ?>
                    <a class="nav-link" href="user/profile.php">Профиль</a>
                    <a class="nav-link" href="index.php?show=favourites">Избранное</a>
                <?php } ?>
                
                <?php if ($isAdmin == true) { ?>
                    <a class="nav-link btn btn-outline-warning btn-sm ms-2" href="admin/panel.php">Админ панель</a>
                <?php } ?>
                
                <a class="nav-link btn btn-outline-danger btn-sm ms-2" href="logout.php">Выйти</a>
                
            <?php } else { ?>
                <!-- гость -->
                <a class="nav-link" href="login.php">Вход</a>
            <?php } ?>
            
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo $pageTitle; ?></h1>
        
        <?php if ($showFav == true) { ?>
            <a href="index.php" class="btn btn-outline-secondary">Все рестораны</a>
        <?php } ?>
    </div>
    
    <div class="row">
        <?php if (count($places) > 0) { ?>
            <?php foreach ($places as $place) { ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <h5><?php echo $place['name']; ?></h5>
                            <p><?php echo $place['address']; ?><br>
                            <strong><?php echo $place['cuisine_type']; ?></strong></p>
                            <a href="restaurant.php?id=<?php echo $place['id']; ?>" class="btn btn-primary w-100">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="alert alert-info">
                <?php if ($showFav == true) { ?>
                    У вас пока нет избранных ресторанов
                <?php } else { ?>
                    Рестораны не найдены
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>