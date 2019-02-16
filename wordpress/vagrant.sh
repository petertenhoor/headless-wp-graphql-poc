export VAGRANT_SYNCED_DIR=$1
export VAGRANT_COMPONENTS_DIR="${VAGRANTS_SYNCED_DIR}/vagrant/components"

# apt: mirror setup to use de mirror
sed -i "s/us\.archive\.ubuntu\.com/de\.archive\.ubuntu\.com/" /etc/apt/sources.list
apt-get update

# Shell scripts:
$VAGRANT_COMPONENTS_DIR/apache.sh
$VAGRANT_COMPONENTS_DIR/mysql.sh
$VAGRANT_COMPONENTS_DIR/php.sh
$VAGRANT_COMPONENTS_DIR/wpcli.sh

#Reload apache configuration
/etc/init.d/apache2 restart

echo "------------------------------------------"
echo "Okay, your vagrant-lamp Box is all set up."
