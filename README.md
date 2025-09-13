# WP Debug Log Enforcer

A WordPress plugin that ensures **all PHP errors, WordPress errors, and mail failures** are consistently logged into `wp-content/debug.log` — even when running under **Laravel Herd**, which by default redirects PHP logs to its own `php-fpm.log` files.

---

## 🚀 Why This Plugin?

When using **Laravel Herd**, PHP-FPM often sets:
```text
php_admin_value[error_log] = /Users/{user}/Library/Application Support/Herd/Log/php-fpm.log
```
This **blocks WordPress** from writing errors into `wp-content/debug.log`, since `php_admin_value` cannot be overridden by `ini_set()`.

👉 **WP Debug Log Enforcer** bypasses this limitation by:
- Capturing fatal errors at shutdown
- Hooking into WordPress error events
- Logging failed `wp_mail()` attempts
- Providing a global `write_log()` helper for custom logging


This plugin also provides a convenient `write_log()` helper for custom logging inside your WordPress projects.

---

## 🚀 Features
- ✅ Enforces error logging into `wp-content/debug.log`\
- ✅ Captures PHP fatal errors and WordPress PHP error events\
- ✅ Logs `wp_mail()` failures automatically\
- ✅ Provides a `write_log()` helper function for custom logs\
- ✅ PSR-4 autoloaded structure (Composer ready)

---

## 📂 Installation

   1. Clone or download the plugin into your WordPress `wp-content/plugins` directory:

   ```bash
  cd wp-content/plugins
   git clone https://github.com/imtiazepu/wp-debug-log-enforcer.git
```
  2. Install Composer dependencies (autoload):
```bash
cd wp-debug-log-enforcer
composer install
```
 3. Activate the plugin from WordPress → Plugins.
 4. Make sure you have the following in your wp-config.php:

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
```

Now all logs will be written into wp-content/debug.log.

⸻

## 🛠 Usage

Log custom data

```php
write_log( 'Hello, Debug Log!' );
write_log( [ 'order_id' => 123, 'status' => 'failed' ] );
```

Automatic error logging
-   PHP Fatal errors → logged automatically on shutdown
-   WordPress wp_php_error events → logged automatically
-   Mail failures → logged automatically via wp_mail_failed hook

⸻

## 📂 Project Structure

wp-debug-log-enforcer

```text
wp-debug-log-enforcer
├── composer.json
├── wp-debug-log-enforcer.php
└── src/
    ├── LogHelper.php
    ├── DebugLogEnforcer.php
    └── MailLogger.php
```
 -  LogHelper.php → global write_log() helper
 -  DebugLogEnforcer.php → handles PHP + WP error logging
 -  MailLogger.php → logs failed mail attempts

⸻

## 📦 Composer

This plugin uses PSR-4 autoloading.

```JSON
"autoload": {
  "psr-4": {
    "WPDebugLogEnforcer\\": "src/"
  }
}
```

Run after changes:

composer dump-autoload

⸻

## 📝 Requirements
-   PHP 8.0+
-   WordPress 6.0+
-   Composer (for autoload setup)

⸻

## 📜 License

GPL-2.0-or-later