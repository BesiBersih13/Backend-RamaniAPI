## Backend Ramani API

### Description
laravel 5.6 
> diskripsi menyusul :D

### Requirement

* composer
* apache2
* Laravel :
    * PHP >= 7.1.3
    * OpenSSL PHP Extension
    * PDO PHP Extension
    * Mbstring PHP Extension
    * Tokenizer PHP Extension
    * XML PHP Extension
    * Ctype PHP Extension
    * JSON PHP Extension
* phpmyadmin
* 

### Deployment
> Clone project
first you must to do is clonging the project of this repository to your web server
``` bash
 git clone https://github.com/abas/Android_RamaniFRONTEND.git
```

> Setting Up Apps
then open project directory and setting environment `.env`

##### database connection
``` bash
 cd Android_RamaniFRONTEND
 cp .env.example .env
 nano .env
```

in this section make sure your input database host user and password correctly
```
...
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={db_name}
DB_USERNAME={db_username}
DB_PASSWORD={db_password}
...
```

##### generating apps:keys
generating keys to project with simply command with `artisan`
``` bash
 php artisan key:generate
```

##### install dependency to project
``` bash
 composer install
```

##### deploying
When deploying to production, make sure that you are optimizing Composer's class autoloader map so Composer can quickly find the proper file to load for a given class

``` bash
 composer install --optimize-autoloader
```

##### optimizing configuration loading
When deploying your application to production, you should make sure that you run the `config:cache` Artisan command during your deployment process
``` bash
 php artisan config:cache
```


