FROM php:8.2-apache

# 啟用 Apache Rewrite 模組
RUN a2enmod rewrite

# 設定 Apache 目錄權限與 DocumentRoot 為 /var/www/html/www
RUN echo '<Directory /var/www/html/www/>\n\
    Options Indexes FollowSymLinks MultiViews\n\
    AllowOverride All\n\
    Require all granted\n\
    DirectoryIndex index.php\n\
</Directory>' > /etc/apache2/conf-available/ci3-override.conf \
    && a2enconf ci3-override

# 安裝資料庫擴充功能
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 複製專案所有檔案
COPY . /var/www/html/

# 將 Apache 預設 Document Root 改為 /var/www/html/www
ENV APACHE_DOCUMENT_ROOT /var/www/html/www
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/conf-available/*.conf