## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.


## Laravel Background Jobs:
Ubuntu
Install Supervisor with sudo apt-get install supervisor. Ensure it's started with sudo service supervisor restart.

In /etc/supervisord/conf.d/ create a .conf file. In this example, laravel_queue.conf (contents below). Give it execute permissions: chmod +x laravel_queue.conf.

This file points at /usr/local/bin/run_queue.sh, so create that file there. Give this execute permissions, too: chmod +x run_queue.sh.

Now update Supervisor with: sudo supervisorctl reread. And start using those changes with: sudo supervisorctl update.

laravel_queue.conf
```
#!php

[program:laravel_queue]
command=/usr/local/bin/run_queue.sh
autostart=true
autorestart=true
stderr_logfile=/path/queue.err.log
stdout_logfile=/path/queue.out.log


```

run_queue.sh

```
#!php
#!/bin/bash
php /var/www/vhosts/adentdemo.info/htmldocs/matroshki-php/artisan  --timeout=0 queue:listen

```
Centos:
sudo yum install supervisor -y
sudo chkconfig supervisord on
Add to /etc/supervisord.conf

[program:laravel-queue-listener]
command=php /your/laravel/folder/artisan queue:listen --env=production --timeout=0

Restart supervisord

sudo service supervisord restart

## Development
Set `APP_ENV=local` for development

Clear everything
`php artisan cache:clear && php artisan clear-compiled && php artisan view:clear && php artisan route:clear && php artisan config:clear && php artisan debugbar:clear && composer dump && php artisan route:cache`

## CCBill Configuration
Approval and denial url: yourdomain/accesspayment
https://bill.ccbill.com/jpost/signup.cgi?clientAccnum=[CCBill Account Number]&clientSubacc=[Sub Account]&formName=[Form Name]&language=English&subscriptionTypeId=%subscriptionTypeId%&userid=%userId%&tokens=%tokens%&paymentType=tokens

##Social: laravel/socialite
Change clientId and clientSecret to public.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
