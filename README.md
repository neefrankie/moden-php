## Install dependecies
```
php bin/composer.phar install
```

Run with PHP built-in server: `php -S localhost:5000`

## Deploy with Nginx
```
server {
    listen 80;
    server_name example.com;
    index index.php;
    error_log /home/logs/modern-php.error.log;
    access_log /home/logs/modern-php.access.log;
    root /home/modern-php;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        fastcgi_index index.php;
        fastcgi_pass 127.0.0.1:9000;
    }
}
```

Start `php-fpm`:

```
php-fpm --fpm-config=/usr/local/etc/php/7.2/php-fpm.conf
```

Nginx receive external request, and forward all request to `index.php`.

## URL

* `localhost:port` opens index page
* `localhost:port/hello/<whatever-name>` returns string `hello <whatever-name>`

## Coexistence of multiple PHP versions

Start PHP 7.2:

In 7.2's `php-fpm.conf`, set pool definitions: `listen = 127.0.0.1:9000`
```
php-fpm --fpm-config=/usr/local/etc/php/7.2/php-fpm.conf
```

Start PHP 5.6:

In 5.6's `php-fpm.conf`, set pool definitions: `listen = 127.0.0.1:9001`.

Then
```
/usr/local/Cellar/php@5.6/5.6.35_1/sbin/php-fpm --fpm-config=/usr/local/etc/php/5.6/php-fpm.conf
```

Nginx config:
```
server {
    listen 8090;
    server_name localhost;
    index index.php;
    error_log /home/logs/php7.error.log;
    access_log /home/logs/php7.access.log;
    root /home/modern/php;
    
    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        fastcgi_index index.php;
        fastcgi_pass 127.0.0.1:9000;
    }
}

server {
    listen 8091;
    server_name localhost;
    index index.php;
    error_log /home/logs/php5.6.error.log;
    access_log /home/php5.6.access.log;
    root /home/legacy/code;
    
    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        fastcgi_index index.php;
        fastcgi_pass 127.0.0.1:9001;
    }
}
```

Start nginx.

`localhost:8090` will use PHP 7.2. `localhost:8091` will use PHP 5.6.

Verified on Mac OS 10.13.4.