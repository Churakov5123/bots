<h3>Запуск проекта:</h3>
 - docker-compose up -d --build ( потом docker-compose start/stop )
 - docker exec -it bots_php-fpm_1 bash (в контейнере запустить composer install)

<h4>Примечание:</h4> 
 - обновление зависимостей для проекта запускать только в контейнере, равно как и Symfony console.

<h3>Стек технологий:</h3>
- Language: PHP 8.1.7/Framework:Symfony: "6.1"/DB:Mariadb:10.3/Cache:Redis/Queues:RabbitMQ
- Для удобства в локальной разработке вынесен клиент БД phpmyadmin.
- Используемые порты можно посмотреть с помощью docker-compose ps 


<h3>Проект бот знакомств</h3>
- bots/src/Bots  (реализован в виде модульной структуры, с использование подхода слоевой архитектуры) 


