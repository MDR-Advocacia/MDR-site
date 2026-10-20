FROM wordpress:cli-2.12.0-php8.3 AS cli
FROM wordpress:7.1.3-php8.3-apache
COPY --from=cli /usr/local/bin/wp /usr/local/bin/wp
COPY theme /usr/src/wordpress/wp-content/themes/mdr
COPY mu-plugins /usr/src/wordpress/wp-content/mu-plugins
COPY seed /opt/mdr-seed
COPY php.ini /usr/local/etc/php/conf.d/mdr.ini
COPY apache.conf /etc/apache2/conf-enabled/mdr.conf
COPY entrypoint.sh /usr/local/bin/mdr-entrypoint
COPY healthz.php /usr/src/wordpress/healthz.php
RUN chmod 755 /usr/local/bin/mdr-entrypoint
ENTRYPOINT ["mdr-entrypoint"]
CMD ["apache2-foreground"]
