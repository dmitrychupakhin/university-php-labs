<?php
// Предполагается, что $data из контроллера уже готово
$currName = $_GET['name'] ?? '';
$currTime = $_GET['contact_time'] ?? '';
$currFrom = $_GET['date_from'] ?? '';
$currTo = $_GET['date_to'] ?? '';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Список заявок</title>
    <style>
        /* ваш CSS */
    </style>
</head>

<body>
    <h1>Список заявок</h1>

    <form method="get" action="">
        <label>
            Имя:
            <input type="text" name="name" value="<?= htmlspecialchars($currName) ?>">
        </label>
        <label>
            Время связи:
            <select name="contact_time">
                <option value="">— Любое —</option>
                <?php foreach (['Утро', 'День', 'Вечер'] as $opt): ?>
                    <option value="<?= $opt ?>" <?= $opt === $currTime ? 'selected' : '' ?>>
                        <?= $opt ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>
            Дата с:
            <input type="date" name="date_from" value="<?= htmlspecialchars($currFrom) ?>">
        </label>
        <label>
            по:
            <input type="date" name="date_to" value="<?= htmlspecialchars($currTo) ?>">
        </label>
        <button type="submit">Фильтровать</button>
        <a href="/list">Сбросить</a>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Проблема</th>
            <th>Адрес</th>
            <th>Время</th>
            <th>Дата</th>
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