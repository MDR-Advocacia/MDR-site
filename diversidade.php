<?php include 'header.php'; ?>

<style>
/* ====== INÍCIO DOS AJUSTES DE CONSISTÊNCIA DE FONTE ====== */
#diversidade .section-title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    color: #333; /* Cor padrão para títulos de seção */
}

#diversidade .section-subtitle {
    font-family: 'Roboto', sans-serif;
    color: #555; /* Cor padrão para subtítulos/parágrafos */
    line-height: 1.7;
}
/* ========================================================== */

/* Reutilizando e adaptando estilos do modal da equipe */
.modal-backdrop.show { opacity: 0.7; }
.modal-content { border-radius: 8px; border: none; box-shadow: 0 5px 25px rgba(0,0,0,0.2); }
.modal-body { padding: 2rem; }
.modal-header { border-bottom: none; padding: 1rem 1rem 0 0; }
.btn-close { background-size: 0.8rem; opacity: 0.8; }

/* Títulos e textos dentro do modal de diversidade */
.modal-committee-title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    color: #c5b358; /* Título em dourado */
    font-size: 2.2rem;
    margin-bottom: 1.5rem;
    text-align: center;
}
.modal-committee-subtitle {
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    color: #333;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
}
.modal-committee-text, .modal-committee-list li {
    font-family: 'Roboto', sans-serif;
    color: #555;
    line-height: 1.7;
    margin-bottom: 1rem; /* Espaçamento entre parágrafos e itens de lista */
}
.modal-committee-list {
    list-style: none;
    padding-left: 0;
}
.modal-committee-list li::before {
    content: "✔";
    color: #c5b358;
    margin-right: 10px;
    font-weight: bold;
}

/* Estilo para os novos cards dos comitês */
.committee-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    overflow: hidden;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    cursor: pointer;
}
.committee-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}
.committee-card .card-img-top {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.committee-card .card-body {
    padding: 1.5rem;
}
.committee-card .card-title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    color: #333;
    margin: 0;
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
        <h2 class="section-title">Nossos Comitês de Diversidade e Inclusão</h2>
        <p class="section-subtitle" style="max-width: 800px; margin: 0 auto 3rem auto;">
            Acreditamos que a diversidade de ideias, origens e experiências é o motor para a inovação. Nossos comitês são grupos de afinidade dedicados a promover um ambiente de trabalho cada vez mais justo, inclusivo e plural.
        </p>
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

<div class="modal fade" id="modalGenero" tabindex="-1" aria-labelledby="modalGeneroLabel" aria-hidden="true">
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

<div class="modal fade" id="modalPCD" tabindex="-1" aria-labelledby="modalPCDLabel" aria-hidden="true">
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

<div class="modal fade" id="modalRaca" tabindex="-1" aria-labelledby="modalRacaLabel" aria-hidden="true">
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

<div class="modal fade" id="modalLGBT" tabindex="-1" aria-labelledby="modalLGBTLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
      <div class="modal-body">
        <h2 class="modal-committee-title">LGBTQIAPN+</h2>
        <p class="modal-committee-text">Estamos dando passos concretos em direção a um ambiente mais inclusivo, diverso e acolhedor para pessoas LGBTQIA+. Acreditamos que a valorização das identidades é fundamental para fortalecer uma cultura organizacional baseada no respeito e na equidade.</p>
        <p class="modal-committee-text">Essas iniciativas refletem nosso compromisso contínuo com a construção de uma cultura mais inclusiva e respeitosa, dentro e fora da organização, em alinhamento com o Objetivo de Desenvolvimento Sustentável 10 – Redução das Desigualdades, que propõe promover a inclusão social, econômica e política de todas as pessoas, independentemente de sua orientação sexual ou qualquer outra condição.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalReligiosa" tabindex="-1" aria-labelledby="modalReligiosaLabel" aria-hidden="true">
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