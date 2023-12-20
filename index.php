<?php
include 'function.php';
$mysqli = mysqli_connect("localhost", "root", "", "todoL");

// Проверяем соединение
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
    exit();
}

// Установка куки
$cookie_name = "user";
$cookie_value = "John Doe";
$cookie_expire = time() + 3600; // текущее время + 3600 секунд (1 час)
setcookie($cookie_name, $cookie_value, $cookie_expire);

// Начало сессии
session_start();

// Проверка, существует ли переменная сессии для имени пользователя
$username = $_SESSION['username']; // $username - имя пользователя
$current_date = date('Y-m-d H:i:s');
if(!isset($username)){
    // Пользователь не авторизован, перенаправление на страницу входа
    header("Location: login.php");
    exit();
}



// Выполнение SQL-запроса с использованием условия фильтрации
$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Проверка наличия данных
if ($result->num_rows > 0) {
    // Получение значения user_id
    $row = $result->fetch_assoc();
    $user_id = $row["id"];
}

if (isset($_POST['task_name'])) {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_due_date = $_POST['task_due_date'];

    // Подготовка и выполнение запроса
    $stmt = $mysqli->prepare("INSERT INTO tasks (user_id, task_name, task_description, task_due_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $task_name, $task_description, $task_due_date);
    $stmt->execute();

    // Закрытие соединения
    $stmt->close();
    $mysqli->close();
}
?>

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
    <link rel="stylesheet" href="css\index.css">
    <link rel="stylesheet" href="css\work_zone.css">
</head>
<body>
    <header>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <h1>Folium</h1>
                    </div>
                    <div class="col-6">
                               <h6>Добро пожаловать, <?php
                                   echo $_SESSION['username'];
                                   ?></h6>
                    </div>
                    <div class="col-2">
                            <form method="post" action="logout.php">
                                <button class="header_menu_button" type="submit" name="logout">Выйти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

<div class="block_work">
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="search">
                    <h2>Поиск задач</h2>

                    <div class="search_window">
                    <h5>Поиск по фрагменту</h5>
                    <form method="get" action="index.php">
                        <input type="text" name="query" placeholder="Введите часть из задачи">
                        <button type="submit">Найти</button>
                    </form>

                    <h5 class="searchH4">Поиск по дате</h5>
                    <form action="index.php" method="get">
                        <input type="date" name="query">
                        <button type="submit">Найти</button>
                    </form>

                        <?php
                        if (isset($_GET['query'])) {
                            echo "<h5 class='result'> Запрос: " . "<i>" . $_GET['query'] . "</i>" . "</h5>";
                            echo "<form action='index.php' method='post'>
                        <input type='hidden' name='id' value='query' />
                        <button class='reset_button' type='submit' >Сбросить поиск</button>
                        </form>";
                        }
                        ?>
                    </div>
                   
                </div>
                <button id="open_modal" class="open_modal_button">+</button>
                <h2 class="print_h2">Список задач</h2>
                <div class="print">
                    <?php
                    PrintData();
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <h2 class="AddH2">Добавить задачу</h2>
                <div class="Add">
                <form class="work_form" method='post'>
                    <label>Название задачи:</label><br>
                    <input type='text' name='task_name'><br>
                    <label>Описание задачи:</label><br>
                    <textarea name='task_description'></textarea><br>
                    <label>Срок выполнения:</label><br>
                    <input type='date' name='task_due_date'><br><br>
                    <button type="submit" name="add_button">Добавить</button><br>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<!-- Модальное окно -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Добавить задачу</h2>
        <form class="work_form" method='post'>
            <label>Название задачи:</label><br>
            <input type='text' name='task_name'><br>
            <label>Описание задачи:</label><br>
            <textarea name='task_description'></textarea><br>
            <label>Срок выполнения:</label><br>
            <input type='date' name='task_due_date'><br><br>
            <button type="submit" name="add_button">Добавить</button><br>
        </form>
    </div>
</div>


<script>
    // Найти кнопку открытия модального окна и само модальное окно
    var openModalBtn = document.getElementById("open_modal");
    var modal = document.getElementById("myModal");

    // Найти элемент закрытия модального окна
    var closeBtn = modal.querySelector(".close");

    // Функция открытия модального окна
    openModalBtn.onclick = function() {
        modal.style.display = "block";
    }

    // Функция закрытия модального окна при клике на кнопку закрытия
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Функция закрытия модального окна при клике за его пределами
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>