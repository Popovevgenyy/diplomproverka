
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/style.css">
    <title>Бронирование гостиницы</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .containerbook {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
        }

        .content {
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f0f8ff;
        }

        input[type="text"],
        input[type="email"],
        select {
            outline: none;
            background: #f0f8ff;
            padding: 5px;
            color: black;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            background: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<?php include '../header.php' ?>

<div class="containerbook">
    <div class="content">
        <h1>Бронирование</h1>

        <form method="POST" action="process_booking.php">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Номер телефона:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="check_in_date">Дата заезда:</label>
            <input type="text" id="check_in_date" name="check_in_date" class="datepicker" required>
            <div id="occupied_rooms" style="color: red;"></div> <!-- Добавленный элемент -->

            <label for="check_out_date">Дата отъезда:</label>
            <input type="text" id="check_out_date" name="check_out_date" class="datepicker" required min="" readonly>
            <div id="occupied_rooms"></div> <!-- Добавленный элемент -->
            

            <label for="room">Комната</label>
            <select name="room" id="room">
                <option value="Стандарт">Стандарт</option>
                <option value="Комфорт">Комфорт</option>
                
            </select>
            

            <button type="submit" style="background-color: green;">Забронировать</button>
        </form>
    </div>
</div>

<?php include '../footer.php' ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/inputmask/dist/jquery.inputmask.bundle.min.js"></script>

<script>
    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d',
        minDate: 'today',
        onChange: function(selectedDates, dateStr, instance) {
            var checkInDateInput = document.getElementById("check_in_date");
            var checkOutDateInput = document.getElementById("check_out_date");

            if (instance.input === checkInDateInput) {
                var minCheckOutDate = selectedDates[0];
                minCheckOutDate.setDate(minCheckOutDate.getDate() + 1);
                checkOutDateInput._flatpickr.set("minDate", minCheckOutDate);
            }

            var selectedCheckOutDate = checkOutDateInput._flatpickr.selectedDates[0];
            if (selectedCheckOutDate && selectedCheckOutDate < checkOutDateInput._flatpickr.config.minDate) {
                checkOutDateInput._flatpickr.clear();
            }

            // Отправка запроса на сервер для получения занятых комнат
            var selectedCheckInDate = checkInDateInput._flatpickr.selectedDates[0].toISOString().split('T')[0];
            var selectedCheckOutDate = instance.selectedDates[0].toISOString().split('T')[0];
            getOccupiedRooms(selectedCheckInDate, selectedCheckOutDate);
        }
    });

    $(document).ready(function () {
        $('#phone').inputmask('+7-999-999-99-99');
    });

    // Функция для получения занятых комнат с сервера
    function getOccupiedRooms(checkInDate, checkOutDate) {
        $.ajax({
            url: 'get_occupied_rooms.php', // Путь к серверному скрипту для получения занятых комнат
            method: 'POST',
            data: { check_in_date: checkInDate, check_out_date: checkOutDate },
            success: function(response) {
                var occupiedRoomsDiv = document.getElementById('occupied_rooms');
                occupiedRoomsDiv.innerHTML = response;
            }
        });
    }
</script>

</body>
</html>
