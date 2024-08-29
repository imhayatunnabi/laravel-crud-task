<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# System Requirements

In order to run a Laravel application, you'll need the following software and tools:

## 1. PHP 8.1

Download and install PHP 8.1 for your specific operating system:

- **Windows**:
  - [Download PHP 8.1 for Windows](https://windows.php.net/download/)

- **macOS**:
  - You can use Homebrew: `brew install php@8.1`

- **Linux**:
  - For Ubuntu/Debian, you can use a PPA:

    ```
    sudo add-apt-repository ppa:ondrej/php
    sudo apt update
    sudo apt install php8.1
    ```

## 2. Composer (Latest Version)

Download and install the latest version of Composer:

- **Windows**:
  - [Composer for Windows](https://getcomposer.org/Composer-Setup.exe)

- **macOS/Linux**:
  - Open your terminal and run:

    ```bash
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    mv composer.phar /usr/local/bin/composer
    ```

## 3. Choose Your Local Development Environment

You have several options for your local development environment:

### a. XAMPP (Cross-Platform)

- **Download XAMPP**: [XAMPP Downloads](https://www.apachefriends.org/index.html)

### b. LAMP (Linux, Apache, MySQL, PHP)

- You can install LAMP components individually on most Linux distributions.

### c. Laragon (Windows Only)

- **Download Laragon**: [Laragon Downloads](https://laragon.org/download/)

### d. LEMP (Linux, Nginx, MySQL, PHP)

- You can install Nginx, MySQL, and PHP-FPM on your Linux distribution.

## 4. Laravel Application

Clone your Laravel application from a Git repository or copy it to your local environment.

## 5. Configure Laravel

You need to configure your Laravel application to use the PHP version and database provided by your selected environment (XAMPP, LAMP, Laragon, or LEMP). Update your `.env` file to match your environment's settings.

---

With these requirements in place, you should be able to run your Laravel application seamlessly in your chosen development environment. Make sure to follow the documentation of your chosen environment for any additional setup or configuration details.

Enjoy developing your Laravel application!


## Installation Process

### Clone the repository

```bash
git clone git@github.com:neuralwebx/nimbrix_apis.git
```

```bash
cd project-directory
```

### Install Composer

```bash
composer install
```

#### If any error occure in composer install then run

```bash
composer install --ignore-platform-reqs
```

### Configure Environment variables

```bash
cp .env.example .env
```

### Run Artisan Command To Setup the project

```php
php artisan migrate:fresh --seed
```

### Serve The project

```bash
php artisan serve
```

#### Or if you want to use the host or port [optional](https://www.php.net/manual/en/features.commandline.webserver.php)

```bash
php artisan serve --host={your_host} --port={your_port}
```
#### generate postman api collection

```bash
php artisan export:postman
```
