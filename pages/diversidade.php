<?php include '../includes/header.php'; ?>

<style>
  /* Melhoria visual nos Cards dos Comitês */
  .committee-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    background: #fff;
    height: 100%;
  }

  .committee-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
  }

  .committee-card img {
    height: 200px;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .committee-card:hover img {
    transform: scale(1.05);
  }

  .committee-card .card-body {
    padding: 1.5rem;
    text-align: center;
  }

  .committee-card .card-title {
    font-weight: 700;
    color: var(--heading-color, #333);
    margin-bottom: 0;
  }

  /* Nova Seção de Vídeo */
  .video-highlight {
    background: #f9f9f9;
    border-radius: 20px;
    padding: 2rem;
    margin: 3rem auto;
    max-width: 800px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.05);
  }

  .video-thumbnail-wrapper {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    margin-bottom: 1.5rem;
    aspect-ratio: 16/9;
  }

  .video-thumbnail-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: opacity 0.3s;
  }

  .video-thumbnail-wrapper:hover img {
    opacity: 0.9;
  }

  /* Botão Play no meio da imagem */
  .play-icon-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: var(--accent-color, #d9a520); /* Ajuste para a cor da sua marca */
    transition: all 0.3s ease;
    animation: pulse 2s infinite;
  }

  .video-thumbnail-wrapper:hover .play-icon-overlay {
    background: #fff;
    transform: translate(-50%, -50%) scale(1.1);
    color: #000;
  }

  .btn-watch-action {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 35px;
    border-radius: 50px;
    background-color: var(--accent-color, #d9a520); /* Ajuste para a cor da sua marca */
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: 0.3s;
    text-decoration: none;
  }

  .btn-watch-action:hover {
    background-color: #333;
    color: #fff;
    transform: translateY(-2px);
  }

  @keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7); }
    70% { box-shadow: 0 0 0 20px rgba(255, 255, 255, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
  }
</style>

<div class="page-title dark-background" data-aos="fade">
  <div class="container">
    <h1>Diversidade</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="/">Home</a></li>
        <li class="current">Diversidade</li>
      </ol>
    </nav>
  </div>
</div>

<div vw class="enabled">
  <div vw-access-button class="active"></div>
  <div vw-plugin-wrapper>
    <div class="vw-plugin-top-wrapper"></div>
  </div>
</div>
<script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
<script>
  new window.VLibras.Widget('https://vlibras.gov.br/app'); 
</script>

<section id="diversidade" class="section">
  <div class="container">
    
    <div data-aos="fade-up" class="text-center mx-auto" style="max-width: 900px;">
      <h2 class="section-title mb-4">Nosso Comitê de Diversidade e Inclusão</h2>
      <p class="lead mb-4" style="font-size: 1.1rem; line-height: 1.8;">
        A diversidade no MDR não é um diferencial, é parte do que nos constitui. Para fortalecer esse compromisso, foi criado o <strong>MDR Diversidade em Movimento</strong>, um Comitê de Diversidade que busca transformar o ambiente de trabalho e a forma de enxergar o outro, promovendo respeito, acolhimento e ação concreta.
      </p>
      <p class="mb-5 text-muted">
        O comitê nasceu da escuta de demandas reais e organiza diferentes grupos de trabalho voltados a pautas como gênero, raça, LGBTQIAPN+, pessoas com deficiência e diversidade religiosa. Cada grupo desenvolve ações específicas para promover inclusão, representatividade e equidade.
      </p>
    </div>

    <div class="video-highlight" data-aos="zoom-in">
        <div class="text-center mb-3">
            <h3>Conheça nosso Comitê</h3>
            <p class="text-muted">Veja como a diversidade transforma nossa advocacia</p>
        </div>
        
        <div class="video-thumbnail-wrapper">
            <img src="https://img.youtube.com/vi/Q-72lIY8QN8/maxresdefault.jpg" alt="Vídeo Manifesto Diversidade">
            
            <a href="https://youtu.be/Q-72lIY8QN8" class="glightbox play-icon-overlay">
                <i class="bi bi-play-fill"></i>
            </a>
        </div>

        <div class="text-center">
            <a href="https://youtu.be/Q-72lIY8QN8" class="glightbox btn-watch-action">
                <i class="bi bi-play-circle"></i> Assistir ao Vídeo Completo
            </a>
        </div>
    </div>
    <div class="row gy-4 justify-content-center mt-5" data-aos="fade-up" data-aos-delay="100">

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalGenero">
          <img src="/assets/img/diversidade/comite-generos.jpg" class="card-img-top" alt="Comitê de Diversidade de Gênero">
          <div class="card-body">
            <h4 class="card-title">Equidade de Gênero</h4>
            <small class="text-muted">Clique para saber mais</small>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalPCD">
          <img src="/assets/img/diversidade/comite-pcd.jpg" class="card-img-top" alt="Comitê de Inclusão de Pessoas com Deficiência (PCD)">
          <div class="card-body">
            <h4 class="card-title">Pessoas com Deficiência</h4>
             <small class="text-muted">Clique para saber mais</small>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalRaca">
          <img src="/assets/img/diversidade/comite-racial.jpg" class="card-img-top" alt="Comitê de Diversidade de Raça">
          <div class="card-body">
            <h4 class="card-title">Igualdade Racial</h4>
             <small class="text-muted">Clique para saber mais</small>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalLGBT">
          <img src="/assets/img/diversidade/comite-lgbt.jpg" class="card-img-top" alt="Comitê de Diversidade LGBTQIAPN+">
          <div class="card-body">
            <h4 class="card-title">LGBTQIAPN+</h4>
             <small class="text-muted">Clique para saber mais</small>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalReligiosa">
          <img src="/assets/img/diversidade/comite-religiao.jpg" class="card-img-top" alt="Comitê de Diversidade Religiosa">
          <div class="card-body">
            <h4 class="card-title">Diversidade Religiosa</h4>
             <small class="text-muted">Clique para saber mais</small>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<div class="modal fade" id="modalGenero" tabindex="-1" aria-labelledby="modalGeneroLabel" aria-hidden="true" style="background-image: url(/assets/img/diversidade/comite-generos.jpg);">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body">
        <h2 class="modal-committee-title">Equidade de Gênero</h2>
        <p class="modal-committee-text">Promovemos ativamente a equidade de gênero e temos orgulho de contar com uma equipe majoritariamente composta por mulheres. Elas ocupam posições de liderança e tomam parte das decisões estratégicas da organização.</p>
        <p class="modal-committee-text">Valorizamos a representatividade como fator essencial para a transformação social. Por isso, realizamos periodicamente palestras e rodas de conversa sobre gênero, criando espaços de reflexão, escuta e aprendizado coletivo.</p>
        <p class="modal-committee-text">Também incentivamos a produção de conhecimento por meio da publicação de artigos científicos voltados à temática de gênero e diversidade, reforçando nosso compromisso com a inclusão, o protagonismo feminino e o pensamento crítico.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPCD" tabindex="-1" aria-labelledby="modalPCDLabel" aria-hidden="true" style="background-image: url(/assets/img/diversidade/comite-pcd.jpg);">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body">
        <h2 class="modal-committee-title">Pessoas com Deficiência (PCD)</h2>
        <p class="modal-committee-text">Estamos comprometidos em promover a inclusão e a acessibilidade para pessoas com deficiência. Valorizamos um ambiente de trabalho mais justo, equitativo e representativo, onde todas as pessoas possam se sentir respeitadas e acolhidas.</p>
        <p class="modal-committee-text">Acreditamos que a diversidade de habilidades contribui significativamente para o fortalecimento da nossa cultura organizacional. Por isso, buscamos garantir oportunidades reais de crescimento e participação.</p>
        <p class="modal-committee-text">Revisamos constantemente nossos processos, espaços e práticas para torná-los mais acessíveis. Nosso compromisso é construir um ambiente cada vez mais inclusivo e aberto à pluralidade de experiências.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalRaca" tabindex="-1" aria-labelledby="modalRacaLabel" aria-hidden="true" style="background-image: url(/assets/img/diversidade/comite-racial.jpg);">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body">
        <h2 class="modal-committee-title">Diversidade de Raça</h2>
        <p class="modal-committee-text">Acreditamos que a valorização da diversidade racial é fundamental para a construção de um ambiente de trabalho mais justo, plural e representativo. Reforçamos nosso compromisso com o respeito às identidades e histórias que compõem nossa equipe.</p>
        <p class="modal-committee-text">Buscamos ampliar a inclusão racial em nossos processos seletivos, bem como nas oportunidades de crescimento e desenvolvimento profissional. A equidade é um princípio que orienta nossas ações e decisões institucionais.</p>
        <p class="modal-committee-text">Promovemos debates, formações e campanhas educativas que estimulam a consciência racial e o enfrentamento ao racismo estrutural. Nossa meta é fortalecer uma cultura organizacional baseada na justiça e na reparação histórica.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalLGBT" tabindex="-1" aria-labelledby="modalLGBTLabel" aria-hidden="true" style="background-image: url(/assets/img/diversidade/comite-lgbt.jpg);">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body">
        <h2 class="modal-committee-title">LGBTQIAPN+</h2>
        <p class="modal-committee-text">Estamos dando passos concretos em direção a um ambiente mais inclusivo, diverso e acolhedor para pessoas LGBTQIAPN+. Acreditamos que a valorização das identidades é fundamental para fortalecer uma cultura organizacional baseada no respeito e na equidade.</p>
        <p class="modal-committee-text">Essas iniciativas refletem nosso compromisso contínuo com a construção de uma cultura mais inclusiva e respeitosa, dentro e fora da organização, em alinhamento com o Objetivo de Desenvolvimento Sustentável 10 – Redução das Desigualdades, que propõe promover a inclusão social, econômica e política de todas as pessoas, independentemente de sua orientação sexual ou qualquer outra condição.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalReligiosa" tabindex="-1" aria-labelledby="modalReligiosaLabel" aria-hidden="true" style="background-image: url(/assets/img/diversidade/comite-religiao.jpg);">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body">
        <h2 class="modal-committee-title">Diversidade Religiosa</h2>
        <p class="modal-committee-text">Respeitamos a diversidade religiosa como parte essencial de um ambiente de trabalho plural, ético e acolhedor. Reconhecemos o direito de cada pessoa expressar suas crenças, práticas e convicções de maneira livre e sem discriminação.</p>
        <p class="modal-committee-text">Acreditamos que o diálogo inter-religioso e o respeito mútuo fortalecem a convivência e ampliam a compreensão entre os colaboradores. Deste modo, valorizamos a escuta e a empatia como caminhos para a inclusão.</p>
        <p class="modal-committee-text">Nossas ações estão voltadas para a promoção da liberdade de crença, garantindo que todos tenham espaço para manifestar sua espiritualidade com dignidade e segurança no ambiente profissional.</p>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>