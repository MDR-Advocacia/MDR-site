# Atualização de mídia da revisão visual de 20/10/2026

`normalize-award-media.php` é uma operação manual exclusiva do laboratório, não um hook nem um seed automático. Executar por PHP CLI dentro do container WordPress **depois de um backup** e do deploy desta versão. O script usa os slugs existentes, preserva os anexos originais, confere se a imagem destacada continua sendo a origem esperada e evita importar novamente o mesmo hash. Não altera biografias, textos ou usuários.

Os nove arquivos `theme/assets/premio-*-estudio.webp` são versões de apresentação, geradas com a ferramenta integrada `image_gen` e otimizadas em WebP de até 800 × 800. O manifesto `trophy-assets.json` guarda prompt, origem e hashes. Os originais permanecem no tema e na biblioteca do WordPress. O selo digital GPTW não foi redesenhado.

Direção posterior de Rildon neste chat: os três troféus do Banco do Brasil devem compartilhar modelo, perspectiva e vazados claros, mesmo com reconstrução da imagem, preservando o texto específico fotografado. Os demais tratamentos de fundo/luz/sombra foram aprovados para continuidade. São imagens de apresentação da prévia, não documentos comprobatórios ou novos certificados.

Para reverter as imagens destacadas, usar os IDs guardados em `mdr_visual_previous_thumbnail_v1` em cada reconhecimento, preservando edições mais recentes. O script não deve ser usado para sobrescrever uma imagem trocada pela Comunicação.
