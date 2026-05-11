<?php

function connectDB()
{
    return new PDO('mysql:host=localhost;dbname=eat', 'root', '');
}

// ВСЕ РЕСТОРАНЫ
function getAllPlaces($pdo)
{
    $sql = "SELECT id, name, address, cuisine_type, menu_photo FROM places ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// ОДИН РЕСТОРАН
function getPlaceById($pdo, $id)
{
    $sql = "SELECT id, name, address, cuisine_type, menu_photo FROM places WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

// ДОБАВИТЬ РЕСТОРАН
function addPlace($pdo, $data)
{
    $sql = "INSERT INTO places (name, address, cuisine_type, menu_photo) VALUES (:name, :address, :cuisine, :photo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

// ОБНОВИТЬ РЕСТОРАН
function updatePlace($pdo, $data)
{
    $sql = "UPDATE places SET name = :name, address = :address, cuisine_type = :cuisine, menu_photo = :photo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

// УДАЛИТЬ РЕСТОРАН
function deletePlace($pdo, $id)
{
    $sql = "DELETE FROM places WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// ВСЕ БЛЮДА РЕСТОРАНА
function getDishes($pdo, $placeId)
{
    $sql = "SELECT id, name, price, photo FROM dishes WHERE place_id = :place_id ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['place_id' => $placeId]);
    return $stmt->fetchAll();
}

// ДОБАВИТЬ БЛЮДО
function addDish($pdo, $data)
{
    $sql = "INSERT INTO dishes (place_id, name, price, photo) VALUES (:place_id, :name, :price, :photo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

// УДАЛИТЬ БЛЮДО
function deleteDish($pdo, $id)
{
    $sql = "DELETE FROM dishes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// ВСЕ ОТЗЫВЫ
function getReviews($pdo, $placeId)
{
    $sql = "SELECT reviews.id, reviews.comment, reviews.visit_date, reviews.user_id, users.name 
            FROM reviews 
            JOIN users ON reviews.user_id = users.id 
            WHERE reviews.place_id = :place_id 
            ORDER BY reviews.visit_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['place_id' => $placeId]);
    return $stmt->fetchAll();
}

// УДАЛИТЬ ОТЗЫВ
function deleteReview($pdo, $id)
{
    $sql = "DELETE FROM reviews WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// ПРОВЕРИТЬ ИЗБРАННОЕ
function isFav($pdo, $userId, $placeId)
{
    $sql = "SELECT id FROM favourites WHERE user_id = :user_id AND place_id = :place_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId, 'place_id' => $placeId]);
    $result = $stmt->fetch();
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// ДОБАВИТЬ В ИЗБРАННОЕ
function addFav($pdo, $userId, $placeId)
{
    $sql = "INSERT INTO favourites (user_id, place_id) VALUES (:user_id, :place_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId, 'place_id' => $placeId]);
}

// УДАЛИТЬ ИЗ ИЗБРАННОГО
function removeFav($pdo, $userId, $placeId)
{
    $sql = "DELETE FROM favourites WHERE user_id = :user_id AND place_id = :place_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId, 'place_id' => $placeId]);
}

// ВСЕ ИЗБРАННЫЕ РЕСТОРАНЫ
function getFavPlaces($pdo, $userId)
{
    $sql = "SELECT places.id, places.name, places.address, places.cuisine_type, places.menu_photo 
            FROM places 
            JOIN favourites ON places.id = favourites.place_id 
            WHERE favourites.user_id = :user_id 
            ORDER BY places.name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    return $stmt->fetchAll();
}

// ПОЛЬЗОВАТЕЛЬ ПО EMAIL И ПАРОЛЮ
function getUser($pdo, $email, $password)
{
    $sql = "SELECT id, name, email, is_admin FROM users WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);
    return $stmt->fetch();
}

// ПОЛЬЗОВАТЕЛЬ ПО ID
function getUserById($pdo, $userId)
{
    $sql = "SELECT id, name, email, is_admin FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $userId]);
    return $stmt->fetch();
}

// ПРОВЕРИТЬ EMAIL
function emailExists($pdo, $email)
{
    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// ДОБАВИТЬ ПОЛЬЗОВАТЕЛЯ
function addUser($pdo, $data)
{
    $sql = "INSERT INTO users (name, email, password, is_admin) VALUES (:name, :email, :password, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}
?>