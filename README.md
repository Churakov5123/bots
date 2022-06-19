<h3>Запуск проекта:</h3>
<p>запустить в корне проекта выполнить cp .env.local .env , в дериктории для докера cp ./docker .env.local ./docker .env</p>
<p>docker-compose up -d --build (в последуюшем уже можно будет использовать docker-compose start/stop )</p>
<p>docker exec -it bots_php-fpm_1 bash (в контейнере запустить composer install)</p>

<h4>Примечание:</h4> 
<p>обновление зависимостей для проекта запускать только в контейнере, равно как и Symfony console.</p>

<h3>Стек технологий:</h3>
<p>Language: PHP 8.1.7/Framework:Symfony: "6.1"/DB:Mariadb:10.3/Cache:Redis/Queues:RabbitMQ</p>
<p>для удобства в локальной разработке вынесен клиент БД phpmyadmin.</p>
<p>используемые порты можно посмотреть с помощью docker-compose ps </p>

<h3>Проект бот знакомств</h3>
<p>bots/src/Bots  (реализован в виде модульной структуры, с использование подхода слоевой архитектуры)</p>


