FROM php:8.2-apache

# 啟用 Apache Rewrite 模組（CodeIgniter 路由必要）
RUN a2enmod rewrite

# 安裝 PHP 常用套件與擴充功能
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mysqli gd

# 設定 Apache Document Root 指向 public 目錄 (適用 CI4)
# 若你是 CI3，請將這兩行裡面的 /public 刪除
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# 將專案檔案複製到容器中
COPY . /var/www/html/

# 設定適當的目錄權限
RUN chown -R www-data:www-data /var/www/html