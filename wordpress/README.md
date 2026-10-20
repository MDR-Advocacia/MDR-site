# WordPress — laboratório MDR

Ambiente privado autorizado por Rildon em 20/10/2026. Código na `develop`; site público, KingHost e `main` preservados. RD Station não integra esta entrega.

## Componentes

- WordPress 7.1.3/PHP 8.3 Apache e WP-CLI 2.12.0, imagens oficiais.
- MariaDB 10.11.19, banco e credenciais exclusivos, sem porta de banco publicada.
- Compose no Coolify, base `/wordpress`, arquivo `/compose.yaml`. Publicação técnica manual, sem webhook por push.
- 512 MiB/0,75 CPU para WordPress e 384 MiB/0,5 CPU para MariaDB, sem swap adicional; logs com rotação e limites de processos.
- Volumes persistentes para WordPress e banco. Tema/controles são reconciliados com a imagem em cada deploy. Edições de código pelo painel e instalações/atualizações pelo painel ficam desabilitadas; atualizações técnicas passam pela imagem e homologação.

## Operação editorial

- **Páginas → Início:** apresentação completa e Missão/Visão/Valores em blocos nativos.
- **Sócios:** título, biografia, resumo, imagem destacada, função e links profissionais. O resumo aparece na home; o texto completo, no perfil.
- **Reconhecimentos:** título, imagem destacada, descrição, ano confirmado e entidade/validade. Mesma apresentação para selos e fotos de troféus, sem alterar as imagens.
- **Posts:** blog com rascunho/publicação, categorias, autoria, data, resumo e imagem destacada. Três exemplos explicitamente demonstrativos.
- **Configurações → Dados institucionais:** contato/rodapé, DPO e redes. Alterações críticas restritas à administração.
- **Ferramentas → Registro do laboratório:** últimos 200 eventos técnicos de acesso/edição; não substitui política definitiva de auditoria/retencão. Textos usam revisões nativas.

O papel Editor pode editar/publicar conteúdo, mas não instalar extensões, administrar usuários ou alterar configurações. O fluxo definitivo de aprovação será alinhado com Comunicação/DPO/SGI; não há aprovação jurídica presumida.

## Inicialização

`seed/bootstrap.php` é invocado explicitamente por PHP no container, recebendo credenciais somente por stdin. Nunca acessar esse script por HTTP. Ele instala a base e importa conteúdo uma vez; após `mdr_seed_version=1.0.0`, não sobrescreve edições editoriais.

Credenciais de entrada na prévia e credenciais WordPress são distintas e ficam fora do repositório. Segredos do banco são variáveis somente de execução no Coolify. Não guardar `.env`, dump, cookie ou senha em Git.

## Limites desta versão

- Vídeo local verificado por SHA-256 contra o ativo original: `00f7df15c982f1ff73cba4fa9bb0fd71fa7669760c0fe29f797215901ec6dc12`. ~23 s, 1.882.701 bytes; sem textos sobrepostos, sem corte móvel, pausa e preferência por movimento reduzido. Esse pequeno arquivo regular dispensa LFS no novo build; o vídeo legado e suas regras não foram alterados.
- E-mails externos, comentários, XML-RPC e application passwords desativados no laboratório. Sem analytics, pixels, fontes externas, mapas/feeds incorporados ou formulários públicos de coleta.
- HTTPS e proteção HTTP Basic no proxy são obrigatórios; noindex é complementar e não substitui controle de acesso.
- Compromissos ESG, Pacto Global, políticas e serviços remetem às páginas institucionais do site atual. Não houve migração integral dessas páginas ou validação de documentos pela DPO. Marca Pacto Global não foi reproduzida antes do e-mail/revisão solicitado.
- Recuperação/equipe de cobrança e integrações de negociação permanecem na frente de revisão; não houve importação de diretório desatualizado.
- Biografias, dados do rodapé e premiações vieram do site original e precisam de confirmação editorial antes da produção. Não há certificação ISO nova publicada.
- Backup, teste de retorno e verificações efetivamente executados constam do registro externo de publicação; não presumir backup externo por existir um volume.

## Verificação antes da publicação

Conferir sintaxe PHP/JS, Compose, versões, ausência de segredos no diff, autenticação de páginas e ativos, saúde dos containers, edição/revisão por Editor, manutenção após reinício e backup/restauração. A prévia estática anterior permanece separada para comparação.
