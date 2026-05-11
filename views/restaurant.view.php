<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo $place['name']; ?> - FoodTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .dish-card {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
        }
        .dish-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .row-custom {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        @media (max-width: 768px) {
            .row-custom {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">FoodTracker</a>
        <div class="navbar-nav ms-auto">
            <?php if ($userId > 0) { ?>
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
                <a class="nav-link" href="login.php">Вход</a>
            <?php } ?>
        </div>
    </div>
</nav>

<div class="container py-4">
    <a href="index.php" class="btn btn-outline-secondary mb-3">На главную</a>

    <!-- КАРТОЧКА РЕСТОРАНА -->
    <div class="card mb-4">
        <div class="card-body">
            <h2><?php echo $place['name']; ?></h2>
            <p>Адрес: <?php echo $place['address']; ?></p>
            <p>Кухня: <strong><?php echo $place['cuisine_type']; ?></strong></p>
            
            <?php if ($place['menu_photo'] != '') { ?>
                <a href="<?php echo $place['menu_photo']; ?>" target="_blank" class="btn btn-primary">Всё меню</a>
            <?php } ?>
            
            <?php if ($userId > 0) { ?>
                <?php if ($isAdmin == false) { ?>
                    <?php if ($inFav == true) { ?>
                        <a href="restaurant.php?id=<?php echo $placeId; ?>&remove_fav=1" class="btn btn-danger">Удалить из избранного</a>
                    <?php } else { ?>
                        <a href="restaurant.php?id=<?php echo $placeId; ?>&add_fav=1" class="btn btn-outline-warning">В избранное</a>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

    <!-- МЕНЮ -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">Меню ресторана</div>
        <div class="card-body">
            <?php if (count($dishes) > 0) { ?>
                <div class="row-custom">
                    <?php foreach ($dishes as $dish) { ?>
                        <div class="dish-card">
                            <?php if ($dish['photo'] != '') { ?>
                                <img src="<?php echo $dish['photo']; ?>" class="dish-img">
                            <?php } else { ?>
                                <div class="dish-img bg-secondary d-flex align-items-center justify-content-center text-white">Нет фото</div>
                            <?php } ?>
                            <div>
                                <h5 class="mb-0"><?php echo $dish['name']; ?></h5>
                                <p class="text-success mb-0"><?php echo number_format($dish['price'], 0); ?> руб</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p class="text-muted">Пока нет блюд в меню</p>
            <?php } ?>
        </div>
    </div>

    <!-- ОТЗЫВЫ -->
    <div class="card">
        <div class="card-header bg-success text-white">Отзывы</div>
        <div class="card-body">
            
            <?php if ($userId > 0) { ?>
                <?php if ($isAdmin == false) { ?>
                    <form method="post" class="mb-4 p-3 bg-light rounded">
                        <label class="form-label">Дата посещения</label>
                        <input type="date" name="visit_date" class="form-control mb-2" required>
                        <label class="form-label">Ваш отзыв</label>
                        <textarea name="comment" class="form-control mb-2" rows="3" required></textarea>
                        <label class="form-label">Ссылка на фото (необязательно)</label>
                        <input type="url" name="photo" class="form-control mb-2" placeholder="https://example.com/photo.jpg">
                        <button type="submit" name="add_review" class="btn btn-success">Отправить отзыв</button>
                    </form>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-info mb-4">Чтобы оставить отзыв, <a href="login.php">войдите в систему</a></div>
            <?php } ?>

            <?php if (count($reviews) > 0) { ?>
                <?php foreach ($reviews as $review) { ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong><?php echo $review['name']; ?></strong>
                            <small><?php echo $review['visit_date']; ?></small>
                        </div>
                        <p class="mt-2"><?php echo nl2br($review['comment']); ?></p>
                        
                        <!-- ВЫВОД ФОТО ОТЗЫВА -->
                        <?php if (count($review['photos']) > 0) { ?>
                            <div class="row mt-2">
                                <?php foreach ($review['photos'] as $photo) { ?>
                                    <div class="col-md-3 mb-2">
                                        <img src="<?php echo $photo['photo']; ?>" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;">
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        
                        <?php if ($userId > 0) { ?>
                            <?php if ($review['user_id'] == $userId || $isAdmin == true) { ?>
                                <a href="restaurant.php?id=<?php echo $placeId; ?>&delete_review=<?php echo $review['id']; ?>" 
                                   class="btn btn-sm btn-danger" onclick="return confirm('Удалить отзыв?')">Удалить</a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-muted">Пока нет отзывов</p>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>