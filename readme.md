<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>
## Update chức năng 15/06/2019<br>
- Quên mật khẩu<br>
- Gửi mail phản hồi cho cố vấn học tập chưa phản hồi

# Deploy Tutorial 07/10/2019
```
(Does not work in PHP 7.2 please select a version other than it)
```

## Setting in Localhost/ Using virtual servers such as wampserver, ampp, ... 

### 1. Use gitbase to get source code:
```
$ git clone https://github.com/taisaoem1368/qlsv-groupb.git
```
### 2. Config database
- create file name `.evn` then copy data from file `.env.example` to file `.env` then configure database for laravel easily

### 3. Create new APP_KEY
- open file in path: `./config/app.php` in line 106 change to `'key' => env('APP_KEY', 'SomeRandomString'),`
- run cmd:
```
php artisan key:generate
```
### 4. Config mail
- file `.env` in line 26 and file `./config/mail.php`

### 5. Run Composer
- Open command and run:
```
composer update
php artisan config:cache
```
After completing the 5 steps above, you can access your website

## Put source on Shared Hosting
### 1. Upload source to hosting.
- Compress your file to `qlsv.zip` and use cPanel extract file `qlsv.zip`

### 2. File structure and database configuration
- Move all files to the same level as the public_html directory
- `Remove file public_html` and Change folder name `public` to `public_html`
- Config database file `.env` and file in path: `./config/database.php` (line 42 if your use mysql or other)
- wirte more line `'options' => [PDO::ATTR_EMULATE_PREPARES => true],` in array `'mysql'` (line 42 if your use mysql or other)

### 3. Setup APP_KEY
- Copy APP_KEY in file `.env`
- Open file in path: `./config/app.php` in line 106 change to 
```
'key' => env('APP_KEY', base64_decode('YOUR_APP_KEY')),
```
example: `'key' => env('APP_KEY', base64_decode('lT2Wh7XRE3NcuzlqhsX6GOKhxWtdyWjtqpdjupZoC7A=')),`

### 4. Change path.public Laravel to public_html
- Open file in path: `./app/Providers/AppServiceProvider.php` line 26 and wirte 
```diff
$this->app->bind('path.public', function(){ return base_path().'/public_html'; });
```


After completing all the above steps you can enjoy.
`Deploy Tutorial by QuyenZepZai demo project at ` [Fandi.ml](http://fandi.ml) with username and password as `superadmin`

## Put source on VPS
updating...
