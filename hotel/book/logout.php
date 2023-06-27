<?php
session_start();

// Уничтожаем данные сессии
session_unset();
session_destroy();

// Перенаправляем на страницу входа
header("Location: login.php");
exit;
?>
