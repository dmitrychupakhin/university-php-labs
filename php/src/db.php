<?php
function getPDO() {
    $host = 'db';
    $dbname = 'company';
    $username = 'root';
    $password = 'root';

    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    } catch (PDOException $e) {
        die("Ошибка подключения к базе: " . $e->getMessage());
    }
}
