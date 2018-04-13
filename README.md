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
    error_log /path/to/example.error.log;
    access_log /path/to/example.access.log;
    root /path/to/public;

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
