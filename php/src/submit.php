<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db.php'; // подключение к БД

use Respect\Validation\Validator as v;

// Очистка данных от XSS
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = sanitize($_POST['name'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $issue = sanitize($_POST['issue'] ?? '');
    $address = sanitize($_POST['address'] ?? '');
    $contact_time = sanitize($_POST['contact_time'] ?? '');
    $submitted_at = date('Y-m-d H:i:s');

    // Валидация
    $errors = [];

    if (!v::stringType()->length(2, 50)->validate($name)) {
        $errors[] = "Имя должно быть от 2 до 50 символов.";
    }
    if (!v::phone()->validate($phone)) {
        $errors[] = "Неверный формат телефона.";
    }
    if (!v::stringType()->length(5, 500)->validate($issue)) {
        $errors[] = "Проблема должна быть от 5 до 500 символов.";
    }
    if (!v::stringType()->length(5, 100)->validate($address)) {
        $errors[] = "Адрес должен быть от 5 до 100 символов.";
    }
    if (!v::in(['Утро', 'День', 'Вечер'])->validate($contact_time)) {
        $errors[] = "Выберите корректное время связи.";
    }

    if ($errors) {
        echo "<h2>Ошибки при отправке:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><a href='index.php'>← Назад</a>";
        exit;
    }

    // Сохраняем в базу данных
    try {
        $pdo = getPDO(); // из db.php
        $stmt = $pdo->prepare("
            INSERT INTO feedback (name, phone, issue, address, contact_time, submitted_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $phone, $issue, $address, $contact_time, $submitted_at]);

        echo "<p>Спасибо, ваша заявка принята и сохранена в базе данных!</p>";
        echo "<a href='index.php'>Отправить ещё одну</a>";

    } catch (PDOException $e) {
        echo "❌ Ошибка при сохранении в БД: " . $e->getMessage();
    }
} else {
    echo "Ошибка: форма не была отправлена методом POST.";
}
