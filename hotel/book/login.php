<?php

session_start();


// Проверка, если администратор уже авторизован, перенаправляем на страницу администратора
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header("Location: admin.php");
    exit;
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка имени пользователя и пароля
    if ($username === 'admin' && $password === 'adminpassword') {
        // Успешная аутентификация
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        // Неверные имя пользователя или пароль
        $error = "Неверное имя пользователя или пароль";
    }
}
?>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    text-align: center;
}

h2 {
    color: #333;
    margin-bottom: 20px;
}

form {
    margin-top: 20px;
    width: 300px;
    display: inline-block;
    text-align: left;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
    padding: 5px;
    width: 100%;
    box-sizing: border-box;
    text-align: center;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    cursor: pointer;
    width: 100%;
}

p.error {
    color: red;
    margin-top: 10px;
}

button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    cursor: pointer;
}
</style>

<!DOCTYPE html>
<html>
<head>
    <title>Авторизация администратора</title>
</head>
<body>
    <div class="container">
        <h2>Авторизация администратора</h2>
        <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
        <form method="POST" action="">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" id="username" required><br>

            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" value="Войти">
        </form>
       
    </div>
</body>
</html>
