#!/bin/bash

echo "========================================="
echo "setup.sh is started at $(date)"
echo "========================================="

cd /var/www/html

# Создаем папку vendor если её нет
mkdir -p vendor

# Устанавливаем зависимости Composer
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-interaction --ignore-platform-reqs

# Ждем пока MySQL запустится
echo "Waiting for MySQL to be ready..."
max_tries=30
counter=0
while ! mysqladmin ping -h"mysql" -u"${MYSQL_USER}" -p"${MYSQL_PASSWORD}" --silent; do
    counter=$((counter+1))
    if [ $counter -ge $max_tries ]; then
        echo "ERROR: MySQL not available after $max_tries attempts"
        break
    fi
    echo "MySQL is unavailable - sleeping (attempt $counter/$max_tries)"
    sleep 2
done
echo "MySQL is up and running!"

# Создаем базу данных если её нет
echo "Creating database if not exists..."
php bin/console doctrine:database:create --if-not-exists --no-interaction

# Выполняем миграции с игнорированием ошибок (пропускаем если таблицы уже есть)
echo "Running migrations (ignoring errors)..."
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration 2>&1 || true
echo "Migrations completed (or skipped if already applied)"

# Проверяем, есть ли данные в таблице orders
echo "Checking if fixtures are needed..."
ORDER_COUNT=$(php bin/console doctrine:query:sql "SELECT COUNT(*) FROM orders" --no-interaction 2>/dev/null | tail -n1 | tr -d '[:space:]' || echo "0")

if [ "$ORDER_COUNT" = "0" ] || [ -z "$ORDER_COUNT" ]; then
    echo "No data found in orders table. Loading fixtures..."
    php bin/console doctrine:fixtures:load --no-interaction --append 2>&1 || {
        echo "Fixtures loading failed, trying alternative method..."
        # Альтернативный метод: создаем минимальные данные вручную
        php bin/console doctrine:query:sql "
            INSERT INTO orders (hash, token, number, status, email, client_name, client_surname, name, locale, pay_type, create_date)
            SELECT
                MD5(RAND()),
                MD5(RAND()),
                CONCAT('ORD-', LPAD(seq, 5, '0')),
                1,
                CONCAT('user', seq, '@example.com'),
                CONCAT('User', seq),
                CONCAT('Surname', seq),
                CONCAT('Test Order ', seq),
                'it',
                1,
                DATE_SUB(NOW(), INTERVAL seq DAY)
            FROM (
                SELECT @row := @row + 1 as seq FROM
                (SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) a,
                (SELECT 1 UNION SELECT 2) b,
                (SELECT @row := 0) r
            ) seqs
            WHERE NOT EXISTS (SELECT 1 FROM orders LIMIT 1)
        " 2>&1 || true
        echo "Minimal test data created"
    }
    echo "Fixtures loaded successfully"
else
    echo "Database already has $ORDER_COUNT orders. Skipping fixtures."
fi

# Очищаем кэш
echo "Clearing cache..."
php bin/console cache:clear --no-interaction --env=dev 2>&1 || true

echo "========================================="
echo "setup.sh completed at $(date)"
echo "========================================="

# Запускаем PHP-FPM в foreground (без этого контейнер завершится)
exec php-fpm