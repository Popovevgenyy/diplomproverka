<?php
$monthTranslations = array(
    'January'   => 'января',
    'February'  => 'февраля',
    'March'     => 'марта',
    'April'     => 'апреля',
    'May'       => 'мая',
    'June'      => 'июня',
    'July'      => 'июля',
    'August'    => 'августа',
    'September' => 'сентября',
    'October'   => 'октября',
    'November'  => 'ноября',
    'December'  => 'декабря'
);

setlocale(LC_ALL, 'ru_RU.utf8');
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

// Запрос на получение всех бронирований
$stmt = $db->query("SELECT * FROM bookings");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <meta charset="UTF-8">
    <title>Административная панель</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .status-done {
            background-color: blue;
            color: white;
        }

        .status-occupied {
            background-color: red;
            color: white;
        }

        .status-new {
            background-color: green;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Административная панель</h2>
    <a href="logout.php">Выйти</a> <a href="calendar.php">Календарь</a><br><br>

    <h3>Информация о бронированиях:</h3>
    <table>
        <thead>
            <tr>
                <th>Имя</th>
                <th>Email</th>
                <th>Контакты</th>
                <th>Дата заезда</th>
                <th>Дата отъезда</th>
                <th>Комната</th>
                <th>Статус</th>
                <th>Принятие</th>
            </tr>
        </thead>
        <tbody>
            <?php setlocale(LC_TIME, 'ru_RU.UTF-8'); foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['name']; ?></td>
                    <td><?php echo $booking['email']; ?></td>
                    <td><?php echo $booking['phone']; ?></td>
                    <td><?php echo strftime('%d', strtotime($booking['check_In_Date'])) . ' ' .
                    $monthTranslations[date('F', strtotime($booking['check_In_Date']))] . ' ' . strftime('%Y', strtotime($booking['check_In_Date'])); ?></td>
                    <td><?php echo strftime('%d', strtotime($booking['check_Out_Date'])) . ' ' . 
                    $monthTranslations[date('F', strtotime($booking['check_Out_Date']))] . ' ' . strftime('%Y', strtotime($booking['check_Out_Date'])); ?></td>
                    <td><?php echo $booking['room']; ?></td>
                    <td class="<?php echo $booking['status'] === 'Выполнено' ? 'status-done' : ($booking['status'] === 'Занято' ? 'status-occupied' : 'status-new'); ?>">
                    <?php echo $booking['status']; ?></td>
                    <td>
                        <form action="update_status.php" method="post">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                            <select name="status">
                                <option value="Новое" <?php if ($booking['status'] === 'Новое') echo 'selected'; ?>>Новое</option>
                                <option value="Занято" <?php if ($booking['status'] === 'Занято') echo 'selected'; ?>>Занято</option>
                                <option value="Выполнено" <?php if ($booking['status'] === 'Выполнено') echo 'selected'; ?>>Выполнено</option>
                            </select>
                            <button type="submit">Изменить</button>
                        </form>
                    </td>
                    <td>
                        <form action="delete_booking.php" method="post">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                            <button type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Добавить занятую комнату:</h3>
    <form method="POST" action="add_booking.php">
        <label for="room">Комната:</label>
        <select name="room" id="room">
            <option value="Стандарт">Стандарт</option>
            <option value="Комфорт">Комфорт</option>
            <!-- Добавьте остальные варианты комнат -->
        </select>
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required>
        <label for="phone">Номер телефона:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="check_in_date">Дата заезда:</label>
        <input type="date" id="check_in_date" class="datepicker" name="check_in_date" required>

        <label for="check_out_date">Дата отъезда:</label>
        <input type="date" id="check_out_date" class="datepicker" name="check_out_date" required>

        <button type="submit">Добавить</button>
    </form>

    <script>
        flatpickr('.datepicker', {
            dateFormat: 'Y-m-d',
            minDate: 'today' // Чтобы запретить выбор прошедших дат
        });
    </script>
    
</body>
</html>
