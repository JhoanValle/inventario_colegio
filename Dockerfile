# Etapa 1: Construcción de Assets (Node)
FROM node:20 AS node-builder
WORKDIR /app
COPY . .
RUN npm install && npm run build

# Etapa 2: Imagen Final (PHP)
FROM php:8.2-fpm

# Instalar dependencias del sistema y Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuración de Nginx
RUN echo 'server { \n\
    listen 8080; \n\
    root /var/www/html/public; \n\
    index index.php index.html; \n\
    client_max_body_size 64M; \n\
    location / { \n\
    try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
    include fastcgi_params; \n\
    fastcgi_pass 127.0.0.1:9000; \n\
    fastcgi_index index.php; \n\
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
    } \n\
    }' > /etc/nginx/sites-available/default

# Configuración de PHP
RUN echo "upload_max_filesize = 64M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

# Copiar el código del proyecto
COPY . /var/www/html
WORKDIR /var/www/html

# Copiar assets compilados
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Instalar dependencias
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

EXPOSE 8080

# Comando de inicio: Recrea el enlace simbólico y corre los servicios
CMD php artisan storage:link --force && php artisan migrate --force && php-fpm -D && nginx -g "daemon off;"