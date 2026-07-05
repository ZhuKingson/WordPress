FROM php:8.3-apache

# 安装 WordPress 所需 PHP 扩展
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    libzip-dev libicu-dev libonig-dev unzip curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd mysqli pdo_mysql zip intl mbstring opcache exif \
    && a2enmod rewrite headers expires \
    && rm -rf /var/lib/apt/lists/*

# 设置 PHP 性能参数
RUN { \
    echo 'upload_max_filesize = 64M'; \
    echo 'post_max_size = 64M'; \
    echo 'memory_limit = 256M'; \
    echo 'max_execution_time = 300'; \
} > /usr/local/etc/php/conf.d/wordpress.ini

# 设置 OPcache
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.enable=1'; \
} > /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html

# 复制 WordPress 源码
COPY . /var/www/html/

# 下载并安装 WooCommerce（固定版本）
ARG WOOCOMMERCE_VERSION=9.8.5
RUN curl -L "https://downloads.wordpress.org/plugin/woocommerce.${WOOCOMMERCE_VERSION}.zip" \
    -o /tmp/woocommerce.zip \
    && unzip /tmp/woocommerce.zip -d /var/www/html/wp-content/plugins/ \
    && rm /tmp/woocommerce.zip

# 设置文件权限
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Apache 虚拟主机配置
RUN printf '<Directory /var/www/html>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
    > /etc/apache2/conf-available/wordpress.conf \
    && a2enconf wordpress

EXPOSE 80
