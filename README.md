# Проект "Загрузка/занятость помещения"

## Описание и цель

Этот проект предназначен для управления загрузкой помещений, например, торгового центра, на основе данных, получаемых с устройств на входах и выходах. Данные о количестве посетителей поступают через API, и пользователи могут видеть информацию о загрузке по часам и дням.

## Установка и настройка

### Клонирование репозитория

Для начала склонируйте репозиторий проекта на вашу локальную машину:

```bash
git clone 
```

### Установка зависимостей

```bash
php composer.phar install
```

### Настройка .env файла
Скопируйте файл .env.example в .env:

```bash
cp .env.example .env
```

Отредактируйте файл .env для подключения к вашей базе данных. Например, для PostgreSQL:

```.env
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=occupancy_db
DB_USERNAME=postgres
DB_PASSWORD=1324
```

### Генерация ключа приложения

```bash
php artisan key:generate
```

### Запуск миграций базы данных

```bash
php artisan migrate
```

### Запуск локального сервера

```bash
php artisan serve
```
# Использование API



### Добавление данных о входах и выходах посетителей

API для добавления информации о посетителях доступен по следующим маршрутам:

POST или GET /api/input


Пример запроса:
```bash
curl -X POST "http://localhost:8000/api/input?time=1710806452&diff=-4"
```
time — время в формате Unix timestamp.
diff — изменение количества человек в помещении (положительное значение — зашло, отрицательное — вышло).



### Получение почасовой загрузки

GET /api/hours


Этот запрос возвращает информацию о загрузке по часам:
```bash
curl "http://localhost:8000/api/hours"
```
Ответ в формате JSON:
```json
{
    "byHours": {
        "10": "low",
        "11": "medium",
        "12": "high"
    }
}
```

### Получение загрузки по дням месяца
GET /api/days

```bash
curl "http://localhost:8000/api/days"
```
Ответ в формате JSON:
### 
```json
{
    "byDays": {
        "1": "low",
        "2": "medium",
        "3": "high"
    }
}
```


Требования

PHP 8.2 / 8.3
PostgreSQL 13+
Composer
