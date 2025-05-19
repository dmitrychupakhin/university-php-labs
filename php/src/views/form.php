<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Форма обратной связи</title>
    <script>
        function validateForm() {
            const phone = document.forms["feedback"]["phone"].value;
            const phonePattern = /^\+?[0-9\s\-]{7,15}$/;
            if (!phonePattern.test(phone)) {
                alert("Введите корректный номер телефона.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <h1>Оставьте заявку</h1>
    <form name="feedback" action="submit.php" method="POST" onsubmit="return validateForm();">
        <label>Имя:</label><br>
        <input type="text" name="name" required minlength="2" maxlength="50"><br><br>

        <label>Номер телефона:</label><br>
        <input type="tel" name="phone" required pattern="\+?[0-9\s\-]{7,15}"><br><br>

        <label>Опишите проблему:</label><br>
        <textarea name="issue" rows="4" cols="40" required maxlength="500"></textarea><br><br>

        <label>Адрес объекта:</label><br>
        <input type="text" name="address" required maxlength="100"><br><br>

        <label>Удобное время для связи:</label><br>
        <select name="contact_time" required>
            <option value="">-- выберите --</option>
            <option value="Утро">Утро</option>
            <option value="День">День</option>
            <option value="Вечер">Вечер</option>
        </select><br><br>

        <input type="submit" value="Отправить заявку">
    </form>
</body>

</html>