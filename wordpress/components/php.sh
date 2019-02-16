#!/bin/bash

# Set repository and update
add-apt-repository ppa:ondrej/php && apt-get update

# Php and Drivers 
apt-get install -y php7.1 libapache2-mod-php7.1 php7.1-intl php-apc php7.1-gd php7.1-curl php7.1-mysql php7.1-mcrypt php7.1-xsl php7.1-imagick php7.1-mbstring 

# Mcryp requires manual enabling:
phpenmod mcrypt

# Php Configuration
sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 1000M/" /etc/php/7.1/apache2/php.ini
sed -i "s/post_max_size = 8M/post_max_size = 1000M/" /etc/php/7.1/apache2/php.ini
sed -i "s/short_open_tag = On/short_open_tag = Off/" /etc/php/7.1/apache2/php.ini
sed -i "s/;date.timezone =/date.timezone = Europe\/Amsterdam/" /etc/php/7.1/apache2/php.ini
sed -i "s/memory_limit = 1024M/memory_limit = 1024M/" /etc/php/7.1/apache2/php.ini
sed -i "s/_errors = Off/_errors = On/" /etc/php/7.1/apache2/php.ini
sed -i "s/;max_input_vars = 10000/max_input_vars = 100000/" /etc/php/7.1/apache2/php.ini

# Phpunit
wget https://phar.phpunit.de/phpunit.phar
chmod +x phpunit.phar
mv phpunit.phar /usr/local/bin/phpunit
