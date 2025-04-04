# پروژه ساختار ربات

[فارسی](README.fa.md) | [English](README.md)

یک فریمورک ربات تلگرام مبتنی بر PHP با ساختار ماژولار دستورات.

## ساختار پروژه

```
BotStractuer/
├── App/
│   └── Commands/
│       ├── BotCommands/    # کلاس‌های دستورات ربات
│       └── Kernal.php      # هسته اصلی
├── bot.php                 # فایل اصلی ربات
├── autoload.php            # اتولودر کلاس‌ها
├── config.php              # فایل تنظیمات
└── error.log              # لاگ خطاها
```

## راه‌اندازی

1. اطمینان حاصل کنید که PHP 8 یا بالاتر نصب شده است
2. توکن ربات تلگرام خود را پیکربندی کنید
3. وب‌هوک خود را به `bot.php` متصل کنید

## ساختار پیکربندی

فایل `config.php` شامل تمام تنظیمات است:

```php
# تنظیمات پایگاه داده
const DB_HOST = 'localhost';
const DB_NAME = 'bot';
const DB_USER = 'root';
const DB_PASS = '';

# تنظیمات تلگرام
const TELEGRAM_TOKEN = 'YOUR_BOT_TOKEN';
const TELEGRAM_API_URL = 'https://api.telegram.org/bot';
const TELEGRAM_WEBHOOK_URL = 'https://your-domain.com/bot.php';
```

## افزودن دستورات

کلاس‌های دستور را در پوشه `App/Commands/BotCommands/` قرار دهید.
هر دستور باید در فایل PHP خود با همان نام کلاس باشد.

## ابزار کمکی (Helper)

ابزار کمکی چندین دستور برای مدیریت ربات شما فراهم می‌کند:

| دستور | توضیحات |
|---------|-------------|
| `helper table:up` | ایجاد تمام جداول پایگاه داده |
| `helper table:fresh` | حذف و ایجاد مجدد تمام جداول |
| `helper make:command {name}` | ایجاد یک کلاس دستور جدید |
| `helper delete:command {name}` | حذف یک کلاس دستور |
| `helper make:table {name}` | ایجاد یک کلاس جدول جدید |
| `helper delete:table {name}` | حذف یک کلاس جدول |
| `helper webhook:set` | تنظیم URL وب‌هوک برای ربات |
| `helper webhook:delete` | حذف URL وب‌هوک ربات |

### مثال‌ها:

```bash
# ایجاد یک دستور جدید
helper make:command StartCommand

# ایجاد یک جدول جدید
helper make:table Users

# تنظیم وب‌هوک
helper webhook:set
```

## مدیریت پایگاه داده

### استفاده از Schema
کلاس Schema متدهای روان برای عملیات پایگاه داده فراهم می‌کند:

```php
use App\Database\Schema;

// انتخاب داده
Schema::table('users')
    ->select(['id', 'username'])
    ->where('active', '=', 1)
    ->get();

// درج داده
Schema::table('users')->insert([
    'username' => 'john',
    'email' => 'john@example.com'
]);

// بروزرسانی داده
Schema::table('users')
    ->where('id', '=', 1)
    ->update(['status' => 'active']);

// حذف داده
Schema::table('users')
    ->where('id', '=', 1)
    ->delete();

// شمارش رکوردها
$count = Schema::table('users')
    ->where('status', '=', 'active')
    ->count();
```

### ایجاد جداول
از کلاس CreateTable برای تعریف ساختار پایگاه داده استفاده کنید:

```php
use App\Database\CreateTable;

class Users extends CreateTable
{
    public static function up(): void
    {
        self::table('users')
            ->int('id')->primaryKey()->autoIncrement()
            ->varchar('username', 100)->notNull()->unique()
            ->varchar('email', 255)->nullable()
            ->text('bio')
            ->datetime('last_login')->nullable()
            ->int('status')->default(1)
            ->create();
    }

    public static function down(): void
    {
        self::drop('users');
    }
}
```

انواع ستون‌های موجود:
- `int(name, [length])`
- `varchar(name, length)`
- `text(name)`
- `datetime(name)`

اصلاح‌کننده‌های ستون:
- `primaryKey()`
- `autoIncrement()`
- `notNull()`
- `nullable()`
- `unique()`
- `default(value)`
- `index()`
- `foreignKey(table, column)`

## مدیریت خطاها

خطاها در فایل `error.log` ثبت می‌شوند. حالت دیباگ را می‌توان با تغییر
`display_errors` در `bot.php` فعال کرد.
