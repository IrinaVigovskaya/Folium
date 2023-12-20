<?php

function PrintData(){
    $conn = new mysqli("localhost", "root", "", "todoL");
    $username = $_SESSION['username'];
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

// Проверка наличия данных
    if ($result->num_rows > 0) {
        // Получение значения user_id
        $row = $result->fetch_assoc();
        $user_id = $row["id"];
    }
    $current_date = date('Y-m-d H:i:s');

    if (isset($_POST['query']))
        $query = null;
    else
        $query = $_GET['query'];

// Отображаем список задач
    echo "<ul>";
    if($query == null OR $query == '') {
        $result = $conn->query("SELECT * FROM tasks WHERE user_id = '$user_id'");
    }
    else {
        $result = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = $user_id && (task_name LIKE '%$query%' || task_description LIKE '%$query%' || task_due_date LIKE '%$query%')");

    }
        if ($result->num_rows == 0) {
            echo "<h5>Задач нет</h5>";
        }
        else if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $task_due_date = $row['task_due_date'];

                // Если задача не выполнена и дата выполнения прошла, выделить ее как просроченную
                if ($task_due_date < $current_date) {
                    echo "<div class='note-card'>";
                    echo "<li>" . "<h5 class='nameNote'>" . $row['task_name'] . "</h5>" . "<br><h6 class='errorNote'>Задача просрочена!</h6>" . "<h6 class='dataNote'>" . $row['task_due_date'] . "</h6>";
                    echo "<form action='delete.php' method='post'>
                        <input type='hidden' name='id' value='" . $row["id"] . "' />
                         <button class='button_del' type='submit' >Удалить</button>
                </form>";
                    echo "</div>";
                } else {
                    echo "<div class='note-card'>";
                    echo '<span class="work_form">', "<li>" . "<h5 class='nameNote'>" . $row['task_name'] . "</h5>" .  "<h6 class='descriptionNote'>" . $row['task_description'] . "</h6><br><h6 class='dataNote'>Сделать до " . $row['task_due_date']. "</h6>" .'</span>';
                        echo "<form action='delete.php' method='post'>
                        <input type='hidden' name='id' value='" . $row["id"] . "' />
                        <button class='button_done' type='submit' >Выполнить</button>
                </form>";
                    echo "<form action='delete.php' method='post'>
                        <input type='hidden' name='id' value='" . $row["id"] . "' />
                        <button class='button_del' type='submit' >Удалить</button>
                        
                </form>";
                    echo "</div>";
                }
            }
        }
}

if($_SESSION["Message"]){
    echo $_SESSION["Message"];
    $_SESSION["Message"] = null;
}
?>