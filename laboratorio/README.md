# Laboratório do site MDR

Prévia independente de home, blog e três artigos demonstrativos, sem CMS, banco, recebimento de formulário, analytics ou integração editorial. Textos dos artigos são exemplos para avaliação, identificados na interface. Logo, fontes e foto institucional foram obtidos de arquivos públicos do site MDR em 20/10/2026. Trabalhe Conosco aponta para o link externo encontrado no menu público (QuarkRH).

## Desenvolvimento

- Branch: `develop`, criada da `main` `ddc8a0b2919f5b765399647c050dff1720f28222`, por autorização de Rildon em 20/10/2026.
- Os arquivos atuais do site e a `main` são preservados. Nenhuma publicação na KingHost é feita por esta pasta.
- `site/` contém arquivos já gerados e prontos para servir; não precisa instalar dependências.
- `build.py` gera páginas e ilustrações SVG a partir dos exemplos definidos no arquivo. CSS/JS/assets são mantidos em `site/assets/`.
- Prévia local: `python3 -m http.server 8799 --bind 127.0.0.1 --directory laboratorio/site` a partir da raiz do repositório.

## Coolify

Aplicação própria no Coolify de homologação, repositório público em `develop`, base directory `/laboratorio`, build pack Dockerfile, arquivo `/Dockerfile`, porta 8080. Publicação manual neste primeiro ciclo; não habilitar deploys da main ou webhooks globais. O Dockerfile só copia arquivos estáticos para Nginx sem usuário root, sem build de Node/PHP/banco. Contexto pequeno via `.dockerignore`; os vídeos em Git LFS do projeto original não são usados.

Limites previstos: 128 MiB de RAM, 128 MiB de memória+swap, 0,25 CPU, limite de processos e logs. Prévia protegida por autenticação HTTP do Coolify e HTTPS em domínio temporário. Credencial exclusiva do laboratório deve ficar fora do repositório; não reutilizar FTP/Coolify/GitHub. `robots.txt`, meta e cabeçalho pedem não indexação, que não substitui autenticação.

Para revisar conteúdo, usar `/`, `/blog/` e os três artigos. Busca sem distinção de acento e filtros por categoria funcionam no navegador. Menu recolhido em telas pequenas. Conteúdo definitivo e painel editorial serão definidos posteriormente.

## Retorno

A interrupção desta aplicação no Coolify retira somente a prévia do ar. Nenhum DNS do domínio MDR, arquivo da KingHost ou recurso dos demais sistemas é alterado pelo laboratório. Fontes editáveis permanecem no Git; o estado de publicação, versão implantada, medições e endereço são registrados no contexto local da frente.
