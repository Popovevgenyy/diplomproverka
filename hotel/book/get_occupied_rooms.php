<?php
// Подключение к базе данных
$host = 'localhost';
$dbName = 'testovichok';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получение данных из запроса
$checkInDate = $_POST['check_in_date'];
$checkOutDate = $_POST['check_out_date'];

// Проверка наличия занятых комнат в указанный период
$stmt = $db->prepare("SELECT room FROM bookings WHERE (check_in_date <= ? AND check_out_date >= ?) OR (check_in_date <= ? AND check_out_date >= ?)");
$stmt->execute([$checkInDate, $checkInDate, $checkOutDate, $checkOutDate]);
$occupiedRooms = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Формирование списка занятых комнат в виде HTML
$html = '';
if (count($occupiedRooms) > 0) {
    $html .= '<p>Занятые комнаты:</p>';
    $html .= '<ul>';
    foreach ($occupiedRooms as $room) {
        $html .= '<li>' . $room . '</li>';
    }
    $html .= '</ul>';
} else {
    $html .= '<p>Нет занятых комнат на выбранный период.</p>';
}

// Возврат списка занятых комнат в виде HTML
echo $html;
?>
