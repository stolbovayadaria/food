<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Редактировать блюдо</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4>Редактировать блюдо</h4>
                </div>
                <div class="card-body">
                    <form action="panel.php?action=update_dish" method="post">
                        <input type="hidden" name="id" value="<?php echo $dish['id']; ?>">
                        <input type="hidden" name="place_id" value="<?php echo $_GET['place_id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Название блюда</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $dish['name']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Цена (руб)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $dish['price']; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ссылка на фото</label>
                            <input type="url" name="photo" class="form-control" value="<?php echo $dish['photo']; ?>" placeholder="https://example.com/photo.jpg">
                            <small class="text-muted">Оставьте пустым, если нет фото</small>
                        </div>
                        
                        <button type="submit" class="btn btn-warning w-100">Сохранить изменения</button>
                        <a href="panel.php?action=dishes&place_id=<?php echo $_GET['place_id']; ?>" class="btn btn-secondary w-100 mt-2">Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>