<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Админ панель - Рестораны</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Админ панель</h2>
        <div>
            <a href="panel.php" class="btn btn-primary">Рестораны</a>
            <a href="../../index.php" class="btn btn-outline-secondary">На сайт</a>
            <a href="../../logout.php" class="btn btn-danger">Выйти</a>
        </div>
    </div>
    
    <div class="d-flex justify-content-between mb-4">
        <h3>Управление ресторанами</h3>
        <a href="panel.php?action=add_place" class="btn btn-success">Добавить ресторан</a>
    </div>
    
    <div class="row">
        <?php foreach ($places as $place) { ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5><?php echo $place['name']; ?></h5>
                        <p><?php echo $place['address']; ?></p>
                        <p><strong><?php echo $place['cuisine_type']; ?></strong></p>
                        <div class="btn-group w-100">
                            <a href="panel.php?action=edit_place&edit_id=<?php echo $place['id']; ?>" class="btn btn-warning btn-sm">Редактировать</a>
                            <a href="panel.php?action=delete_place&id=<?php echo $place['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Удалить ресторан?')">Удалить</a>
                            <a href="panel.php?action=dishes&place_id=<?php echo $place['id']; ?>" class="btn btn-info btn-sm">Блюда</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>