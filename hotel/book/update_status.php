<?php
// Подключение к базе данных
$host = 'localhost';
$dbName = 'testovichok';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получение данных из формы
$bookingId = $_POST['booking_id'];
$status = $_POST['status'];

// Обновление статуса бронирования в базе данных
$stmt = $db->prepare("UPDATE bookings SET status = ? WHERE id = ?");
$stmt->execute([$status, $bookingId]);

// Перенаправление обратно на страницу административной панели
header("Location: admin.php");
exit;
?>
