#!/bin/sh

set -e

chown -R www-data:www-data /var/www/Public
chown -R www-data:www-data /var/www/Application/Runtime
chmod -R 775 /var/www/Public
chmod -R 775 /var/www/Application/Runtime

# wait for mysql

until php -r 'try {
    $dbh = new PDO("$argv[1]:host=$argv[2];dbname=$argv[3]", $argv[4], $argv[5]); //初始化一个PDO对象 \
    echo "mysql connected ok\n";
    $dbh = null;
} catch (PDOException $e) {
    fwrite(STDERR, "mysql is unavailable!: " . $e->getMessage() . "\n");
    exit(1);
}' -- ${DB_CONNECTION} ${DB_HOST} ${DB_DATABASE} ${DB_USERNAME} ${DB_PASSWORD} ; do
  sleep 1
done

php-fpm
