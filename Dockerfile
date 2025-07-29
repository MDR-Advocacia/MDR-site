# 1. Imagem de Origem
# Começamos com a imagem oficial do PHP que já vem com o servidor Apache.
# Usar a tag 'alpine' cria uma imagem final muito menor e mais segura.
FROM php:apache

# 2. (Opcional, mas recomendado) Instala dependências do sistema
# O sendmail é necessário para que a função mail() do PHP funcione dentro do contêiner.
# Essencial para o seu arquivo `envia.php`.
RUN apt-get update && apt-get install -y sendmail

# 3. Copia os arquivos do seu site
# Copia todos os arquivos da sua pasta atual (onde está o Dockerfile)
# para a pasta padrão do servidor Apache dentro do contêiner.
COPY . /var/www/html/

# 4. (Opcional) Ajusta permissões
# Garante que o servidor Apache tenha permissão para ler/escrever nos arquivos, se necessário.
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# A imagem base já sabe que precisa iniciar o Apache, então não precisamos de um comando final.