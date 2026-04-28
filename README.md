
## 📘 About Translation Service

A **Translation Management API** for modern app.

It provides:
- Multi-language translation system
- Tag-based organization
- Fast search API (key, tag, content)
- High-performance JSON export
- Token authentication (Sanctum)
- Swagger/OpenAPI documentation

---

## 🚀 Features

- User Authentication (Register / Login / Logout)
- Translation CRUD
- Multi-language support (EN, FR, ES, etc.)
- Tag system (web, mobile, ecommerce)
- Advanced search:
  - By key
  - By tag
  - By translation value
- Fast JSON export API (Vue.js ready)
- Cached responses for performance
- Factory & Seeder support for large datasets
- Unit & Feature testing

---

## ⚙️ Installation

### 1. Clone Project
```bash
git clone <repo-url>
cd translation-service
````

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

```env
DB_DATABASE=translation_service
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Run Server

```bash
php artisan serve
```

---

## 🔐 Authentication API

### Register

```http
POST /api/register
```

### Login

```http
POST /api/login
```

### Logout

```http
POST /api/logout
Authorization: Bearer {token}
```

---

## 🌍 Translation API

### Get All

```http
GET /api/translations
```

### Create

```http
POST /api/translations
```

### Update

```http
PUT /api/translations/{id}
```

---

## 🔎 Search API

```http
GET /api/translations/search?key=welcome&tag=web&content=welcome
```

---

## 📦 Export API (Vue.js Ready)

```http
GET /api/export
```

### Response Example

```json
{
  "welcome_message": {
    "en": "Welcome",
    "fr": "Bienvenue"
  }
}
```

### Performance Note

* Cached using Laravel Cache
* Optimized DB joins
* Designed for < 500ms response time

---

## 📊 Swagger / API Documentation

Swagger UI available at:

```
http://127.0.0.1:8000/api/documentation
```

### Generate Docs

```bash
php artisan l5-swagger:generate
```

### Important Fixes (if errors occur)

Make sure your annotation class exists:

```php
/**
 * @OA\Info(
 *     title="Translation Service API",
 *     version="1.0.0",
 *     description="API documentation for Translation Service"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local Server"
 * )
 */
class OpenApi {}
```

---

## 🧪 Testing

```bash
php artisan test
```

### Performance Test Example

```php
$this->assertLessThan(500, $duration);
```

---

## 🏗 Architecture

* Controller → Thin Layer
* Repository → Database logic
* Actions → Business logic
* Cache → Performance optimization

---

## 📚 Documentation Links

* Laravel Docs → [https://laravel.com/docs](https://laravel.com/docs)
* Sanctum Auth → [https://laravel.com/docs/sanctum](https://laravel.com/docs/sanctum)
* Swagger L5 → [https://github.com/DarkaOnLine/L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger)
* OpenAPI Spec → [https://swagger.io/specification/](https://swagger.io/specification/)

---

## ⚡ Performance Rules

* Use `Cache::remember()` for export
* Avoid N+1 queries
* Index DB columns:

  * translations.key
  * tags.name
  * translation_values.value

## 🎯 Summary

This API is designed for:

* Fast frontend consumption (Vue.js / React)
* Scalable translation management
* High performance JSON export system
* Clean architecture (SOLID principles)

```
