<?php include 'header.php'; ?>

<style>
  .diversity-intro-image { text-align: center; margin: 2rem 0 4rem 0; }
  .diversity-intro-image img { max-width: 450px; width: 100%; }
  .pillar { display: flex; flex-direction: column; align-items: center; text-align: center; height: 100%; padding-bottom: 1.5rem; }
  .pillar p { flex-grow: 1; }
  .pillar-image { width: 100%; max-width: 250px; height: auto; border-radius: 8px; margin-top: 1.5rem; }
  .pillar i { font-size: 3rem; color: #c5b358; margin-bottom: 1rem; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; }
  .diversity-pillars { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; text-align: center; }
  .subsection-title { text-align: center; color: #333; margin-top: 4rem; margin-bottom: 2rem; font-weight: 600; }
  .committee-members { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; justify-content: center; }
  .member-card { background: #fff; border: 1px solid #eee; border-radius: 8px; text-align: center; padding: 1.5rem; transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .member-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
  .member-card img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; border: 3px solid #c5b358; }
  .watch-video-container {text-align: center;margin: 2rem 0;}
  .btn-brand:hover {color: #ffffff;transform: translateY(-3px);box-shadow: 0 6px 20px rgba(197, 179, 88, 0.4); /* Sombra dourada no hover */}
  .btn-brand i {font-size: 1.5rem;margin-right: 10px;}
  .btn-brand {
      background-color: #c5b358; /* Cor dourada principal */
      color: #ffffff;
      padding: 12px 30px;
      border-radius: 50px; /* Formato de pílula */
      font-weight: 600;
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      display: inline-flex; /* Para alinhar o ícone e o texto */
      align-items: center;
      text-decoration: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
  }
    

</style>

<div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/diversidade/back-diversity.jpg);">
  <div class="container">
    <h1>Comitês de Diversidade</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li class="current">Diversidade</li>
      </ol>
    </nav>
  </div>
</div>

<section id="diversidade" class="section">
  <div class="container">
    <div data-aos="fade-up" class="text-center">
      <h2 class="section-title">Nosso Comitê de Diversidade e Inclusão</h2>
      <p class="section-subtitle" style="max-width: 800px; margin: 0 auto 3rem auto;">
        Acreditamos que a diversidade de ideias, origens e experiências é o motor para a inovação. Nossos comitês são grupos de afinidade dedicados a promover um ambiente de trabalho cada vez mais justo, inclusivo e plural.
      </p>

      <div class="watch-video-container">
        <a href="https://youtu.be/hqCj1MFdeBA" class="glightbox btn-brand"><i class="bi bi-play-circle-fill"></i><span>Assista ao vídeo</span></a>
      </div>
    </div>

    <div class="row gy-4 justify-content-center" data-aos="fade-up" data-aos-delay="100">

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalGenero">
          <img src="assets/img/diversidade/comite-generos.jpg" class="card-img-top" alt="Comitê de Diversidade de Gênero">
          <div class="card-body">
            <h4 class="card-title">Equidade de Gênero</h4>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalPCD">
          <img src="assets/img/diversidade/comite-pcd.jpg" class="card-img-top" alt="Comitê de Inclusão de Pessoas com Deficiência (PCD)">
          <div class="card-body">
            <h4 class="card-title">Pessoas com Deficiência</h4>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalRaca">
          <img src="assets/img/diversidade/comite-racial.jpg" class="card-img-top" alt="Comitê de Diversidade de Raça">
          <div class="card-body">
            <h4 class="card-title">Igualdade Racial</h4>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalLGBT">
          <img src="assets/img/diversidade/comite-lgbt.jpg" class="card-img-top" alt="Comitê de Diversidade LGBTQIAPN+">
          <div class="card-body">
            <h4 class="card-title">LGBTQIAPN+</h4>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="committee-card" data-bs-toggle="modal" data-bs-target="#modalReligiosa">
          <img src="assets/img/diversidade/comite-religiao.jpg" class="card-img-top" alt="Comitê de Diversidade Religiosa">
          <div class="card-body">
            <h4 class="card-title">Diversidade Religiosa</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modalGenero" tabindex="-1" aria-labelledby="modalGeneroLabel" aria-hidden="true" style="background-image: url(assets/img/diversidade/comite-generos.jpg);">
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

<div class="modal fade" id="modalPCD" tabindex="-1" aria-labelledby="modalPCDLabel" aria-hidden="true" style="background-image: url(assets/img/diversidade/comite-pcd.jpg);">
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

<div class="modal fade" id="modalRaca" tabindex="-1" aria-labelledby="modalRacaLabel" aria-hidden="true" style="background-image: url(assets/img/diversidade/comite-racial.jpg);">
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

<div class="modal fade" id="modalLGBT" tabindex="-1" aria-labelledby="modalLGBTLabel" aria-hidden="true" style="background-image: url(assets/img/diversidade/comite-lgbt.jpg);">
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

<div class="modal fade" id="modalReligiosa" tabindex="-1" aria-labelledby="modalReligiosaLabel" aria-hidden="true" style="background-image: url(assets/img/diversidade/comite-religiao.jpg);">
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

<?php include 'footer.php'; ?>