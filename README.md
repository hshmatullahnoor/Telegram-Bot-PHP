# Bot Structure Project

[فارسی](README.fa.md) | [English](README.md)

A PHP-based Telegram bot framework with a modular command structure.

## Project Structure

```
BotStractuer/
├── App/
│   └── Commands/
│       ├── BotCommands/    # Bot command App
│       └── Kernal.php      # Core initialization
├── bot.php                 # Main bot file
├── autoload.php            # Class autoloader
├── config.php              # Configuration file
└── error.log               # Error logging
```

## Setup

1. Make sure you have PHP 8 or higher installed
2. Configure your Telegram bot token
3. Set up your webhook to point to `bot.php`

## Configuration Structure

The `config.php` file contains all the configuration settings:

```php
# Database Configuration
const DB_HOST = 'localhost';
const DB_NAME = 'bot';
const DB_USER = 'root';
const DB_PASS = '';

# Telegram Configuration
const TELEGRAM_TOKEN = 'YOUR_BOT_TOKEN';
const TELEGRAM_API_URL = 'https://api.telegram.org/bot';
const TELEGRAM_WEBHOOK_URL = 'https://your-domain.com/bot.php';
```

## Adding Commands

Place your command App in the `App/Commands/BotCommands/` directory.
Each command should be in its own PHP file with the same name as the class.

## Helper Utility

The helper utility provides several commands to manage your bot:

| Command | Description |
|---------|-------------|
| `helper table:up` | Create all database tables |
| `helper table:fresh` | Drop and recreate all tables |
| `helper make:command {name}` | Create a new bot command class |
| `helper delete:command {name}` | Delete a bot command class |
| `helper make:table {name}` | Create a new database table class |
| `helper delete:table {name}` | Delete a database table class |
| `helper webhook:set` | Set the webhook URL for the bot |
| `helper webhook:delete` | Delete the webhook URL for the bot |

### Examples:

```bash
# Create a new command
helper make:command StartCommand

# Create a new table
helper make:table Users

# Set up the webhook
helper webhook:set
```

## Database Management

### Schema Usage
The Schema class provides fluent methods for database operations:

```php
use App\Database\Schema;

// Select data
Schema::table('users')
    ->select(['id', 'username'])
    ->where('active', '=', 1)
    ->get();

// Insert data
Schema::table('users')->insert([
    'username' => 'john',
    'email' => 'john@example.com'
]);

// Update data
Schema::table('users')
    ->where('id', '=', 1)
    ->update(['status' => 'active']);

// Delete data
Schema::table('users')
    ->where('id', '=', 1)
    ->delete();

// Count records
$count = Schema::table('users')
    ->where('status', '=', 'active')
    ->count();
```

### Creating Tables
Use CreateTable class to define database structures:

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

Available Column Types:
- `int(name, [length])`
- `varchar(name, length)`
- `text(name)`
- `datetime(name)`

Column Modifiers:
- `primaryKey()`
- `autoIncrement()`
- `notNull()`
- `nullable()`
- `unique()`
- `default(value)`
- `index()`
- `foreignKey(table, column)`

## Error Handling

Errors are logged to `error.log` file. Debug mode can be enabled by changing
`display_errors` in `bot.php`.

#   T e l e g r a m - B o t - P H P 
 
 
