<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Редактировать ресторан</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4>Редактировать ресторан</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $place['id']; ?>">
                        <input type="text" name="name" class="form-control mb-2" value="<?php echo $place['name']; ?>" required>
                        <input type="text" name="address" class="form-control mb-2" value="<?php echo $place['address']; ?>" required>
                        <input type="text" name="cuisine" class="form-control mb-2" value="<?php echo $place['cuisine_type']; ?>" required>
                        <input type="url" name="menu_photo" class="form-control mb-2" value="<?php echo $place['menu_photo']; ?>" placeholder="Ссылка на фото меню">
                        <button type="submit" class="btn btn-warning w-100">Сохранить</button>
                        <a href="panel.php" class="btn btn-secondary w-100 mt-2">Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>