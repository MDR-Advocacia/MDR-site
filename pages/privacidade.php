<?php
$pageTitle = 'Compliance e Privacidade - MDR Advocacia';
$pageDescription = 'Compliance, Privacidade, Proteção de Dados e Integridade da MDR Advocacia.';
$pageKeywords = 'MDR Advocacia, Política de Privacidade, LGPD, Proteção de Dados, Integridade, Compliance';
$bodyClass = 'index-page privacy-page';
include '../includes/header.php';
?>

<style>
  .digital-signature {
    display: inline-block;
    border: 1px solid #000;
    padding: 10px;
    margin-top: 15px;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
    font-size: 11px;
    color: #000;
    background-color: #fff;
    max-width: 450px;
    line-height: 1.3;
  }

  .sig-header {
    font-weight: bold;
    border-bottom: 1px solid #000;
    margin-bottom: 5px;
    padding-bottom: 2px;
    text-transform: uppercase;
  }

  .sig-body strong {
    font-size: 13px;
    display: block;
  }

  .compliance-channel-card {
    border: 1px solid rgba(27, 47, 69, 0.14);
    border-left: 5px solid var(--accent-color, #c5b358);
    border-radius: 10px;
    background: #f8fbfc;
    padding: 1.5rem;
    margin: 1.5rem 0 2rem;
    box-shadow: 0 12px 30px rgba(27, 47, 69, 0.06);
  }

  .compliance-channel-card h4 {
    color: var(--heading-color);
    margin-bottom: 0.75rem;
  }

  .channel-kicker {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    color: var(--heading-color);
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
  }

  .channel-kicker i {
    color: var(--accent-color, #c5b358);
  }

  .privacy-overview-card,
  .dpo-card,
  .compliance-section-card {
    background: #fff;
    border: 1px solid rgba(27, 47, 69, 0.1);
    border-radius: 12px;
    box-shadow: 0 12px 30px rgba(27, 47, 69, 0.06);
  }

  .privacy-overview-card,
  .compliance-section-card {
    padding: 1.75rem;
  }

  .dpo-card {
    padding: 1.5rem;
    height: 100%;
  }

  .section-eyebrow {
    color: var(--accent-color, #c5b358);
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    margin-bottom: 0.65rem;
    text-transform: uppercase;
  }

  .privacy-overview-card h2,
  .dpo-card h2,
  .compliance-section-card h2 {
    color: var(--heading-color);
    margin-bottom: 1rem;
  }

  .dpo-person {
    border-top: 1px solid rgba(27, 47, 69, 0.1);
    padding-top: 1rem;
    margin-top: 1rem;
  }

  .dpo-person:first-of-type {
    border-top: 0;
    padding-top: 0;
  }

  .dpo-person h4 {
    color: var(--heading-color);
    margin-bottom: 0.35rem;
  }

  .document-section-title {
    color: var(--heading-color);
    margin-bottom: 0.75rem;
  }

  .compliance-pillars {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
    margin: 1.5rem 0;
  }

  .compliance-pillar {
    background: #f8fbfc;
    border: 1px solid rgba(27, 47, 69, 0.1);
    border-radius: 10px;
    padding: 1.15rem;
  }

  .compliance-pillar h4 {
    color: var(--heading-color);
    font-size: 1.05rem;
    margin-bottom: 0.55rem;
  }

  .compliance-pillar p {
    margin-bottom: 0;
  }

  .compliance-alpha-list {
    counter-reset: alpha-item;
    list-style: none;
    padding-left: 0;
  }

  .compliance-alpha-list li {
    counter-increment: alpha-item;
    position: relative;
    padding-left: 2rem;
    margin-bottom: 0.45rem;
  }

  .compliance-alpha-list li::before {
    content: counter(alpha-item, lower-alpha) ")";
    position: absolute;
    left: 0;
    top: 0;
    font-weight: 700;
    color: var(--heading-color);
  }

  .compliance-docs-wrap {
    background: #f6fcfe;
    border: 1px solid rgba(27, 47, 69, 0.1);
    border-radius: 8px;
    padding: 1rem;
  }

  .compliance-doc-table {
    --bs-table-bg: transparent;
    --bs-table-color: var(--default-color);
    margin-bottom: 0;
  }

  .compliance-doc-table thead th {
    color: var(--heading-color);
    border-bottom: 1px solid rgba(27, 47, 69, 0.16);
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 0.9rem 1rem;
  }

  .compliance-doc-table tbody td {
    background: #fff !important;
    border-bottom: 1px solid rgba(27, 47, 69, 0.1);
    color: var(--default-color) !important;
    padding: 1rem;
    vertical-align: middle;
  }

  .doc-name {
    font-weight: 700;
    color: var(--heading-color);
    margin-bottom: 0.2rem;
  }

  .doc-note {
    color: #5d6b76;
    font-size: 0.92rem;
    margin-bottom: 0;
  }

  .doc-actions {
    display: grid;
    grid-template-columns: 42px 42px;
    justify-content: end;
    align-items: center;
    gap: 0.6rem;
  }

  .doc-action {
    width: 42px;
    height: 42px;
    box-sizing: border-box;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    margin: 0;
    border-radius: 50%;
    border: 1px solid rgba(27, 47, 69, 0.16);
    color: var(--heading-color);
    text-decoration: none;
    background: #f6fcfe;
    transition: all 0.2s ease;
    vertical-align: middle;
  }

  button.doc-action {
    appearance: none;
    -webkit-appearance: none;
    font: inherit;
    line-height: 1;
    cursor: pointer;
  }

  .doc-action i {
    display: block;
    width: 1em;
    height: 1em;
    line-height: 1;
  }

  .doc-action .bi::before {
    display: block;
    line-height: 1;
  }

  .doc-action:hover {
    color: #111;
    background: var(--accent-color, #c5b358);
    border-color: var(--accent-color, #c5b358);
  }

  .doc-modal-content {
    max-height: 60vh;
    overflow-y: auto;
    white-space: pre-wrap;
    line-height: 1.7;
    color: var(--default-color);
    background: #f8fbfc;
    border: 1px solid rgba(27, 47, 69, 0.1);
    border-radius: 8px;
    padding: 1.25rem;
  }

  .doc-modal-download {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
  }

  @media (max-width: 575.98px) {
    .compliance-pillars {
      grid-template-columns: 1fr;
    }

    .doc-actions {
      justify-content: flex-start;
      margin-top: 0.5rem;
    }
  }
</style>

<div class="page-title light-background" data-aos="fade" style="padding-top: 120px; padding-bottom: 40px;">
  <div class="container">
    <h1>Compliance e Privacidade</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Compliance e Privacidade</li>
      </ol>
    </nav>
  </div>
</div>

<section id="privacy-content" class="section">
  <div class="container" data-aos="fade-up">
    <div class="row">
      <div class="col-lg-12 content">
        <div class="row g-4 align-items-stretch mb-5">
          <div class="col-lg-7">
            <div class="privacy-overview-card h-100">
              <div class="section-eyebrow">Privacidade e Proteção de Dados</div>
              <h2>Política de Privacidade</h2>
              <p>A <strong>MDR Advocacia</strong> atua em conformidade com a Lei Geral de Proteção de Dados Pessoais (LGPD), adotando medidas de segurança, transparência e governança para proteger os dados pessoais tratados em suas atividades.</p>
              <p>As informações sobre tratamento de dados pessoais, direitos dos titulares e demais solicitações relacionadas à privacidade podem ser encaminhadas pelo e-mail <a href="mailto:dpo@mdradvocacia.com"><strong>dpo@mdradvocacia.com</strong></a>.</p>

              <h3 class="document-section-title mt-4">Documentos de Privacidade</h3>
              <div class="compliance-docs-wrap">
                <div class="table-responsive">
                  <table class="table compliance-doc-table align-middle">
                    <thead>
                      <tr>
                        <th scope="col">Documentos</th>
                        <th scope="col" class="text-end">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="doc-name">Política de Privacidade Atualizada</div>
                          <p class="doc-note">Documento institucional disponível para leitura e download.</p>
                        </td>
                        <td>
                          <div class="doc-actions">
                            <button class="doc-action" type="button" data-bs-toggle="modal" data-bs-target="#complianceDocModal" data-doc-title="Política de Privacidade Atualizada" data-doc-text="/assets/docs/compliance/politica-de-privacidade-mdr-atualizada.txt" data-doc-download="/assets/docs/compliance/politica-de-privacidade-mdr-atualizada.docx" aria-label="Visualizar Política de Privacidade Atualizada">
                              <i class="bi bi-eye"></i>
                            </button>
                            <a class="doc-action" href="/assets/docs/compliance/politica-de-privacidade-mdr-atualizada.docx" download aria-label="Baixar Política de Privacidade Atualizada">
                              <i class="bi bi-download"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="doc-name">Aviso de Privacidade - MDR Advocacia</div>
                          <p class="doc-note">Documento complementar disponível para leitura e download.</p>
                        </td>
                        <td>
                          <div class="doc-actions">
                            <button class="doc-action" type="button" data-bs-toggle="modal" data-bs-target="#complianceDocModal" data-doc-title="Aviso de Privacidade - MDR Advocacia" data-doc-text="/assets/docs/compliance/aviso-de-privacidade-mdr.txt" data-doc-download="/assets/docs/compliance/aviso-de-privacidade-mdr.docx" aria-label="Visualizar Aviso de Privacidade - MDR Advocacia">
                              <i class="bi bi-eye"></i>
                            </button>
                            <a class="doc-action" href="/assets/docs/compliance/aviso-de-privacidade-mdr.docx" download aria-label="Baixar Aviso de Privacidade - MDR Advocacia">
                              <i class="bi bi-download"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="dpo-card">
              <div class="section-eyebrow">Conheça nosso DPO</div>
              <h2>Encarregado de Dados Pessoais</h2>
              <p>O contato para assuntos relacionados à proteção de dados pessoais é realizado pelo e-mail <a href="mailto:dpo@mdradvocacia.com"><strong>dpo@mdradvocacia.com</strong></a>.</p>

              <div class="dpo-person">
                <h4>Ingrid Quirino Ribeiro</h4>
                <p class="mb-1"><strong>Função:</strong> Encarregada de Proteção de Dados (DPO)</p>
                <p class="mb-0"><strong>OAB/RN:</strong> 21.410</p>
              </div>

              <div class="dpo-person">
                <h4>Ricardo Luiz Paiva Medeiros</h4>
                <p class="mb-0"><strong>Função:</strong> Substituto do Encarregado de Dados Pessoais</p>
              </div>
            </div>
          </div>
        </div>

        <div class="compliance-section-card">
          <div class="section-eyebrow">Integridade e Compliance</div>
          <h2>Integridade e Compliance</h2>
          <p>No MDR Advocacia, a ética é o alicerce de cada decisão e a transparência é o compromisso que rege nossa atuação jurídica. Nosso programa de integridade reúne diretrizes para orientar colaboradores, parceiros e fornecedores em uma atuação responsável, segura e alinhada às melhores práticas de governança.</p>
          <p>As políticas institucionais reforçam o compromisso do escritório com a legalidade, o sigilo profissional, a prevenção de conflitos de interesses, o combate à corrupção e a proteção de dados pessoais. Esses princípios sustentam nossas relações internas e externas, sempre com foco em confiança, responsabilidade e conformidade.</p>

          <div class="compliance-pillars">
            <div class="compliance-pillar">
              <h4>Código de Ética e Conduta</h4>
              <p>Define os padrões de comportamento esperados de sócios, advogados e colaboradores, com foco em integridade profissional, respeito, sigilo e excelência no atendimento.</p>
            </div>
            <div class="compliance-pillar">
              <h4>Política Anticorrupção</h4>
              <p>Reforça a tolerância zero a corrupção, suborno, tráfico de influência ou qualquer conduta ilícita no relacionamento com agentes públicos ou privados.</p>
            </div>
            <div class="compliance-pillar">
              <h4>Conduta para Fornecedores</h4>
              <p>Estabelece diretrizes para que parceiros e fornecedores atuem com responsabilidade ética, respeito aos direitos humanos, sustentabilidade e conformidade legal.</p>
            </div>
            <div class="compliance-pillar">
              <h4>Gestão de Conflitos</h4>
              <p>Orienta a identificação, avaliação e mitigação de situações que possam comprometer a independência técnica, a imparcialidade ou a lealdade aos clientes.</p>
            </div>
          </div>

          <div class="compliance-channel-card">
            <div class="channel-kicker"><i class="bi bi-shield-check"></i> Canal de Denúncias Interno</div>
            <h4>Canal ativo para relatos internos</h4>
            <p>O MDR Advocacia possui canal de denúncias interno ativo, devidamente divulgado entre os colaboradores, destinado ao recebimento de relatos relacionados a condutas antiéticas, violações de compliance ou eventuais incidentes de proteção de dados.</p>
            <p class="mb-0">O canal de denúncias é um instrumento comprometido com os princípios de confidencialidade, imparcialidade, independência, boa-fé, não retaliação e rastreabilidade.</p>
          </div>

          <h3 class="document-section-title">Documentos de Compliance</h3>
          <p class="text-muted">Clique no olho para visualizar o documento e no ícone de download para baixá-lo.</p>
          <div class="compliance-docs-wrap">
            <div class="table-responsive">
              <table class="table compliance-doc-table align-middle">
                <thead>
                  <tr>
                    <th scope="col">Documentos</th>
                    <th scope="col" class="text-end">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="doc-name">Código de Ética e Conduta - MDR Advocacia</div>
                      <p class="doc-note">Versão institucional disponível para leitura e download.</p>
                    </td>
                    <td>
                      <div class="doc-actions">
                        <button class="doc-action" type="button" data-bs-toggle="modal" data-bs-target="#complianceDocModal" data-doc-title="Código de Ética e Conduta - MDR Advocacia" data-doc-text="/assets/docs/compliance/codigo-de-etica-e-conduta-mdr-advocacia.txt" data-doc-download="/assets/docs/compliance/codigo-de-etica-e-conduta-mdr-advocacia.pdf" aria-label="Visualizar Código de Ética e Conduta - MDR Advocacia">
                          <i class="bi bi-eye"></i>
                        </button>
                        <a class="doc-action" href="/assets/docs/compliance/codigo-de-etica-e-conduta-mdr-advocacia.pdf" download aria-label="Baixar Código de Ética e Conduta - MDR Advocacia">
                          <i class="bi bi-download"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="doc-name">Código de Conduta para Fornecedores</div>
                      <p class="doc-note">Documento para consulta e download em PDF.</p>
                    </td>
                    <td>
                      <div class="doc-actions">
                        <button class="doc-action" type="button" data-bs-toggle="modal" data-bs-target="#complianceDocModal" data-doc-title="Código de Conduta para Fornecedores" data-doc-text="/assets/docs/compliance/codigo-de-conduta-para-fornecedores.txt" data-doc-download="/assets/docs/compliance/codigo-de-conduta-para-fornecedores.pdf" aria-label="Visualizar Código de Conduta para Fornecedores">
                          <i class="bi bi-eye"></i>
                        </button>
                        <a class="doc-action" href="/assets/docs/compliance/codigo-de-conduta-para-fornecedores.pdf" download aria-label="Baixar Código de Conduta para Fornecedores">
                          <i class="bi bi-download"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="doc-name">Política Anticorrupção e de Conduta Ética</div>
                      <p class="doc-note">Documento institucional disponível para leitura e download.</p>
                    </td>
                    <td>
                      <div class="doc-actions">
                        <button class="doc-action" type="button" data-bs-toggle="modal" data-bs-target="#complianceDocModal" data-doc-title="Política Anticorrupção e de Conduta Ética" data-doc-text="/assets/docs/compliance/politica-anticorrupcao-e-de-conduta-etica.txt" data-doc-download="/assets/docs/compliance/politica-anticorrupcao-e-de-conduta-etica.pdf" aria-label="Visualizar Política Anticorrupção e de Conduta Ética">
                          <i class="bi bi-eye"></i>
                        </button>
                        <a class="doc-action" href="/assets/docs/compliance/politica-anticorrupcao-e-de-conduta-etica.pdf" download aria-label="Baixar Política Anticorrupção e de Conduta Ética">
                          <i class="bi bi-download"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="complianceDocModal" tabindex="-1" aria-labelledby="complianceDocModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="complianceDocModalTitle">Documento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <div class="doc-modal-content" id="complianceDocModalText">Carregando documento...</div>
      </div>
      <div class="modal-footer justify-content-between">
        <span class="text-muted small">Documento disponível para consulta.</span>
        <a class="btn btn-primary doc-modal-download" id="complianceDocModalDownload" href="#" download>
          <i class="bi bi-download"></i>
          Baixar documento
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('complianceDocModal');
    const title = document.getElementById('complianceDocModalTitle');
    const text = document.getElementById('complianceDocModalText');
    const download = document.getElementById('complianceDocModalDownload');

    modal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;

      title.textContent = button.getAttribute('data-doc-title');
      text.textContent = 'Carregando documento...';
      download.href = button.getAttribute('data-doc-download');

      fetch(button.getAttribute('data-doc-text'))
        .then(function (response) {
          if (!response.ok) {
            throw new Error('Não foi possível carregar o documento.');
          }

          return response.text();
        })
        .then(function (content) {
          text.textContent = content;
        })
        .catch(function () {
          text.textContent = 'Não foi possível carregar o texto do documento. Use o botão abaixo para baixar o arquivo.';
        });
    });
  });
</script>

<?php include '../includes/footer.php'; ?>
