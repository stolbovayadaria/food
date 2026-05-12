<?php

function connectDB()
{
    return new PDO('mysql:host=localhost;dbname=eat', 'root', '');
}



// все рест
function getAllPlaces($pdo)
{
    $sql = "SELECT id, name, address, cuisine_type, menu_photo FROM places ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $result = $stmt->fetchAll();
    return $result;
}

// 1 рест
function getPlaceById($pdo, $id)
{
    $sql = "SELECT id, name, address, cuisine_type, menu_photo FROM places WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    
    $result = $stmt->fetch();
    return $result;
}

// +рест
function addPlace($pdo, $name, $address, $cuisine, $menuPhoto)
{
    $sql = "INSERT INTO places (name, address, cuisine_type, menu_photo) VALUES (:name, :address, :cuisine, :photo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'address' => $address,
        'cuisine' => $cuisine,
        'photo' => $menuPhoto
    ]);
}

// редакт
function updatePlace($pdo, $id, $name, $address, $cuisine, $menuPhoto)
{
    $sql = "UPDATE places SET name = :name, address = :address, cuisine_type = :cuisine, menu_photo = :photo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'name' => $name,
        'address' => $address,
        'cuisine' => $cuisine,
        'photo' => $menuPhoto
    ]);
}

// удал
function deletePlace($pdo, $id)
{
    $sql = "DELETE FROM places WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}


// все блюда
function getDishes($pdo, $placeId)
{
    $sql = "SELECT id, name, price, photo FROM dishes WHERE place_id = :place_id ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['place_id' => $placeId]);
    
    $result = $stmt->fetchAll();
    return $result;
}

// добав
function addDish($pdo, $placeId, $name, $price, $photo)
{
    $sql = "INSERT INTO dishes (place_id, name, price, photo) VALUES (:place_id, :name, :price, :photo)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'place_id' => $placeId,
        'name' => $name,
        'price' => $price,
        'photo' => $photo
    ]);
}

// удал
function deleteDish($pdo, $id)
{
    $sql = "DELETE FROM dishes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}


// все отзывы рест
function getReviews($pdo, $placeId)
{
    $sql = "SELECT reviews.id, reviews.comment, reviews.visit_date, reviews.user_id, users.name 
            FROM reviews 
            JOIN users ON reviews.user_id = users.id 
            WHERE reviews.place_id = :place_id 
            ORDER BY reviews.visit_date DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['place_id' => $placeId]);
    
    $result = $stmt->fetchAll();
    return $result;
}

// удал
function deleteReview($pdo, $id)
{
    $sql = "DELETE FROM reviews WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}



// есть ли в избранном
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

// добав избран
function addFav($pdo, $userId, $placeId)
{
    $sql = "INSERT INTO favourites (user_id, place_id) VALUES (:user_id, :place_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId, 'place_id' => $placeId]);
}

// удал из избр
function removeFav($pdo, $userId, $placeId)
{
    $sql = "DELETE FROM favourites WHERE user_id = :user_id AND place_id = :place_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId, 'place_id' => $placeId]);
}

// все избран
function getFavPlaces($pdo, $userId)
{
    $sql = "SELECT places.id, places.name, places.address, places.cuisine_type, places.menu_photo 
            FROM places 
            JOIN favourites ON places.id = favourites.place_id 
            WHERE favourites.user_id = :user_id 
            ORDER BY places.name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    
    $result = $stmt->fetchAll();
    return $result;
}

// юз по данным
function getUser($pdo, $email, $password)
{
    $sql = "SELECT id, name, email, is_admin, password FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    
    if ($user) {
        $passwordCorrect = password_verify($password, $user['password']);
        if ($passwordCorrect) {
            return [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'is_admin' => $user['is_admin']
            ];
        }
    }
    
    return false;
}

// юз по id
function getUserById($pdo, $userId)
{
    $sql = "SELECT id, name, email, is_admin FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $userId]);
    
    $result = $stmt->fetch();
    return $result;
}

//проверка почты
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

// добав юз
function addUser($pdo, $name, $email, $password)
{
     $hashedPassword = md5($password);
    
    $sql = "INSERT INTO users (name, email, password, is_admin) VALUES (:name, :email, :password, 0)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword
    ]);
}
?>
