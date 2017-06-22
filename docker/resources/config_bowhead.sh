#! /bin/bash

#
# install and configure bowhead
#

phpenmod trader
phpenmod mcrypt
service php7.1-fpm start
service mysql start
service redis-server start
mysqladmin -u root password password
echo "CREATE DATABASE bowhead;" | mysql -u root -ppassword

cd ~
git clone https://github.com/joeldg/bowhead.git
cd bowhead
echo "-----------------------------------------------------------------"
echo "------ THIS IS GOING TO TAKE A LITTLE WHILE ..... please wait. --"
echo "-----------------------------------------------------------------"
composer update
cp .env.example .env

ln -s /root/bowhead/public /var/www/html/bowhead

mkfifo quotes
mysql -u root -ppassword -D bowhead < app/Scripts/DBdump.sql

php artisan bowhead:example_usage

#/usr/bin/crontab /usr/src/crontab.tmp
#/usr/sbin/service cron start

echo "--------------------------------------------------------------------------"
echo "------ Bowhead is now set up:                                       ------"
echo "------ you need to modify your /root/bowhead/.env                   ------"
echo "------                                                              ------"
echo "------ SWAP TO A DIFFERENT TERMINAL TO CONNECT TO THIS INSTANCE     ------"
echo "------ USE: 'docker ps' to see instance id (on the left)            ------"
echo "------ USE: 'docker exec -it {id} /bin/bash to get terminal access  ------"
echo "--------------------------------------------------------------------------"

# fire up supervisord
/usr/bin/supervisord