<?php
require_once 'db.php';

$pdo = getPDO();
$stmt = $pdo->query("SELECT * FROM feedback ORDER BY submitted_at DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список заявок</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px; border: 1px solid #ccc; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Список заявок</h1>
    <table>
        <tr>
            <th>ID</th><th>Имя</th><th>Телефон</th><th>Проблема</th><th>Адрес</th><th>Время</th><th>Дата</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['issue']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= htmlspecialchars($row['contact_time']) ?></td>
            <td><?= htmlspecialchars($row['submitted_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
