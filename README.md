# Event Management Admin Panel

Этот проект — современная админ-панель для управления событиями и пользователями. Реализован на Laravel (backend) и современном стеке фронтенда (Vite, ES6+, Bootstrap, AdminLTE).

## Возможности
- Аутентификация и регистрация пользователей
- Просмотр, создание и управление событиями
- Просмотр профилей пользователей
- Современный адаптивный интерфейс (AdminLTE, Bootstrap 5)
- Уведомления и всплывающие сообщения
- Защита маршрутов и проверка токена

## Технологии
- **Backend:** Laravel 10+
- **Frontend:** Vite, ES6+, Bootstrap 5, AdminLTE 4, jQuery
- **База данных:** SQLite/MySQL/PostgreSQL (настраивается в `.env`)

## Быстрый старт

### 1. Клонируйте репозиторий
```bash
git clone https://github.com/webBeaver777/EventManagement.git
cd EventManagement
```

### 2. Установите зависимости
```bash
composer install
npm install
```

### 3. Скопируйте и настройте переменные окружения
```bash
cp .env.example .env
```
Отредактируйте `.env` при необходимости (DB_DATABASE, DB_USERNAME, DB_PASSWORD и др).

### 4. Сгенерируйте ключ приложения
```bash
php artisan key:generate
```

### 5. Выполните миграции и (опционально) сиды
```bash
php artisan migrate --seed
```

### 6. Соберите фронтенд-ассеты
```bash
npm run build
```
Для разработки используйте:
```bash
npm run dev
```

### 7. Запустите сервер
```bash
php artisan serve
```

Откройте [http://localhost:8000](http://localhost:8000) в браузере.

## Структура проекта
- `app/` — бизнес-логика, сервисы, контроллеры, модели
- `resources/views/` — Blade-шабл��ны
- `resources/js/`, `resources/css/` — фронтенд-ассеты
- `routes/` — маршруты (web.php, api.php)
- `database/` — миграции, сиды, фабрики

## Полезные команды
- `php artisan migrate:fresh --seed` — сбросить и заново наполнить базу
- `npm run dev` — запуск Vite в режиме разработки
- `npm run build` — сборка ассетов для продакшена

## Авторизация
- После регистрации пользователь автоматически авторизуется
- Для доступа к админке требуется авторизация

## Лицензия
MIT

