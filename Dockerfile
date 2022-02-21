
FROM webdevops/php-apache:8.0
LABEL maintainer="lars@lehmann.wtf"

USER root

RUN apt-get update -y
RUN apt-get upgrade -y

ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
ADD . / /var/www/html/
RUN chown -R www-data:www-data /var/www

# Expose ports
EXPOSE 80
RUN ln -s /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/
RUN rm /var/www/html/index.html
RUN service apache2 restart