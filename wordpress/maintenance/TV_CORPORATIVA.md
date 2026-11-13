# TV corporativa — piloto privado

O módulo TV corporativa separa conteúdos e arquivos da TV do site público.
O papel `mdr_tv_operator` permite somente leitura do painel e Iniciar exibição.
Editores gerem a programação; somente administradores gerem usuários/infraestrutura.

`/var/lib/mdr-tv` é volume privado, fora do document root. Configuração
`integration.json` é provisionada no servidor, nunca em Git. Mídias têm quota
de256MiB no piloto. Uploads são validados por MIME e arquivos não são executados.

O agente interno consulta o WordPress por HTTPS, com proteção da prévia e HMAC,
timestamp e nonce de uso único. Não existe porta de comando publicada na LAN/WAN.
A TV recebe somente o player/cache local por IP autorizado. Não recebe a chave
Entra nem a credencial de pareamento SSAP. Capturas são pontuais e protegidas.

Entra: OpenID Connect Generic Client3.11.3, código oficial distribuído com suas
dependências e licença, em `wordpress/plugins`. Assinatura JWT/JWKS, issuer,
audience validados pelo plugin; nonce, vínculo ao navegador e PKCE S256 são
validados pelo módulo MDR. Tenant/oid mapeiam usuários existentes.
Sem cadastro automático ou vinculação por e-mail. Sem sincronizar papéis por claims.
Escopos `openid profile email`; nenhum acesso Microsoft Graph solicitado pelo app.
Login local do administrador permanece como recuperação. SSO não garante revogar
imediatamente sessões WordPress existentes após bloqueio no Entra.

O agente reaproveita o filme contínuo como modo de recuperação enquanto a LG não
homologar o player dinâmico. Criar app não remove automaticamente o protetor.
Status da ponte, heartbeat do player e captura real são evidências diferentes.
As operações não dependem do Mac após instalação do agente como serviço interno.

Ensaio de13/11: o HTML com imagens/áudio acionou o descanso aos269s. A alternativa
`clips.html` reproduz um arquivo nativo por item/página, preparado sob demanda,
sem refazer um filme de toda a fila. Preparador separado: CPU25%, RAM320MiB,
um encoder por vez e derivados limitados a512MiB. Não habilitado no boot nem
definido como padrão antes dos testes físicos. A versão inicial desta alternativa
atende fotos/textos/carrosséis; vídeo/reel e continuidade da música exigem validação.
Ocultação, alteração e expiração são rechecadas na entrega de cada arquivo.

Não há coletor autenticado de Instagram/RD/LinkedIn neste bloco. Materiais do MVP
podem ser migrados como captura histórica, preservando créditos, sem inventar
atualização automática. Mídias futuras devem vir dos originais/autorização da MDR.

Rollback: restaurar imagem/deploy anterior, banco e volume privado do backup
correspondente. Na VM, restaurar unidade systemd anterior e iniciar mdr-tv-mvp.
Preservar dados editoriais feitos após a instalação; não restaurar indiscriminadamente.

Prioridade expressa de13/11: a campanha SGI/Política da Qualidade é a primeira
entrega do mural, conforme a cadeia MURAL DIGITAL e direção de Rildon. Biblioteca
social e formatos adicionais seguem depois. O encaminhamento trouxe somente a
faixa de selos da assinatura; Rildon já solicitou o reenvio do material da Érica.
Não confundir esse arquivo com a arte da campanha nem roteiro sugerido com texto
aprovado pela Qualidade.

Campanhas são uma taxonomia privada de Conteúdos da TV. O painel permite selecionar
somente uma campanha, preservando rascunhos, ocultação e expiração fora da fila.
Campanhas aceitam4–90segundos; posts comuns continuam com mínimo8. Texto de campanha
usa a tela horizontal, sem a coluna vazia de fotografia. Arte completa com texto
vazio é exibida inteira, sem novas marcas/textos sobrepostos; o original é preservado.
Alterações concorrentes da programação são recusadas com pedido de recarga.

Abrir prévia editorial, no conteúdo, mostra a última versão salva, com arquivos na
ordem e texto completo. É acesso autenticado de edição: nonce de sessão por arquivo,
capacidade específica e Range validado. A recepção não pode abrir essa biblioteca.
A prévia não publica nem inicia a TV. Aprovação editorial e liberação continuam com
Qualidade/Comunicação, usando rascunho e publicação do WordPress; a TI não declara
uma política, arte, data de auditoria ou certificado aprovado por suposição.

## Unidades independentes — 13/11/2026

Capim e Manhattan possuem opções, comandos, estados e capturas separados. Cada item escolhe Capim, Manhattan ou ambas; itens antigos sem campo continuam somente em Capim. A recepção permanece autorizada somente para iniciar Capim, inclusive com formulário adulterado. Administradores/editores selecionam a unidade no painel. A escolha de campanha, trilha e volume é independente.

Cada agente usa seu processo, porta, cache, credencial SSAP, IP permitido e chave HMAC. O identificador de unidade integra a assinatura; uma chave de outra unidade não autoriza leitura de mídia, confirmação ou consumo de comandos. A ponte original de Capim é mantida durante a transição. Apenas mídias da fila publicada da própria unidade são entregues ao dispositivo, excluindo rascunhos e ocultos.

Manhattan: TV 192.168.70.73, player interno 192.168.0.33:8098, usando as rotas existentes. Capim conserva 8097. Nenhum novo túnel, porta pública ou comando HTTP de entrada foi criado. Pareamento não comprova WOL nem reprodução prolongada: registrar os testes físicos separadamente. A campanha SGI permanece minuta até validação de conteúdo e materiais.

### Política da Qualidade — fonte de Érica

O material fornecido por Rildon no pendrive tem160segundos/1920×1080, oito blocos de20segundos. As sete declarações e a tela das auditorias foram transcritas sem paráfrase e conferidas contra160quadros/116trechos. As artes do vídeo não são mídias da programação: somente texto no padrão MDR. Guardar fonte e comparação em diretório privado da frente, sem Git. Sete itens330–336 e auditorias341 permanecem rascunhos da campanha8. Os seis complementos do briefing inicial ficam em campanha separada para validação, sem misturar propostas com a fonte recebida.

O material informa auditoria interna12/novembro e externa18/novembro, sem ano impresso; manter as datas e a redação futura do original até revisão. Não gerar contagem regressiva ou alegar certificação por inferência. A prévia mostra esse ponto para revisão. Rodapés completos e blocos de texto são mantidos no render; blocos curtos de data/explicação não devem ser partidos entre telas.
