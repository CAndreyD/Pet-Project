# 📦 Warehouse API

REST API для управления товарами, категориями и поставками на складе.

## 🚀 Фичи
- Товары, категории (вложенные), поставщики
- JWT аутентификация (роль admin/user)
- Swagger-документация
- Docker окружение
- CI (GitHub Actions)
- Тесты (PHPUnit)

## 🧱 Технологии
- Laravel 10
- MySQL 8
- Docker + Docker Compose
- JWT
- Swagger / OpenAPI
- PHPUnit

## ⚙️ Установка

```bash
git clone https://github.com/yourname/warehouse-api.git
cd warehouse-api
cp .env.example .env
docker-compose up -d --build
docker exec -it warehouse-api-php composer install
docker exec -it warehouse-api-php php artisan migrate

## зайти в докер
```bash
docker exec -it warehouse-api-app-1 bash