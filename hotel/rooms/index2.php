<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Стандарт</title>
    
</head>
<body>
<div class="container">
    <?php 
    include '../header.php'
    ?>
    <div class="carousel-container">
    <h2 class="carousel-title">КОМФОРТ</h2>
    <br>
    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item">
                <img src="../image/komfort1.jpg" alt="Image 1">
                <div class="carousel-caption">КОМФОРТ</div>
            </div>
            <div class="carousel-item">
                <img src="../image/komfort2.jpg" alt="Image 2">
                <div class="carousel-caption">КОМФОРТ</div>
            </div>
            <div class="carousel-item">
                <img src="../image/komfort3.jpg" alt="Image 3">
                <div class="carousel-caption">КОМФОРТ</div>
            </div>
        </div>
        <div class="carousel-prev">&#8249;</div>
        <div class="carousel-next">&#8250;</div>
        
    </div>
    <div class="carousel-caption-bottom">
            <p class="price">5000р/сут.</p>
            <button class="btn btn-primary" onClick='location.href="../book/index.php"'>Забронировать номер</button>
        </div>
        <div class="details">
            <div class="left-category">
                <div class="details-heading">В НОМЕРЕ</div>
                <ul class="details-list">
                    <li><span class="circle"></span> Одна двуспальная Кровать</li>
                    <li><span class="circle"></span> Гардероб с вешалками</li>
                    <li><span class="circle"></span> Универсальный стол</li>
                    <li><span class="circle"></span> Телефон</li>
                    <li><span class="circle"></span> Телевизор (российские спутниковые каналы)</li>
                    <li><span class="circle"></span> холодильник</li>
                    <li><span class="circle"></span> Wi-Fi</li>
                    <li><span class="circle"></span> Система центрального кондиционирования</li>
                    <li><span class="circle"></span> Зеркало</li>
                    <li><span class="circle"></span> Журнальный столик</li>
                    <li><span class="circle"></span> Кресло/стул</li>
                    <li><span class="circle"></span> Тумбочки прикроватные</li>
                </ul>
            </div>
            <div class="right-category">
                <div class="details-heading">В ВАННОЙ КОМНАТЕ</div>
                <ul class="details-list">
                    <li><span class="circle"></span> Ванна</li>
                    <li><span class="circle"></span> Комплект полотенец</li>
                    <li><span class="circle"></span> Жидкое мыло в диспенсере</li>
                    <li><span class="circle"></span> Гель для душа/шампунь в диспенсере</li>
                    <li><span class="circle"></span> Корзина для мусора</li>
                    <li><span class="circle"></span> Туалетная бумага</li>
                </ul>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php 
    include '../footer.php'
    ?>

    <script>
        const carousel = document.querySelector('.carousel');
        const carouselInner = document.querySelector('.carousel-inner');
        const carouselItems = document.querySelectorAll('.carousel-item');
        const prevButton = document.querySelector('.carousel-prev');
        const nextButton = document.querySelector('.carousel-next');

        let currentIndex = 0;
        const slideWidth = carouselItems[0].offsetWidth;

        function goToSlide(index) {
            carouselInner.style.transform = `translateX(-${index * slideWidth}px)`;
        }

        function slidePrev() {
            currentIndex--;
            if (currentIndex < 0) {
                currentIndex = carouselItems.length - 1;
            }
            goToSlide(currentIndex);
        }

        function slideNext() {
            currentIndex++;
            if (currentIndex >= carouselItems.length) {
                currentIndex = 0;
            }
            goToSlide(currentIndex);
        }

        prevButton.addEventListener('click', slidePrev);
        nextButton.addEventListener('click', slideNext);
    </script>
    </div>
</body>
</html>