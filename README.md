<h3>Запуск проекта:</h3>
<p>docker-compose up -d --build ( потом docker-compose start/stop )</p>
<p>docker exec -it bots_php-fpm_1 bash (в контейнере запустить composer install)</p>

<h4>Примечание:</h4> 
<p>обновление зависимостей для проекта запускать только в контейнере, равно как и Symfony console.</p>

<h3>Стек технологий:</h3>
<p> Language: PHP 8.1.7/Framework:Symfony: "6.1"/DB:Mariadb:10.3/Cache:Redis/Queues:RabbitMQ</p>
<p>Для удобства в локальной разработке вынесен клиент БД phpmyadmin.</p>
<p>Используемые порты можно посмотреть с помощью docker-compose ps </p>


<h3>Проект бот знакомств</h3>
<p>bots/src/Bots  (реализован в виде модульной структуры, с использование подхода слоевой архитектуры)</p>


