Запуск проекта:

Выполнить ```docker-compose up --build```

Для импорта БД выполнить команды:

```
docker cp www/dump/itorum.sql testtask-itorum_db_1:/
docker exec -ti testtask-itorum_db_1 bash
mysql -u mysql -pmysql itorum < itorum.sql
```

Если будут проблемы с правами то:
```
docker exec -ti testtask-itorum_www_1 bash
chmod -R 644 /var/www/html
find /var/www/ -type d -exec chmod 755 {} \;
chmod 777 /var/www/html/public/orders.json 
```

Данные для входа на главную страницу 
```
Логин admin
Пароль demo
```

Данные для входа на страницу экспорта
```
Логин admin
Пароль admin
```