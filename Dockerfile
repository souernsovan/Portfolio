# --- Stage 1: build frontend assets (Vite) ---
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources resources
COPY vite.config.js ./
RUN npm run build

# --- Stage 2: PHP + nginx runtime ---
FROM richarvey/nginx-php-fpm:3.1.6

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=assets /app/public/build /var/www/html/public/build

# Install PHP dependencies at build time, not at container startup — this makes
# boot fast and doesn't depend on network access when the container starts.
RUN composer install --no-dev --optimize-autoloader --no-interaction --working-dir=/var/www/html

# Make sure the nginx worker can actually read the compiled assets and app files,
# regardless of what user owned them during the build steps above.
RUN chown -R nginx:nginx /var/www/html \
    && find /var/www/html/public -type d -exec chmod 755 {} \; \
    && find /var/www/html/public -type f -exec chmod 644 {} \;

# Image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

CMD ["/start.sh"]
