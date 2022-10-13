<p>It would be cool when a person, flipping through the tape, could choose not only by photo ...</p>
<p>Idea suggestions are welcome..</p>
<p>Twitter</p> <a>https://twitter.com/Yan_yanii_yanii?t=FkxqWphO9pg7_ObrXKxHvw&s=35</a>
<p>Telegram</p> <a>https://t.me/bot_dates</a>


<h3>Launch of the project:</h3>
<p>run at the root of the project run cp .env.local .env , in docker directory cp ./docker .env.local ./docker .env</p>
<p>docker-compose up -d --build (later it will be possible to use docker-compose start/stop )</p>
<p>docker exec -it bots_php-fpm_1 bash (run in a container composer install)</p>

<h4>Note:</h4> 
<p>update dependencies for the project run only in the container, as well as the Symfony console, static analyzer, etc.</p>

<h3>Technology stack:</h3>
<p>Language: PHP 8.1.7/Framework:Symfony: "6.1"/DB:Mariadb:10.3/Cache:Redis/Queues:RabbitMQ</p>
<p>for convenience in local development, the phpmyadmin database client has been moved out.</p>
<p>ports used can be viewed with docker-compose ps </p>

<h3>Dating bot project</h3>
<p>Project idea: https://miro.com/app/board/uXjVOvdvz3k=/</p>
<p>bots/src/Bots  (implemented as a modular structure, using a layered architecture approach)</p>
<h3>Checking the codebase : running CS Fixer and static analyzer</h3>
<p>Run ./lint or commands from the list below</p>
<p>./vendor/bin/php-cs-fixer fix src</p>
<p>./vendor/bin/phpstan analyse  src</p>
<h3>Route list:</h3>
<p>php bin/console debug:router</p>