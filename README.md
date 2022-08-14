Простенькое приложение для загрузки сделок с amocrm в базу данных сервера.

Чтобы начать пользоваться приложением, для начала нужно ввести в командной строке git следующую команду: git clone https://github.com/Varosss/laravel-amocrm-app.git

Репозиторий с гитхаба будет установлен на ваш ПК.

После этого необходимо в файле .env (Внимание! Данный файл находится в основной папке всего приложения) задать настройки для базы данных PostgreSQL: DB_CONNECTION=pgsql DB_HOST=127.0.0.1 DB_PORT=5432 DB_DATABASE=example DB_USERNAME=postgres DB_PASSWORD=*****

Далее нужно поменять настройки в файле .env из папки main. Нужно записать туда данные amocrm интеграции: CLIENT_ID=example CLIENT_SECRET=example CLIENT_REDIRECT_URI=example CLIENT_AUTHORIZATION_CODE=one_more_example

Дальше введите в терминале cd main, а после php get_token.php. Эта команда создаст token_info.json в котором будут данные о вашем access_token и т.д. После выполнения вышеописанных действий перейдите снова в родительскую директорию (cd ..).

Далее запустим миграции командой: php artisan migrate.

И просто запустим сервер: php artisan serve

Перейдя по адресу "<my_address.ru>/" вы попадете на домашнюю страницу, а чтобы выгрузить сделки в базу данных просто перейдите по адресу "<my_address>/leads"

Всё :)
