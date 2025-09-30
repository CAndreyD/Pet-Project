# Warehouse API

REST API для управления складом, реализованный на **Laravel 10**.
Проект демонстрирует навыки работы с REST, Eloquent, JWT-аутентификацией, сервисным слоем, валидацией и Swagger-документацией.

---

## 🔹 Основные возможности

* CRUD для:

  * **Продукты (Products)**
  * **Категории (Categories)** с рекурсией и ограничением глубины
  * **Поставщики (Suppliers)**
  * **Поставки (Shipments)** с привязкой продуктов и количеством
  * **Движение склада (Stock Movements)**

* **JWT-аутентификация**

  * Логин / Регистрация
  * Refresh токены
  * Логаут и защита токенов

* **Валидация запросов** через Form Requests

* **Сервисный слой** для бизнес-логики

* **Swagger-документация** для всех API

* Рекурсивные отношения Eloquent

* Управление пользователями и правами доступа (Admin Middleware)

---

## 🔹 Технологии

* PHP 8.3+
* Laravel 12
* MySQL / MariaDB
* JWTAuth (`tymon/jwt-auth`)
* Swagger (через `l5-swagger`)
* Eloquent ORM
* Composer, Docker

---

## 🔹 Структура проекта

```
app/
├── Http/Controllers/Api      # REST API контроллеры
├── Http/Controllers/Auth     # Контроллеры авторизации
├── Models                    # Eloquent модели
├── Services                  # Сервисный слой (бизнес-логика)
├── Http/Requests             # Form Requests для валидации
├── Http/Resources            # API Resources
├── Http/Middleware           # Middleware
├── Docs                      # Swagger документация и схемы
```

---

## 🔹 Установка

1. Клонировать репозиторий:

```bash
git clone <repo-url>
cd warehouse-api
```

2. Установить зависимости:

```bash
composer install
npm install
```

3. Создать `.env` файл и настроить подключение к БД:

```bash
cp .env.example .env
php artisan key:generate
```
4.Запустить докеры
```bash
docker-compose build
```
5. Выполнить миграции:

```bash
docker-compose app php artisan migrate
```

6. Запустить локальный сервер:

```bash
docker-compose exec app php artisan serve --host=0.0.0.0 --port=8000
```

API будет доступен по адресу: `http://localhost:8000`

---

## 🔹 API Документация (Swagger)

Swagger UI доступен по адресу:

```
/api/documentation
```

Документация включает:

* Все маршруты
* Форматы запросов и ответов
* Схемы для Products, Categories, Suppliers, Shipments, Stock Movements

---

## 🔹 Примеры запросов

### Получить список продуктов

```
GET /api/products
```

Ответ:

```json
{
  "data": [
    {
      "id": 1,
      "name": "Product 1",
      "category": {
        "id": 1,
        "name": "Category 1"
      },
      "price": 100.0,
      "quantity": 10
    }
  ]
}
```

### Создать поставку

```
POST /api/shipments
```

```json
{
  "supplier_id": 1,
  "shipment_date": "2025-09-30",
  "products": [
    { "product_id": 1, "quantity": 5 },
    { "product_id": 2, "quantity": 10 }
  ]
}
```

---

## 🔹 Авторизация

* **Регистрация**: `POST /api/auth/register`
* **Логин**: `POST /api/auth/login`
* **Логаут**: `POST /api/auth/logout`
* **Обновление токена**: `POST /api/auth/refresh`
* **Сброс пароля**: `POST /api/auth/forgot-password` и `POST /api/auth/reset-password`

---

## 🔹 Особенности проекта

* **Рекурсивные категории** с ограничением глубины 3
* **Сервисный слой** для чистого и тестируемого кода
* **JWT + Refresh tokens** для безопасной аутентификации
* **Swagger** для быстрой проверки API

---

## 🔹 Тестирование

тесты через PHPUnit для сервисов и контроллеров:

```bash
docker-compose exec app php artisan test
```

Тестирование конкретного класса
```bash
docker-compose exec app php artisan test --testsuite=Feature
docker-compose exec app php artisan test tests/Feature/Category/CategoryCrudTest.php
```

Тестирование конкретного метода
```bash
docker-compose exec app ./vendor/bin/phpunit --filter test_index_returns_paginated_categories
```

## 🔹 P.S

Проект подготовлен для демонстрации навыков **PHP разработчика**.

