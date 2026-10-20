#!/bin/bash
set -eu
# Reconcile the trusted image with the persistent core. Uploads and wp-config
# remain in the volume; editorial content lives in the dedicated database.
if [ "$1" = apache2-foreground ]; then
  cp -a /usr/src/wordpress/. /var/www/html/
  chown -R www-data:www-data /var/www/html/wp-content
fi
exec docker-entrypoint.sh "$@"
