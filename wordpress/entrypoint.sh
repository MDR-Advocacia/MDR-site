#!/bin/bash
set -eu
# Reconcile the trusted image with the persistent core. Uploads and wp-config
# remain in the volume; editorial content lives in the dedicated database.
if [ "$1" = apache2-foreground ]; then
  : "${MDR_PREVIEW_USERNAME:?Missing preview username}"
  : "${MDR_PREVIEW_PASSWORD_HASH:?Missing preview password hash}"
  printf '%s:%s\n' "$MDR_PREVIEW_USERNAME" "$MDR_PREVIEW_PASSWORD_HASH" > /run/mdr-preview.htpasswd
  chown root:www-data /run/mdr-preview.htpasswd
  chmod 640 /run/mdr-preview.htpasswd
  cp -a /usr/src/wordpress/. /var/www/html/
  chown -R www-data:www-data /var/www/html/wp-content
fi
exec docker-entrypoint.sh "$@"
