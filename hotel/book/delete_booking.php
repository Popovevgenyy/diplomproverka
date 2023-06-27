<?php
$host = 'localhost';
$dbName = 'testovichok';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получение идентификатора записи из массива POST
$bookingId = $_POST['booking_id'];

// SQL-запрос для удаления записи
$stmt = $db->prepare("DELETE FROM bookings WHERE id = ?");
$stmt->execute([$bookingId]);

// Перенаправление обратно на административную страницу после удаления
header("Location: login.php");
exit();
?>
