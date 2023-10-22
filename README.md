<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


[Laravel 10.x](https://laravel.com/docs/10.x)

##### Libraries
- [Laravel Sanctum 3.2](https://laravel.com/docs/10.x/sanctum)
- [Spatie Laravel Permission 5.11](https://spatie.be/docs/laravel-permission/v5/introduction)
- [Purifier 3.4](https://spatie.be/docs/laravel-permission/v5/introduction)
##### Requirements
- PHP 8.1

##### Installation
    ```
    composer install
    ```
    ```
    php artisan migrate:fresh --seed --seeder=PermissionDemoSeeder
    ```
    ```
    copy .env-example to .env
    ```

##### Installation
     ```
    php artisan serve
    ```
##### Structure
- app
    - Console
    - DataTransferObject
    - Exception
    - Http
    - Models
    - Providers
    - Repositories
    - Services
    - Traits
        - Acessor
- bootstrap
- config
- database
    - factories
    - migrations
    - seeders
- public
- resources
    - css
    - js
    - views
        - email
- routes
- storage
    - app
    - framework
    - logs
- tests

#### Source
[Learning Resources](https://github.com/yaza-putu/laravel-repository-with-service/tree/master/src)

#### Laravel Optimize Performance (optional)
1. When installing vendors in Laravel, use the --no-dev option so that development dependencies are not installed.
    ```
    composer install --optimize-autoloader --no-dev
    ```
2. Use artisan optimize
    ```
    php artisan optimize
    ```
