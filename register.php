<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Folium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css\reg.css">
</head>
<body>
<?php
// Подключаемся к базе данных
$mysqli = mysqli_connect("localhost", "root", "", "todoL");

// Проверяем соединение
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
    exit();
}

// Если форма была отправлена, добавляем нового пользователя в базу данных
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    header("Location: login.php");
    exit();
}
?>
<nav class="body_block1">
    <h1 align="center">Folium</h1>
    <h4>Оставайтесь организованными,<br>достигайте большего<br>и<br>никогда не пропускайте ни одного события</h4>
</nav>

<nav class="body_block2">
    <nav class="aut_body">

        <h1>Регистрация</h1>
        <form method='post'>
            <label>Имя пользователя:</label><br>
            <input type='text' name='username'><br>
            <label>Пароль:</label><br>
            <input type='password' name='password'><br>
            <button class="body_reg_button" type="submit" name="reg">Зарегистрироваться</button><br>
        </form>
        <button class="to_log_button" type="submit" onclick="window.location.href = 'login.php';" name="to_log">Авторизироваться</button>
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

