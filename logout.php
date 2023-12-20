<?php
session_start();

// Проверка, была ли нажата кнопка выхода
if (isset($_POST['logout'])) {
    // Очистка данных сессии
    session_unset();
    // Уничтожение сессии
    session_destroy();
    // Перенаправление пользователя на страницу входа или другую страницу по вашему выбору
    header("Location: login.php");
    exit;
}