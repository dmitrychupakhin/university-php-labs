<?php
try {
    $pdo = new PDO('mysql:host=db;dbname=testdb', 'user', 'userpass');
    echo "Успешное подключение к базе данных!";
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
