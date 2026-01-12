# Stage 1: Build assets
FROM php:8.4-cli-alpine AS builder

# Install Node.js and build tools
RUN apk add --no-cache nodejs npm

# Set working directory
WORKDIR /var/www/html

# Install Composer dependencies
COPY composer.json composer.lock ./
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Install Node dependencies
COPY package*.json vite.config.js ./
RUN npm install

# Copy the rest of the app
COPY . .

# Generate autoloader and build assets
RUN composer dump-autoload --optimize && \
    npm run build

# Stage 2: Nginx production image
FROM nginx:alpine

# Copy custom Nginx configuration
# -----------------------------------------------------------
# Replace the default Nginx configuration with our custom one
# that is optimized for serving a Laravel application.
# -----------------------------------------------------------
COPY ./docker/production/nginx/nginx.conf /etc/nginx/nginx.conf

# Copy Laravel's public assets from the builder stage
# -----------------------------------------------------------
# We only need the 'public' directory from our Laravel app.
# -----------------------------------------------------------
# COPY --from=builder /var/www/public /var/www/public
COPY --from=builder --chown=nginx:nginx /var/www/html/public /var/www/public

# Set the working directory to the public folder
WORKDIR /var/www/public

# Expose port 80 and start Nginx
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
