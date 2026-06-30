<?php
$pageTitle = 'Integridade e Compliance - MDR Advocacia';
$pageDescription = 'Seção de Integridade e Compliance da MDR Advocacia, com documentos institucionais e princípios de conduta.';
$pageKeywords = 'Integridade, Compliance, Código de Ética, Conduta, Anticorrupção, MDR Advocacia';
$bodyClass = 'index-page page-compliance';
include '../includes/header.php';
?>

<style>
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
    .doc-actions {
      justify-content: flex-start;
      margin-top: 0.5rem;
    }
  }
</style>

<div class="page-title light-background" data-aos="fade" style="padding-top: 120px; padding-bottom: 40px;">
  <div class="container">
    <h1>Integridade e Compliance</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Integridade e Compliance</li>
      </ol>
    </nav>
  </div>
</div>

<section id="compliance-content" class="section">
  <div class="container" data-aos="fade-up">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 content text-justify">
        <div class="text-center mb-5">
          <h2 style="color: var(--nav-color);">INTEGRIDADE E COMPLIANCE</h2>
          <h4 class="text-muted">MDR ADVOCACIA</h4>
          <hr style="width: 100px; margin: 20px auto; border-top: 3px solid var(--accent-color);">
        </div>

        <p>No MDR Advocacia, a ética é o alicerce de cada decisão e a transparência é o compromisso que rege nossa atuação jurídica. Acreditamos que a advocacia de excelência caminha lado a lado com a integridade. Abaixo, disponibilizamos nossos documentos institucionais de governança, que refletem nossos valores e padrões de conduta.</p>

        <h3 class="mt-5">1. Código de Ética e Conduta - MDR Advocacia</h3>
        <p><strong>Objetivo:</strong> Estabelecer o padrão de comportamento esperado de todos os sócios, advogados e colaboradores.</p>
        <p><strong>Princípios Norteadores:</strong></p>
        <ol class="compliance-alpha-list">
          <li><strong>Legalidade e Sigilo:</strong> respeito irrestrito à legislação vigente e proteção absoluta ao sigilo profissional.</li>
          <li><strong>Integridade Profissional:</strong> atuação pautada pela honestidade, boa-fé e ausência de conflitos de interesses.</li>
          <li><strong>Respeito ao Próximo:</strong> promoção de um ambiente de trabalho pautado pela diversidade, equidade e respeito mútuo.</li>
          <li><strong>Excelência no Atendimento:</strong> busca contínua pela qualidade técnica e foco na resolução eficiente dos conflitos dos nossos clientes.</li>
        </ol>

        <h3 class="mt-4">2. Política Anticorrupção e de Conduta Ética</h3>
        <p><strong>Objetivo:</strong> Declarar nosso compromisso com o combate à corrupção, em conformidade com a Lei nº 12.846/2013.</p>
        <p><strong>Princípios Norteadores:</strong></p>
        <ol class="compliance-alpha-list">
          <li><strong>Tolerância Zero:</strong> repúdio absoluto a qualquer forma de corrupção, suborno, tráfico de influência ou atos ilícitos no relacionamento com agentes públicos ou privados.</li>
          <li><strong>Transparência nas Relações:</strong> todos os atos e pagamentos do escritório são documentados e auditáveis, garantindo plena conformidade fiscal e regulatória.</li>
          <li><strong>Responsabilidade Corporativa:</strong> compromisso com os princípios do Pacto Global, promovendo uma cultura organizacional de integridade em todas as operações.</li>
        </ol>

        <h3 class="mt-4">3. Código de Conduta para Fornecedores</h3>
        <p><strong>Objetivo:</strong> Garantir que toda a nossa cadeia de valor compartilhe dos mesmos valores éticos que o MDR Advocacia.</p>
        <p><strong>Princípios Norteadores:</strong></p>
        <ol class="compliance-alpha-list">
          <li><strong>Alinhamento de Valores:</strong> esperamos que nossos parceiros ajam com a mesma responsabilidade ética e social que exigimos de nossos colaboradores.</li>
          <li><strong>Direitos Humanos e Trabalho:</strong> vedação rigorosa a qualquer forma de trabalho escravo, análogo ao escravo ou infantil, bem como práticas discriminatórias.</li>
          <li><strong>Sustentabilidade e Meio Ambiente:</strong> compromisso com práticas que minimizem impactos ambientais e promovam a sustentabilidade, alinhadas às diretrizes de ESG.</li>
          <li><strong>Integridade nas Operações:</strong> garantia de que os serviços e produtos fornecidos ao escritório respeitem as normas técnicas, legais e éticas aplicáveis.</li>
        </ol>

        <h3 class="mt-4">4. Princípios de Gestão de Conflitos</h3>
        <p><strong>Objetivo:</strong> Garantir a imparcialidade e a independência técnica do escritório.</p>
        <p><strong>Princípios Norteadores:</strong></p>
        <ol class="compliance-alpha-list">
          <li><strong>Independência:</strong> o MDR Advocacia prioriza a lealdade ao cliente, estruturando seus fluxos internos para identificar e mitigar preventivamente qualquer colisão de interesses.</li>
          <li><strong>Identificação Proativa:</strong> utilizamos sistemas de controle para checagem constante de novos processos em relação à base de clientes atual.</li>
          <li><strong>Transparência na Comunicação:</strong> qualquer situação que possa representar um risco de conflito é prontamente avaliada pelos sócios e comunicada às partes interessadas, assegurando uma solução ética e célere.</li>
        </ol>
        <p>Criação de Canal de Denúncias - “Interno”, tratando-se um instrumento comprometido com os seguintes princípios: confidencialidade; imparcialidade; independência; boa-fé; não retaliação; rastreabilidade.</p>

        <div class="mt-5">
          <div class="text-center mb-4">
            <h2 style="color: var(--nav-color);">Documentos para consulta e download</h2>
            <p class="text-muted mb-0">Clique no olho para visualizar o documento e no ícone de download para baixá-lo.</p>
          </div>

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
