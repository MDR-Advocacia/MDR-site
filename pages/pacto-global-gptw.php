<?php
$pageTitle = 'Pacto Global e GPTW - MDR Advocacia';
$pageDescription = 'Participação da MDR Advocacia no Pacto Global da ONU e certificação GPTW.';
$pageKeywords = 'MDR Advocacia, ESG, Pacto Global, ONU, GPTW, Great Place to Work';
$bodyClass = 'index-page esg-page';
include '../includes/header.php';
?>

<style>
  .section-title .esg-intro {
    max-width: 920px;
    margin: 0 auto;
    color: color-mix(in srgb, var(--default-color), transparent 18%);
    font-size: 1.05rem;
    line-height: 1.8;
  }

  .esg-achievement-card {
    height: 100%;
    background: #fff;
    border: 1px solid rgba(27, 47, 69, 0.1);
    border-radius: 18px;
    box-shadow: 0 16px 40px rgba(27, 47, 69, 0.08);
    overflow: hidden;
  }

  .esg-logo-panel {
    min-height: 320px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f7fbfc;
    border-bottom: 1px solid rgba(27, 47, 69, 0.08);
  }

  .esg-logo-panel.dark {
    background: #17283b;
  }

  .esg-logo-panel.full-bleed {
    min-height: 0;
    padding: 0;
  }

  .esg-logo-panel img {
    max-width: 100%;
    max-height: 275px;
    width: auto;
    height: auto;
    object-fit: contain;
    display: block;
  }

  .esg-logo-panel .esg-gptw-seal {
    max-height: 300px;
  }

  /* Logo do Pacto Global exibida inteira, sem cortes, conforme diretriz de integridade da marca */
  .esg-logo-panel.full-bleed img {
    width: 100%;
    height: auto;
    max-height: none;
  }

  .esg-achievement-body {
    padding: 1.75rem;
  }

  .esg-kicker {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    color: #b29d55;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 0.85rem;
  }

  .esg-achievement-body h3 {
    color: var(--heading-color);
    margin-bottom: 0.9rem;
  }

  .esg-achievement-body p {
    line-height: 1.75;
    margin-bottom: 1rem;
  }

  .esg-note {
    background: #f8fbfc;
    border-left: 4px solid #b29d55;
    border-radius: 10px;
    color: color-mix(in srgb, var(--default-color), transparent 8%);
    font-size: 0.94rem;
    line-height: 1.65;
    padding: 1rem 1.1rem;
    margin-top: 1.25rem;
  }

  .esg-support-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin-top: 2rem;
  }

  .esg-support-item {
    background: #fff;
    border: 1px solid rgba(27, 47, 69, 0.1);
    border-radius: 14px;
    padding: 0;
    text-align: center;
    box-shadow: 0 10px 25px rgba(27, 47, 69, 0.06);
    overflow: hidden;
  }

  .esg-support-image {
    background: #f3f7f6;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    overflow: hidden;
  }

  .esg-support-item img {
    width: 100%;
    height: 300px;
    object-fit: contain;
    object-position: center;
    display: block;
  }

  .esg-support-item span {
    display: block;
    color: var(--heading-color);
    font-weight: 700;
    padding: 1.1rem 1rem;
    background: #fff;
  }

  @media (max-width: 991.98px) {
    .esg-support-grid {
      grid-template-columns: 1fr;
    }

    .esg-support-image {
      min-height: 330px;
    }

    .esg-support-item img {
      height: 330px;
    }
  }
</style>

<div class="page-title dark-background" data-aos="fade">
  <div class="container">
    <h1>Pacto Global e GPTW</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li>ESG</li>
        <li class="current">Pacto Global e GPTW</li>
      </ol>
    </nav>
  </div>
</div>

<section id="pacto-global-gptw" class="section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Compromissos que fortalecem nossa agenda ESG</h2>
    <p class="esg-intro">A MDR Advocacia reúne nesta página sua participação no Pacto Global da ONU e a certificação GPTW, iniciativas alinhadas ao nosso compromisso com governança, responsabilidade social, integridade e desenvolvimento humano.</p>
  </div>
  <div class="container" data-aos="fade-up">

    <div class="row gy-4">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <article class="esg-achievement-card">
          <div class="esg-logo-panel dark full-bleed">
            <img src="/assets/img/pactoglobal/Imagem1.jpg" alt="Logo de participante 2026 do Pacto Global da ONU">
          </div>
          <div class="esg-achievement-body">
            <div class="esg-kicker"><i class="bi bi-globe-americas"></i> Pacto Global da ONU</div>
            <h3>Participante do Pacto Global - Rede Brasil ONU</h3>
            <p>A MDR Advocacia integra o Pacto Global da ONU, iniciativa que mobiliza organizações comprometidas com princípios universais nas áreas de direitos humanos, trabalho, meio ambiente e combate à corrupção.</p>
            <p>Essa participação fortalece a evolução da nossa agenda ESG e reforça o compromisso institucional com condutas responsáveis, transparentes e orientadas à geração de valor sustentável.</p>
            <div class="esg-note">
              O uso da logo de participante observa as diretrizes do Pacto Global da ONU e não implica endosso, aprovação ou certificação das atividades, produtos ou serviços da MDR Advocacia pela ONU ou pelo Pacto Global.
            </div>
          </div>
        </article>
      </div>

      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <article class="esg-achievement-card">
          <div class="esg-logo-panel">
            <img class="esg-gptw-seal" src="/assets/img/gptw/selo-gptw-2026.png" alt="Selo Great Place to Work certificado agosto 2026 a agosto 2027">
          </div>
          <div class="esg-achievement-body">
            <div class="esg-kicker"><i class="bi bi-award"></i> Great Place to Work</div>
            <h3>Certificação GPTW - Ótimo Lugar para Trabalhar</h3>
            <p>A conquista do selo GPTW reconhece a MDR Advocacia como um ambiente de trabalho comprometido com confiança, respeito, desenvolvimento, colaboração e valorização das pessoas.</p>
            <p>O reconhecimento reforça nossa cultura organizacional e evidencia o cuidado contínuo com a experiência dos colaboradores, um dos pilares da sustentabilidade institucional do escritório.</p>
          </div>
        </article>
      </div>
    </div>

    <div class="esg-support-grid" data-aos="fade-up" data-aos-delay="250">
      <div class="esg-support-item">
        <div class="esg-support-image">
          <img src="/assets/img/gptw/gptw-indice-de-confianca.png" alt="Material GPTW com índice de confiança">
        </div>
        <span>Confiança e clima organizacional</span>
      </div>
      <div class="esg-support-item">
        <div class="esg-support-image">
          <img src="/assets/img/gptw/gptw-pessoas-excelentes.png" alt="Material GPTW sobre pessoas excelentes">
        </div>
        <span>Pessoas no centro da cultura</span>
      </div>
      <div class="esg-support-item">
        <div class="esg-support-image">
          <img src="/assets/img/gptw/gptw-certificacao-nacional.png" alt="Material GPTW sobre certificação nacional">
        </div>
        <span>Reconhecimento GPTW Brasil</span>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>