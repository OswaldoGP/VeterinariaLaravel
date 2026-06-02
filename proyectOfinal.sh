```bash
#!/bin/bash

#####################################
# VARIABLES
#####################################

REPO="https://github.com/USUARIO/veterinaria.git"
PROYECTO="veterinaria"

DB_NAME="veterinaria"
DB_USER="root"
DB_PASS=""

#####################################
# ACTUALIZAR SISTEMA
#####################################

apt update
apt upgrade -y

#####################################
# INSTALAR APACHE
#####################################

apt install apache2 -y

#####################################
# INSTALAR MARIADB
#####################################

apt install mariadb-server mariadb-client -y

systemctl enable mariadb
systemctl start mariadb

#####################################
# INSTALAR PHP
#####################################

apt install -y \
php \
php-cli \
php-common \
php-mysql \
php-xml \
php-mbstring \
php-curl \
php-zip \
php-bcmath \
php-gd \
php-intl \
libapache2-mod-php

#####################################
# INSTALAR GIT
#####################################

apt install git -y

#####################################
# INSTALAR UNZIP
#####################################

apt install unzip -y

#####################################
# INSTALAR CURL
#####################################

apt install curl -y

#####################################
# INSTALAR COMPOSER
#####################################

curl -sS https://getcomposer.org/installer | php

mv composer.phar /usr/local/bin/composer

chmod +x /usr/local/bin/composer

#####################################
# HABILITAR MOD_REWRITE
#####################################

a2enmod rewrite

#####################################
# CLONAR PROYECTO
#####################################

cd /var/www

git clone $REPO

cd $PROYECTO

#####################################
# INSTALAR DEPENDENCIAS LARAVEL
#####################################

composer install --no-interaction

#####################################
# CONFIGURAR .ENV
#####################################

cp .env.example .env

cat > .env <<EOF
APP_NAME=Veterinaria
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=$DB_NAME
DB_USERNAME=$DB_USER
DB_PASSWORD=$DB_PASS

CACHE_STORE=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
EOF

#####################################
# CREAR BASE DE DATOS
#####################################

mysql -u root <<MYSQL_SCRIPT
CREATE DATABASE IF NOT EXISTS $DB_NAME;
MYSQL_SCRIPT

#####################################
# GENERAR KEY
#####################################

php artisan key:generate

#####################################
# MIGRACIONES
#####################################

php artisan migrate --force

#####################################
# CACHE
#####################################

php artisan config:cache

php artisan route:cache

php artisan view:cache

#####################################
# PERMISOS
#####################################

chown -R www-data:www-data /var/www/$PROYECTO

chmod -R 775 storage

chmod -R 775 bootstrap/cache

#####################################
# APACHE
#####################################

cat > /etc/apache2/sites-available/$PROYECTO.conf <<EOF
<VirtualHost *:80>

ServerAdmin admin@localhost

DocumentRoot /var/www/$PROYECTO/public

<Directory /var/www/$PROYECTO/public>
AllowOverride All
Require all granted
</Directory>

ErrorLog \${APACHE_LOG_DIR}/error.log
CustomLog \${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
EOF

a2ensite $PROYECTO.conf

a2dissite 000-default.conf

systemctl reload apache2

#####################################
# FINALIZAR
#####################################


echo "DESPLIEGUE COMPLETADO"
echo "Proyecto: $PROYECTO"
echo "Ruta: /var/www/$PROYECTO"
```

# nano deploy.sh
# chmod +x deploy.sh
# sudo ./deploy.sh 