<?php
if (isset($_POST['task_name'])) {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_due_date = $_POST['task_due_date'];
    $user_id = $_SESSION['user_id'];

    // Подключение к базе данных
    $mysqli = mysqli_connect("localhost", "root", "", "todoL");

    // Проверка соединения
    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    // Подготовка и выполнение запроса
    $stmt = $mysqli->prepare("INSERT INTO tasks (user_id, task_name, task_description, task_due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $task_name, $task_description, $task_due_date);
    $stmt->execute();

    // Закрытие соединения
    $stmt->close();
    $mysqli->close();
    header('Location: index.php');
}
?>
