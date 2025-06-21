Учился писать на php+laravel для коммерческого заказа
---

# 🧩 Laravel Blog

## 🔧 Основные компоненты

### 1. **Структура проекта**
```
laravel-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Ваши контроллеры
│   │   └── Middleware/      # Мидлвары
│   ├── Models/              # Eloquent модели
│   └── Services/            # Службы бизнес-логики (если используются)
├── database/
│   ├── migrations/          # Миграции БД
│   ├── seeders/             # Заполнение данными
│   └── factories/           # Фабрики данных
├── routes/
│   ├── api.php              # API маршруты
│   └── web.php              # Веб-маршруты
├── config/
│   └── auth.php             # Настройки аутентификации
└── resources/
    └── views/               # Шаблоны (если используется SSR)
```

---

## 📦 Модели и миграции

### `User`
```php
class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
}
```
- Используется для аутентификации.
- Поддерживает токены API через `HasApiTokens`.

### `Category`
```php
class Category extends Model {
    protected $fillable = ['title'];
}
```
- Простая модель категории с названием.

### `Course`
```php
class Course extends Model {
    protected $fillable = [
        'title', 'price', 'students_qty', 'reviews_qty', 'category_id'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
```
- Связь с категорией через `belongsTo`.
- Хранит основную информацию о курсе.

---

## 🚀 API

Реализованы следующие эндпоинты:

### GET `/api/courses`
Возвращает список всех курсов:
```json
[
    {
        "id": 1,
        "title": "PHP для начинающих",
        "price": 4990,
        "students_qty": 250,
        "reviews_qty": 35,
        "category_id": 1
    }
]
```

### GET `/api/categories`
Возвращает список категорий:
```json
[
    {
        "id": 1,
        "title": "Программирование"
    },
    {
        "id": 2,
        "title": "Маркетинг"
    }
]
```

### GET `/api/courses/{id}`
Возвращает детали курса:
```json
{
    "id": 1,
    "title": "PHP для начинающих",
    "price": 4990,
    "students_qty": 250,
    "reviews_qty": 35,
    "category_id": 1,
    "created_at": "2025-06-01T08:00:00Z"
}
```

---

## 🔐 Аутентификация и авторизация

### Реализация:
- Используется **API Tokens** из пакета `laravel/sanctum`.
- Пользователь получает токен после успешной авторизации:
```php
$token = $user->createToken('auth_token')->plainTextToken;
```

### Пример запроса:
```bash
POST /login
{
    "email": "user@example.com",
    "password": "password"
}
```

### Ответ:
```json
{
    "access_token": "1|ABC123XYZ...",
    "token_type": "Bearer"
}
```

Токен передается в заголовке:
```http
Authorization: Bearer 1|ABC123XYZ...
```

---

## 🧪 Тестирование

### Unit-тесты
- Написаны с использованием PHPUnit.
- Пример теста:
```php
public function test_get_all_courses()
{
    $response = $this->get('/api/courses');
    $response->assertStatus(200);
}
```

### Pest (альтернативный фреймворк тестирования)
- Также поддерживается через `pestphp/pest`.
- Пример теста:
```php
test('get all courses', function () {
    get('/api/courses')->assertOk();
});
```

---

## 🛠 Дополнительно

### Фабрики и Seeder'ы
- Для удобного заполнения БД при разработке:
```php
// CourseFactory.php
public function definition()
{
    return [
        'title' => fake()->sentence(),
        'price' => fake()->randomFloat(2, 1000, 10000),
        'students_qty' => fake()->numberBetween(10, 1000),
        'reviews_qty' => fake()->numberBetween(1, 100),
        'category_id' => Category::factory(),
    ];
}
```

### Кастомная аутентификация
- Вы можете расширить систему через middleware или кастомные guard'ы:
```php
Auth::viaRequest('custom-token', function ($request) {
    return User::where('api_key', $request->token)->first();
});
```

