<?php
require_once __DIR__ . '/controllers/FeedbackController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/' || $uri === '/index.php') {
    FeedbackController::showForm();
} elseif ($uri === '/submit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    FeedbackController::handleSubmit();
} elseif ($uri === '/success') {
    FeedbackController::showSuccess();
} elseif ($uri === '/list') {
    FeedbackController::showList();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
