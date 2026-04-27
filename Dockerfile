# 1. Imagem de Origem (Usando a versão 8.2 com Apache)
FROM php:8.2-apache

# 2. Instala dependências do sistema (Sendmail para o envia.php)
RUN apt-get update && apt-get install -y sendmail

# 3. CONFIGURAÇÕES DO APACHE (Essenciais para tirar o .php)

# Habilita o módulo de reescrita de URL
RUN a2enmod rewrite

# CORREÇÃO DO ERRO 500:
# Altera a configuração do Apache para permitir que o arquivo .htaccess funcione.
# Sem isso, o servidor bloqueia o .htaccess e dá erro interno.
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# 4. Copia os arquivos do site
COPY . /var/www/html/

# 5. Ajusta permissões (Para o Apache poder ler os arquivos)
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html