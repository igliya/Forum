# Форум
Сайт форум по дисциплине "Технологии разработки WEB-приложений"

Для развёртывания Symfony-приложения:

1. Установите Composer

2. Установите Symfony CLI

3. Выполните команду *composer install* в корне проекта для установки необходимых пакетов

4. Отредактируйте переменные окружения - пропишите строку подключения к БД. Например: *DATABASE_URL=pgsql://postgres:@127.0.0.1:5432/forum?serverVersion=13&charset=utf8*

5. Если указанная в 4 пункте база данных не создана - создайте её командой *symfony console doctrine:database:create*

6. Примените миграции к БД командой *symfony console doctrine:migrations:migrate*

7. Загрузите фикстуры командой *symfony console doctrine:fixtures:load*

Приложение настроено и готово к работе. Для его запуска можно использовать встроенный сервер командой *symfony server:start*. В случае, если используется
сторонний сервер (к примеру, Nginx), то для корректной работы домен нужно указать на папку /public

Данные фикстур:
1. Пользователь:
    - логин: user@example.com
    - пароль: User123!
    
2. Администратор
    - логин: admin@example.com
    - пароль: Admin123!