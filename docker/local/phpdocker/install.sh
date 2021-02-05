# Переходим в корневую папку
cd /application && \

# Устанавливаем приложение
composer install && \

# Копируем конфиги, генерируем ключ приложения, запускаем миграции
cp .env.example .env && php artisan key:generate && php artisan migrate && \

# Возвращаемся в папку обратно
cd /application/docker/local
