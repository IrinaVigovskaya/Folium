<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css\login.css">
</head>
<body>
<?php
$conn = new mysqli("localhost", "root", "", "todoL");
if ($conn->connect_error) {
die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Обработка отправленной формы для авторизации
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = $_POST["username"];
$password = $_POST["password"];

// Выполнение запроса к базе данных
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
// Пользователь успешно авторизован
// Можно выполнить дополнительные действия, например, установить сессию для аутентификации пользователя
session_start();
$_SESSION["username"] = $username;
    header("Location: index.php"); // Перенаправление на защищенную страницу
    exit();
} else {
    // Неправильные учетные данные
    echo "Неправильное имя пользователя или пароль.";
    }
}
?>
<nav class="body_block1">
                <h1 align="center">Folium</h1>
                <h4>Оставайтесь организованными,<br>достигайте большего<br>и<br>никогда не пропускайте ни одного события</h4>
</nav>

<nav class="body_block2">
                <nav class="aut_body">
                    <h1>Авторизация</h1>
                    <form method='post'>
                        <label>Имя пользователя:</label><br>
                        <input type='text' name='username'><br>
                        <label>Пароль:</label><br>
                        <input type='password' name='password'><br>
                        <button class="body_aut_button" type="submit" name="aut">Войти</button><br>
                    </form>
                    <button class="to_reg_button" type="submit" onclick="window.location.href = 'register.php';" name="to_reg">Зарегистрироваться</button>
                </nav>
    <nav class="body_block3">
        <nav class="container-fluid">
            <nav class="container">
                <nav class="row">
                    <nav class="col-6">
                        <a href="https://vk.com/public222593537">
                            <img class="block3_img1"  src="img/vk.png">
                        </a>
                    </nav>
                    <nav class="col-6">
                        <a href="https://t.me/FoliumOfficial">
                            <img class="block3_img2"  src="img/telegram.png">
                        </a>
                    </nav>
                </nav>
            </nav>
        </nav>
    </nav>
    </nav>
</nav>
</body>
</html>

