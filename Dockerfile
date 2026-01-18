FROM php:8.2-apache

# Instalamos la conexión a la base de datos
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN echo "output_buffering=4096" > /usr/local/etc/php/conf.d/custom.ini
# Copiamos TODO (incluido el index.html que ya creaste dentro)
COPY 1_Proyecto_diciembre_IA_Final/1_Proyecto_diciembre_IA_Final/ /var/www/html

# Damos permisos al usuario de Apache
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
