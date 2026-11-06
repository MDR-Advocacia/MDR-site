# Atualização de mídia da revisão visual de 20/10/2026

`normalize-award-media.php` é uma operação manual exclusiva do laboratório, não um hook nem um seed automático. Executar por PHP CLI dentro do container WordPress **depois de um backup** e do deploy desta versão. O script usa os slugs existentes, preserva os anexos originais, confere se a imagem destacada continua sendo a origem esperada e evita importar novamente o mesmo hash. Não altera biografias, textos ou usuários.

Os nove arquivos `theme/assets/premio-*-estudio.webp` são versões de apresentação, geradas com a ferramenta integrada `image_gen` e otimizadas em WebP de até 800 × 800. O manifesto `trophy-assets.json` guarda prompt, origem e hashes. Os originais permanecem no tema e na biblioteca do WordPress. O selo digital GPTW não foi redesenhado.

Direção posterior de Rildon neste chat: os três troféus do Banco do Brasil devem compartilhar modelo, perspectiva e vazados claros, mesmo com reconstrução da imagem, preservando o texto específico fotografado. Os demais tratamentos de fundo/luz/sombra foram aprovados para continuidade. São imagens de apresentação da prévia, não documentos comprobatórios ou novos certificados.

Para reverter as imagens destacadas, usar os IDs guardados em `mdr_visual_previous_thumbnail_v1` em cada reconhecimento, preservando edições mais recentes. O script não deve ser usado para sobrescrever uma imagem trocada pela Comunicação.

## Migração institucional — 06/11/2026

`institutional-content.json` foi gerado a partir das páginas públicas de referência,
com arquivos locais em `institutional-assets/` verificados por SHA-256. O gerador
`build-institutional-content.py` recebe snapshots locais e requer BeautifulSoup4;
não executa PHP legado nem transporta scripts, embeds ou formulários.

Após backup e deploy, executar explicitamente no laboratório:

    wp eval-file /opt/mdr-maintenance/import-institutional.php --path=/var/www/html

A importação é restrita a WP-CLI/staging, idempotente, preserva páginas já
existentes e não reinicializa home, sócios, prêmios ou posts. Importa 15 páginas
publicadas para homologação e dois rascunhos históricos (equipe da cobrança e
depoimentos), que dependem de revisão. A página Certificados é um cadastro
editorial; sua exibição pública é incorporada ao acervo Reconhecimentos, mantendo
uma única página. /premios redireciona para esse acervo. Os cinco PDFs preservam
os bytes originais. Isso não substitui revisão de vigência pela DPO/SGI.

Editor: Páginas para textos e áreas; atributo Ordem para ordenação; campo Área
para exibição na home; Sócios/Reconhecimentos para os respectivos cadastros.
Administração: Aparência → Menus e Configurações → Dados institucionais.
O vídeo e o desenho do tema seguem versionados. Conteúdo da premiação recente e
primeiro artigo real permanecem com Comunicação/Marketing. Sem RD/analytics.
