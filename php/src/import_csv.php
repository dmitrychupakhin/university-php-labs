<?php
require_once 'db.php';

$pdo = getPDO();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "📂 Текущая директория: " . getcwd() . "<br>";

$csvFile = fopen('feedback.csv', 'r');
if (!$csvFile) {
    die("❌ CSV-файл не найден.");
}

echo "✅ CSV-файл открыт<br>";

// Пропускаем заголовок
$header = fgetcsv($csvFile);
echo "🔍 Заголовок: ";
var_dump($header);
echo "<br>";

$counter = 0;
while (($row = fgetcsv($csvFile)) !== false) {
    echo "📦 Строка $counter: ";
    var_dump($row);
    echo "<br>";

    if (count($row) !== 6) {
        echo "⚠️ Строка не содержит 6 элементов — пропущена<br>";
        continue;
    }

    [$name, $phone, $issue, $address, $contact_time, $submitted_at] = $row;

    try {
        $stmt = $pdo->prepare("
            INSERT INTO feedback (name, phone, issue, address, contact_time, submitted_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $phone, $issue, $address, $contact_time, $submitted_at]);

        echo "✅ Вставлено: $name<br>";
        $counter++;
    } catch (PDOException $e) {
        echo "❌ Ошибка: " . $e->getMessage() . "<br>";
    }
}

fclose($csvFile);
echo "<hr>Импорт завершён: $counter записей добавлено.";