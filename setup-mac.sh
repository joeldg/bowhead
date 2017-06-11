brew install redis
brew install mysql
curl -O http://pear.php.net/go-pear.phar
sudo php -d detect_unicode=0 go-pear.phar
sudo pecl install trader
mkfifo quotes
