<?php
// Подключение к базе данных
$host = 'localhost';
$dbName = 'testovichok';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получение данных из формы
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$checkInDate = $_POST['check_in_date'];
$checkOutDate = $_POST['check_out_date'];
$room = $_POST['room'];

// Проверка доступности выбранных дат
$stmt = $db->prepare("SELECT * FROM bookings WHERE check_in_date <= ? AND check_out_date >= ? AND room = ?");
$stmt->execute([$checkOutDate, $checkInDate, $room]);
$existingBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($existingBookings) > 0) {
    // Проверка наличия бронирования для выбранных дат и комнаты
    echo "Извините, выбранные даты и комната уже заняты. Пожалуйста, выберите другие даты или комнату.";
} else {
    // Сохранение данных в базу данных и установка статуса "занято"
    $stmt = $db->prepare("INSERT INTO bookings (name, email, phone, check_in_date, check_out_date, room, status) VALUES (?, ?, ?, ?, ?, ?, 'Новое')");
    $stmt->execute([$name, $email, $phone, $checkInDate, $checkOutDate, $room]);
    
    echo "Ваше бронирование прошло успешно! Мы свяжемся с вами для подтверждения.";
}

?>
