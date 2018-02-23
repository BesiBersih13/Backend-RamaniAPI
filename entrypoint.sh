#!/bin/bash

ROOT_PROJECT=/var/www/html

cd $ROOT_PROJECT
echo ""
echo "load configuration"
source .env

echo ""
echo "starting service apache2"
service apache2 start

echo ""
echo "checking mysql database."
STATS=$(mysql -u root -h mariadb -e "show databases;"| grep $DB_DATABASE ;echo $?)

if [ $STATS -gt 0 ]; then
	echo ""
	echo "initialize database"
	mysql -u root -h mariadb -e "CREATE DATABASE $DB_DATABASE CHARACTER SET utf8 COLLATE utf8_general_ci;"
	mysql -u root -h mariadb -e "GRANT ALL PRIVILEGES ON \`$DB_USERNAME\`.* TO '$DB_USERNAME'@'%' IDENTIFIED BY '$DB_PASSWORD';"
	mysql -u root -h mariadb -e "FLUSH PRIVILEGES;"

        cd $ROOT_PROJECT
	echo ""
	echo "run composer for first time"
	composer install

	echo ""
	echo "generating key"
	php artisan key:generate

	echo ""
	echo "migrate database"
	php artisan migrate

	echo ""
	echo "deploying site"
	composer install --optimize-autoloader

	echo ""
	echo "setup cache"
	php artisan config:cache
else
	echo ""
	echo "database is exist."
	echo "skipping create database."
	echo ""
fi

echo ""
echo "end of script"
echo ""

tail -f /var/log/apache2/access.log
