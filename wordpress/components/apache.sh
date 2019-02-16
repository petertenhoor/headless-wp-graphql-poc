#!/bin/bash

apt-get install -y apache2

# determine a reasonable docroot
if [ -d /vagrant/web ]
	then
	DOCROOT="/web"
elif [ -d /vagrant/htdocs ]
	then
	DOCROOT="/htdocs"
elif [ -d /vagrant/public ]
	then
	DOCROOT="/public"
else
	# use the project root as a fallback
	DOCROOT=""
fi

# add a fqdn to ommit implicit localhost setting
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# webroot
sed -i "s#DocumentRoot /var/www/html#DocumentRoot ${VAGRANT_SYNCED_DIR}${DOCROOT}#" /etc/apache2/sites-enabled/000-default.conf
sed -i "s#</VirtualHost>#</VirtualHost>\n<Directory ${VAGRANT_SYNCED_DIR}${DOCROOT}/>\n\tOptions All\n\tAllowOverride All\n\tRequire all granted\n</Directory>#" /etc/apache2/sites-enabled/000-default.conf

# enable rewrite module:
ln -s /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

# install sendmail:
# set the hostname:
sed -i "s/127\.0\.0\.1\slocalhost/127\.0\.0\.1 localhost localhost.localdomain "$(hostname)"/" /etc/hosts
apt-get install -y sendmail
sed -i "1iHostsFile=/etc/hosts" /etc/mail/sendmail.conf
