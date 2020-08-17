![](https://zupimages.net/up/20/34/p27g.jpeg)

A PHP MVC system developed by a beginner. Accelerate the creation of your website and improve its organization with this system.

## Installation :

```bash
apt-get update && apt-get upgrade -y
apt-get install apache2 php php-mysql mariadb-server
a2enmod rewrite
git clone https://github.com/lucasmartinelle/MVC-PHP
mv MVC-PHP /var/www/html/
chown www-data:www-data /var/www/html/ -R && chmod 775 /var/www/html/ -R
```

Change `AllowOverride None` to `AllowOverride All` line 172 on `/etc/apache2/apache2.conf`. This change will allow you to create `.htaccess` files.

On `/etc/apache2/sites-enabled/000-default.conf` change `DocumentRoot /var/www/html/` by `DocumentRoot /var/www/html/MVC-PHP` on line 12

finally, don't forget to reload apache by executing : `systemctl reload apache2`

## Create the database :

```bash
mysql -u root
CREATE DATABASE MVC;
GRANT ALL ON MVC.* TO 'MVC'@'localhost' IDENTIFIED BY 'vVsVNx3XLhjyzYSK';
FLUSH PRIVILEGES;
quit
```

If you want, change the password for `MVC` user and also in `/var/www/html/MVC-PHP/app/init.php`

Uncomment `extension=pdo_mysql` on `/etc/php/{version}/apache2/php.ini`
in order to use PDO.

## Documentation :

Documentation is available [here](void).



