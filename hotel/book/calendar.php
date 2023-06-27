<?php
session_start();

// Проверка, если администратор не авторизован, перенаправляем на страницу авторизации
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit;
}

$host = 'localhost';
$dbName = 'testovichok';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Запрос на получение всех занятых дней с комнатами
$stmt = $db->query("SELECT check_in_date, check_out_date, room FROM bookings WHERE status = 'занято'");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Создание массива занятых дней с комнатами
$occupiedDays = [];
foreach ($bookings as $booking) {
    $checkInDate = new DateTime($booking['check_in_date']);
    $checkOutDate = new DateTime($booking['check_out_date']);

    $interval = new DateInterval('P1D');
    $period = new DatePeriod($checkInDate, $interval, $checkOutDate->modify('+1 day'));

    foreach ($period as $date) {
        $formattedDate = $date->format('Y-m-d');
        $room = $booking['room'];
        
        if (!isset($occupiedDays[$formattedDate])) {
            $occupiedDays[$formattedDate] = [];
        }
        
        $occupiedDays[$formattedDate][] = $room;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Календарь</title>
    <style>
        .calendar {
            display: flex;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .month {
            flex: 0 0 16.66%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 20px;
            margin-bottom: 20px;
        }

        .month h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        .days {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .day {
            width: 14.28%;
            padding: 5px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .occupied {
            background-color: green;
            color: white;
        }

        .room {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <a href="admin.php">Назад</a> 
    <h2>Календарь занятых дней и комнат</h2>
    <div class="calendar">
        <?php
        $today = new DateTime();
        $currentYear = $today->format('Y');

        // Генерация календаря с января по декабрь
        for ($month = 1; $month <= 12; $month++) {
            echo '<div class="month">';
            generateMonthCalendar($month, $currentYear, $occupiedDays);
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>

<?php
function generateMonthCalendar($month, $year, $occupiedDays)
{
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstDay = new DateTime("$year-$month-01");
    $weekday = $firstDay->format('N');

    echo '<h3>' . date('F Y', strtotime("$year-$month-01")) . '</h3>';
    echo '<div class="days">';

    // ... код для генерации дней месяца ...

    // Генерация дней месяца
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $date = new DateTime("$year-$month-$day");
        $formattedDate = $date->format('Y-m-d');

        $class = in_array($formattedDate, array_keys($occupiedDays)) ? 'occupied' : '';
        $rooms = isset($occupiedDays[$formattedDate]) ? $occupiedDays[$formattedDate] : [];

        echo '<div class="day ' . $class . '">' . $day;
        
        // Отображение занятых комнат внутри дня
        foreach ($rooms as $room) {
            echo '<div class="room">' . $room . '</div>';
        }

        echo '</div>';
    }

    echo '</div>';
}
?>
