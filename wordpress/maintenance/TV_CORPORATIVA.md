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
