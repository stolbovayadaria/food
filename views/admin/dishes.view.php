<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Управление блюдами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <a href="panel.php" class="btn btn-outline-secondary mb-3">Назад к ресторанам</a>
    
    <h3>Блюда ресторана "<?php echo $placeName; ?>"</h3>
    
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Добавить блюдо</div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="place_id" value="<?php echo $_GET['place_id']; ?>">
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Название" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="price" class="form-control mb-2" placeholder="Цена" required>
                    </div>
                    <div class="col-md-3">
                        <input type="url" name="photo" class="form-control mb-2" placeholder="Ссылка на фото">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" name="action" value="add_dish" class="btn btn-success w-100">+</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
     <div class="card">
        <div class="card-header bg-info text-white">Список блюд</div>
        <div class="card-body">
            <?php if (count($dishes) > 0) { ?>
                <?php foreach ($dishes as $dish) { ?>
                    <div class="border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <?php if ($dish['photo'] != '') { ?>
                                <img src="<?php echo $dish['photo']; ?>" 
                                     style="width: 60px; height: 60px; object-fit: cover;" class="rounded me-3">
                            <?php } ?>
                            <div>
                                <strong><?php echo $dish['name']; ?></strong><br>
                                <span class="text-success"><?php echo number_format($dish['price'], 0); ?> руб</span>
                            </div>
                        </div>
                        <div>
                            <!-- НОВАЯ КНОПКА ИЗМЕНИТЬ -->
                            <a href="panel.php?action=edit_dish&id=<?php echo $dish['id']; ?>&place_id=<?php echo $_GET['place_id']; ?>" 
                               class="btn btn-warning btn-sm">Изменить</a>
                            
                            <a href="panel.php?action=delete_dish&id=<?php echo $dish['id']; ?>&place_id=<?php echo $_GET['place_id']; ?>" 
                               class="btn btn-danger btn-sm" onclick="return confirm('Удалить блюдо?')">Удалить</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-muted text-center mb-0">Нет блюд. Добавьте первое блюдо!</p>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>