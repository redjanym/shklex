#!/usr/bin/env bash

bower install
composer install
php bin/console doctrine:migrations:migrate
php bin/console cache:clear

chmod -R 777 var/cache var/log
