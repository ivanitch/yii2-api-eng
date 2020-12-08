<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project</h1>
    <br>
</p>

API App for Mobile English Learning App

Installation
-------------------
Clone project
```
git clone https://github.com/Ivanitch/yii2-api-eng.git
```
Initialize the project
```
php init
```
Install dependencies
```
composer install
```
Connect to the database and set the host for loading images using the example file <code>common/config/params.php</code>

Configuring a virtual hosts in Apache
-------------------
```
<VirtualHost *:80>
ServerName api.example.com
DocumentRoot /var/www/html/example.com/api/web
</VirtualHost>

<VirtualHost *:80>
ServerName storage.example.com
DocumentRoot /var/www/html/example.com/storage
</VirtualHost>
```

Usage in REST Client
-------------------
You must send the <code>X-Secret</code> header with the value <code>Secret</code>. We get all the data using the method GET !<br>
Get all categories
```
http://api.example.com/categories
```
Get all levels
```
http://api.example.com/levels
```
Get all themes
```
http://api.example.com/themes?category=1&level=1
```
Get all words
```
http://api.example.com/words
```
