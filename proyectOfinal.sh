```bash
#!/bin/bash

#############################################
# DEPLOY AUTOMATICO LARAVEL 12 - DEBIAN 12
#############################################

REPO="https://github.com/OswaldoGP/VeterinariaLaravel.git"

PROJECT_NAME="VeterinariaLaravel"

DB_NAME="veterinaria"
DB_USER="veterinaria"
DB_PASS="veterinaria123"

#############################################
# VERIFICAR ROOT
#############################################

if [ "$EUID" -ne 0 ]; then
    echo "Ejecuta como root"
    exit 1
fi

#############################################
# ACTUALIZAR SISTEMA
#############################################

apt update -y
apt upgrade -y

#############################################
# APACHE
#############################################

apt install apache2 -y

systemctl enable apache2
systemctl start apache2

#############################################
# MARIADB
#############################################

apt install mariadb-server mariadb-client -y

systemctl enable mariadb
systemctl start mariadb

#############################################
# PHP 8.2 Y EXTENSIONES
#############################################

apt install -y \
php \
php-cli \
php-common \
php-mysql \
php-mbstring \
php-xml \
php-curl \
php-zip \
php-bcmath \
php-gd \
php-intl \
libapache2-mod-php

#############################################
# HERRAMIENTAS
#############################################

apt install -y git curl unzip

#############################################
# NODEJS + NPM
#############################################

apt install -y nodejs npm

#############################################
# COMPOSER
#############################################

cd /tmp

curl -sS https://getcomposer.org/installer | php

mv composer.phar /usr/local/bin/composer

chmod +x /usr/local/bin/composer

#############################################
# APACHE MOD REWRITE
#############################################

a2enmod rewrite

#############################################
# CLONAR PROYECTO
#############################################

cd /var/www

git clone $REPO

cd /var/www/$PROJECT_NAME

#############################################
# DEPENDENCIAS PHP
#############################################

composer install --no-interaction --optimize-autoloader

#############################################
# DEPENDENCIAS JS
#############################################

npm install

npm run build

#############################################
# CREAR BASE DE DATOS
#############################################

mysql <<EOF

CREATE DATABASE IF NOT EXISTS $DB_NAME;

CREATE USER IF NOT EXISTS '$DB_USER'@'localhost'
IDENTIFIED BY '$DB_PASS';

GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';

FLUSH PRIVILEGES;

EOF

#############################################
# CONFIGURAR .ENV
#############################################

cp .env.example .env

sed -i "s|DB_CONNECTION=.*|DB_CONNECTION=mysql|g" .env

sed -i "s|# DB_HOST=.*|DB_HOST=127.0.0.1|g" .env
sed -i "s|# DB_PORT=.*|DB_PORT=3306|g" .env
sed -i "s|# DB_DATABASE=.*|DB_DATABASE=$DB_NAME|g" .env
sed -i "s|# DB_USERNAME=.*|DB_USERNAME=$DB_USER|g" .env
sed -i "s|# DB_PASSWORD=.*|DB_PASSWORD=$DB_PASS|g" .env

#############################################
# GENERAR KEY
#############################################

php artisan key:generate

#############################################
# MIGRACIONES + SEEDERS
#############################################

php artisan migrate --seed --force

#############################################
# OPTIMIZACIONES
#############################################

php artisan config:cache

php artisan route:cache

php artisan view:cache

#############################################
# PERMISOS
#############################################

chown -R www-data:www-data /var/www/$PROJECT_NAME

chmod -R 775 storage

chmod -R 775 bootstrap/cache

#############################################
# APACHE VHOST
#############################################

cat > /etc/apache2/sites-available/$PROJECT_NAME.conf <<EOF
<VirtualHost *:80>

    ServerAdmin webmaster@localhost

    DocumentRoot /var/www/$PROJECT_NAME/public

    <Directory /var/www/$PROJECT_NAME/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
EOF

a2ensite $PROJECT_NAME.conf

a2dissite 000-default.conf

systemctl reload apache2

#############################################
# FIREWALL
#############################################

if command -v ufw >/dev/null 2>&1; then
    ufw allow 80/tcp
fi

#############################################
# RESULTADO
#############################################

IP=$(hostname -I | awk '{print $1}')

echo ""
echo "====================================="
echo "DESPLIEGUE COMPLETADO"
echo "====================================="
echo ""
echo "URL:"
echo "http://$IP"
echo ""
echo "BD: $DB_NAME"
echo "Usuario: $DB_USER"
echo "Password: $DB_PASS"
echo ""
```
