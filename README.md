## Install dependecies
```
php bin/composer.phar install
```

Run with PHP built-in server: `php -S localhost:5000`

## Deploy with Nginx and FPM

### Config FPM

Find the FastCGI Process Manager's configuration file. It is usually called `php-fpm.conf`. Find a section like:

```
; The address on which to accept FastCGI requests.
; Valid syntaxes are:
;   'ip.add.re.ss:port'    - to listen on a TCP socket to a specific IPv4 address on
;                            a specific port;
;   '[ip:6:addr:ess]:port' - to listen on a TCP socket to a specific IPv6 address on
;                            a specific port;
;   'port'                 - to listen on a TCP socket to all addresses
;                            (IPv6 and IPv4-mapped) on a specific port;
;   '/path/to/unix/socket' - to listen on a unix socket.
; Note: This value is mandatory.
listen = 127.0.0.1:9000
```

If you cannot find it, try to see if there is a line (usually at the bottom of this file) `include=/usr/local/etc/php/7.2/php-fpm.d/*.conf`. The above section might be in the files pointed by `include`.

The value of `listen` is the address you will need to configure Nginx. You can change the PORT number to another one if it is already taken.

Start `php-fpm`:

```
php-fpm --fpm-config=/usr/local/etc/php/7.2/php-fpm.conf
```

### Config Nginx
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

The value of `fastcgi_pass` should be identical to the value of `listen` in the last step.

Now Nginx receive external request, and forward all request to `index.php`.

## URL

* `localhost:port` opens index page
* `localhost:port/hello/<whatever-name>` returns string `hello <whatever-name>`

## Coexistence of multiple PHP versions 多版本PHP共存

The key is to install different version of PHP to different directory, configure each version's `php-fmp` to listen on different port. But the easiest solution is Docker.

Start PHP 7.2:

In 7.2's `php-fpm.conf`, set: `listen = 127.0.0.1:9000`
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
