<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../models/FeedbackModel.php';
// require_once __DIR__ . '/../views/form.php';

use Respect\Validation\Validator as v;

class FeedbackController
{
    public static function showForm()
    {
        include __DIR__ . '/../views/form.php';
    }

    public static function showSuccess()
    {
        include __DIR__ . '/../views/success.php';
    }

    public static function handleSubmit()
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        function sanitize($data)
        {
            return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
        }

        $name = sanitize($_POST['name'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $issue = sanitize($_POST['issue'] ?? '');
        $address = sanitize($_POST['address'] ?? '');
        $contact_time = sanitize($_POST['contact_time'] ?? '');
        $submitted_at = date('Y-m-d H:i:s');

        $errors = [];

        if (!v::stringType()->length(2, 50)->validate($name)) {
            $errors[] = "Имя должно быть от 2 до 50 символов.";
        }
        if (!v::phone()->validate(input: $phone)) {
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
            include __DIR__ . '/../views/form.php';
            return;
        }

        FeedbackModel::save([
            'name' => $name,
            'phone' => $phone,
            'issue' => $issue,
            'address' => $address,
            'contact_time' => $contact_time,
            'submitted_at' => $submitted_at
        ]);

        header('Location: /success');
    }
    private static function sanitize(string $data): string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public static function showList()
    {
        // Читаем и санитизируем фильтры
        $filters = [
            'name' => self::sanitize($_GET['name'] ?? ''),
            'contact_time' => self::sanitize($_GET['contact_time'] ?? ''),
            'date_from' => self::sanitize($_GET['date_from'] ?? ''),
            'date_to' => self::sanitize($_GET['date_to'] ?? ''),
        ];

        // Получаем данные с учётом фильтров
        $data = FeedbackModel::getAll($filters);

        include __DIR__ . '/../views/list.php';
    }

}
