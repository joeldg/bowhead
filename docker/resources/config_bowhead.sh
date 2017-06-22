#! /bin/bash

#
# install and configure bowhead
#

phpenmod trader
service php7.1-fpm start
service mysql start
mysqladmin -u root password password
echo "CREATE DATABASE bowhead;" | mysql -u root -ppassword

cd ~
git clone https://github.com/joeldg/bowhead.git
cd bowhead
composer update
cp .env.example .env

mkfifo quotes
mysql -u root -ppassword -D bowhead < app/Scripts/DBdump.sql

#php artisan bowhead:example_usage

#/usr/bin/crontab /usr/src/crontab.tmp
#/usr/sbin/service cron start

# fire up supervisord
/usr/bin/supervisord