Set-Content -Path Dockerfile -Value 'FROM php:8.2-apache

# 啟用 Apache Rewrite 模組
RUN a2enmod rewrite

# 允許 .htaccess 覆蓋設定 (AllowOverride All)
RUN sed -i '\''<Directory /var/www/html/>'\'',$s/AllowOverride None/AllowOverride All/ /etc/apache2/apache2.conf

# 安裝資料庫擴充功能
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 複製專案檔案
COPY . /var/www/html/

# 設定 Document Root 為根目錄
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/conf-available/*.conf'