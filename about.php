<?php include 'header.php'; ?>

<style>
/* Estilos gerais do modal */
.modal-backdrop.show { opacity: 0.7; }
.modal-content { border-radius: 8px; border: none; box-shadow: 0 5px 25px rgba(0,0,0,0.2); }
.modal-body { padding: 2rem; }
.modal-header { border-bottom: none; padding: 1rem 1rem 0 0; }
.btn-close { background-size: 0.8rem; opacity: 0.8; }

/* Estilos da imagem do perfil no modal */
.modal-profile-image {
    width: 100%;
    max-width: 200px;
    height: auto;
    border-radius: 8px;
    border: 4px solid #c5b358;
    margin: 0 auto 1.5rem auto;
    display: block;
}

/* Tipografia dentro do modal */
.modal-profile-title { font-family: 'Montserrat', sans-serif; font-weight: 700; color: #333; font-size: 2rem; margin-bottom: 0.25rem; }
.modal-profile-role { font-family: 'Roboto', sans-serif; font-weight: 500; color: #c5b358; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem; }
.modal-profile-bio { font-family: 'Roboto', sans-serif; color: #555; line-height: 1.7; }

/* NOVO: Estilo para os itens da biografia */
.bio-item { display: block; margin-bottom: 0.75rem; }
.bio-item strong { color: #333; }


/* Links de redes sociais */
.modal-social-links a { color: #333; font-size: 1.5rem; margin-right: 1rem; transition: color 0.3s ease; }
.modal-social-links a:hover { color: #c5b358; }

/* Ajustes para telas menores */
@media (max-width: 767px) {
    .modal-profile-title { font-size: 1.5rem; }
    .modal-body { padding: 1.5rem; }
    .modal-profile-image { max-width: 150px; }
}
</style>

    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/about-page-title-bg.jpg);">
      <div class="container">
        <h1>O escritório</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">O escritório</li>
          </ol>
        </nav>
      </div>
    </div><section id="about" class="about section">

      <div class="container">

        <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-5">
            <img src="assets/img/why-us-bg.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>Um escritório jovem e moderno</h3>
              <ul>
                <li> <span>A MDR Advocacia oferece soluções jurídicas diversificadas (full service), destacando-se como parceiros estratégicos comprometidos com o sucesso e crescimento dos negócios de seus clientes, garantindo segurança jurídica em um ambiente empresarial dinâmico.</span></li>
                <li> <span>A empresa se diferencia pela alta qualidade técnica e excelência na prestação de serviços jurídicos, alinhando suas práticas aos pilares ESG, focados em responsabilidade ambiental, social e de governança.</span></li>
                <li> <span>Cada serviço é realizado com rigor técnico, agilidade e um forte compromisso com a obtenção de resultados, refletindo a crença de que o sucesso da MDR está diretamente ligado ao sucesso de seus parceiros.</span></li>
              </ul>
            </div>
          </div>
        </div>

      </div>

    </section><section id="why-us" class="why-us section">

      <div class="container">

        <div class="row g-0">

          <div class="col-xl-5 img-bg" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/why-us-bg2.jpg" alt="">
          </div>

          <div class="col-xl-7 slides position-relative" data-aos="fade-up" data-aos-delay="200">

            <div class="swiper init-swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "centeredSlides": true,
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  },
                  "navigation": {
                    "nextEl": ".swiper-button-next",
                    "prevEl": ".swiper-button-prev"
                  }
                }
              </script>
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">Missão</h3>
                    <p> Prestar serviços jurídicos de qualidade, com ética, transparência e comprometimento. Trabalhamos para garantir que nossos clientes tenham seus direitos respeitados e sejam assistidos de maneira diligente, segura e eficiente.</p>
                  </div>
                </div><div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">Visão</h3>
                    <p>Ser destaque pela excelência na prestação dos serviços jurídicos através da gestão de resultados.</p>
                  </div>
                </div><div class="swiper-slide">
                  <div class="item">
                    <h3 class="mb-3">Valores</h3>
                    <p>Ética, transparência, respeito e profissionalismo, visando sempre o melhor interesse do cliente e a construção de relações de confiança e parceria com todos os envolvidos no negócio.</p>
                  </div>
                </div></div>
              <div class="swiper-pagination"></div>
            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
          </div>

        </div>

      </div>

    </section><section id="team" class="team section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Nosso time</h2>
      </div><div class="container">

        <div class="row gy-6">

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/socios/bruna-perfil.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#modalBrunaRibeiro"><i class="bi bi-arrows-fullscreen"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Bruna Costa Ribeiro</h4>
                <span>Sócia</span>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/socios/mdrPerfil.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href="#" data-bs-toggle="modal" data-bs-target="#modalMarcosDelli"><i class="bi bi-arrows-fullscreen"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Marcos Delli Ribeiro</h4>
                <span>Sócio</span>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="team-member">
              <div class="member-img">
                <img src="assets/img/socios/natalia-perfil.jpg" class="img-fluid" alt="">
                <div class="social">
                   <a href="#" data-bs-toggle="modal" data-bs-target="#modalNataliaLinhares"><i class="bi bi-arrows-fullscreen"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Natália Ribeiro Linhares</h4>
                <span>Sócia</span>
              </div>
            </div>
          </div>
          
          <div class="row gy-6 row-center" >
            <div class="col-lg-4 col-md-6 d-flex align-items-center" data-aos="fade-up" data-aos-delay="400">
              <div class="team-member">
                <div class="member-img">
                  <img src="assets/img/socios/rodrigo2-perfil.jpg" class="img-fluid" alt="">
                  <div class="social">
                     <a href="#" data-bs-toggle="modal" data-bs-target="#modalRodrigoCavalcanti"><i class="bi bi-arrows-fullscreen"></i></a>
                  </div>
                </div>
                <div class="member-info">
                  <h4>Rodrigo Cavalcanti</h4>
                  <span>Sócio</span>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4 col-md-6 d-flex align-items-center" data-aos="fade-up" data-aos-delay="500">
              <div class="team-member">
                <div class="member-img">
                  <img src="assets/img/socios/weuder-perfil.jpg" class="img-fluid" alt="">
                  <div class="social">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalWeuderMartins"><i class="bi bi-arrows-fullscreen"></i></a>
                  </div>
                </div>
                <div class="member-info">
                  <h4>Weuder Martins Câmara</h4>
                  <span>Sócio</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>

<div class="modal fade" id="modalBrunaRibeiro" tabindex="-1" aria-labelledby="modalBrunaRibeiroLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-md-4 text-center">
            <img src="assets/img/socios/bruna-perfil.jpg" class="modal-profile-image" alt="Bruna Costa Ribeiro">
          </div>
          <div class="col-md-8">
            <h2 class="modal-profile-title">Bruna Costa Ribeiro</h2>
            <h5 class="modal-profile-role">Sócia</h5>
            <div class="modal-profile-bio">
                <span class="bio-item"><strong>Graduação:</strong> Química Industrial, Universidade Estadual da Paraíba (UEPB), 2011</span>
                <span class="bio-item"><strong>Outra graduação:</strong> Direito, Faculdade Maurício de Nassau de Natal, 2019</span>
                <span class="bio-item"><strong>Pós-graduação:</strong> Direito Previdenciário, Faculdade Legale (Faleg), 2022</span>
                <span class="bio-item"><strong>Outro:</strong> Mestranda em Direito Ambiental e Novos Direitos, Universidade de Caxias do Sul (UCS), 2024</span>
                <span class="bio-item"><strong>Idiomas:</strong> Espanhol, Inglês</span>
                <span class="bio-item"><strong>Atuação:</strong> Bancário e Financeiro, Cível, Família e Sucessões</span>
            </div>
            <div class="modal-social-links">
                <a href="https://www.instagram.com/brunacostaribeiro_/" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://www.linkedin.com/in/bruna-costa-ribeiro-947345149/" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalMarcosDelli" tabindex="-1" aria-labelledby="modalMarcosDelliLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-md-4 text-center">
            <img src="assets/img/socios/mdrPerfil.jpg" class="modal-profile-image" alt="Marcos Delli Ribeiro">
          </div>
          <div class="col-md-8">
            <h2 class="modal-profile-title">Marcos Delli Ribeiro</h2>
            <h5 class="modal-profile-role">Sócio Fundador</h5>
            <div class="modal-profile-bio">
                <span class="bio-item"><strong>Graduação:</strong> Direito, Universidade Federal de Campina Grande (UFCG), 2004</span>
                <span class="bio-item"><strong>Pós-graduação:</strong> Direito Processual Civil, Universidade Potiguar (UnP), 2005; Intensivos válidos para el Doctorado em Direito, Universidade de Buenos Aires (UBA), 2012; Intensivos válidos para el Doctorado em Direito, Universidade de Buenos Aires (UBA), 2013</span>
                <span class="bio-item"><strong>Mestrado:</strong> Mestrando em Direito, Regulação e Desenvolvimento Sustentável, Centro Universitário de João Pessoa (Unipê), 2023</span>
                <span class="bio-item"><strong>Outro:</strong> Extensão em LGPD, Pontifícia Universidade Católica (PUCRS), 2022; Doutorando em Direito, Universidade de Marília (Unimar), 2024</span>
                <span class="bio-item"><strong>Idiomas:</strong> Espanhol, Inglês</span>
                <span class="bio-item"><strong>Atuação:</strong> Bancário e Financeiro, Cível, Trabalhista</span>
            </div>
            <div class="modal-social-links">
              <a href="https://www.instagram.com/marcos_delli/" target="_blank"><i class="bi bi-instagram"></i></a>
              <a href="https://www.linkedin.com/in/marcosdelliribeiromdradvocacia/" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalRodrigoCavalcanti" tabindex="-1" aria-labelledby="modalRodrigoCavalcantiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-md-4 text-center">
            <img src="assets/img/socios/rodrigo2-perfil.jpg" class="modal-profile-image" alt="Rodrigo Cavalcanti">
          </div>
          <div class="col-md-8">
            <h2 class="modal-profile-title">Rodrigo Cavalcanti</h2>
            <h5 class="modal-profile-role">Sócio</h5>
             <div class="modal-profile-bio">
                <span class="bio-item"><strong>Graduação:</strong> Direito, Universidade Potiguar (UnP), 2003</span>
                <span class="bio-item"><strong>Pós-graduação:</strong> Ministério Público, Direito e Cidadania, Universidade Potiguar (UnP), 2003; Direito Tributário, Universidade Anhanguera (Uniderp), 2011</span>
                <span class="bio-item"><strong>Mestrado:</strong> Constituição e Garantia de Direitos, Universidade Federal do Rio Grande do Norte (UFRN), 2022</span>
                <span class="bio-item"><strong>Outro:</strong> Doutorando em Direito, Universidade de Marília (Unimar), 2024</span>
                <span class="bio-item"><strong>Idiomas:</strong> Espanhol, Inglês</span>
                <span class="bio-item"><strong>Atuação:</strong> Bancário e Financeiro, Penal, Tributário</span>
            </div>
            <div class="modal-social-links">
                <a href="https://www.instagram.com/profe.rodrigocavalcanti/" target="_blank" ><i class="bi bi-instagram"></i></a>
                <a href="https://www.linkedin.com/in/rodrigo-cavalcanti-33651b31/" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalWeuderMartins" tabindex="-1" aria-labelledby="modalWeuderMartinsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-md-4 text-center">
            <img src="assets/img/socios/weuder-perfil.jpg" class="modal-profile-image" alt="Weuder Martins Câmara">
          </div>
          <div class="col-md-8">
            <h2 class="modal-profile-title">Weuder Martins Câmara</h2>
            <h5 class="modal-profile-role">Sócio</h5>
            <div class="modal-profile-bio">
                <span class="bio-item"><strong>Graduação:</strong> Direito, Universidade do Estado do Rio Grande do Norte (Uern), 2017</span>
                <span class="bio-item"><strong>Pós-graduação:</strong> Advocacia Consultiva, Faculdade Legale (Faleg), 2022; Direito Privado, Faculdade Legale (Faleg), 2022</span>
                <span class="bio-item"><strong>MBA:</strong> Licitações e Contratos, Instituto de Pós-Graduação & Graduação (Ipog), 2021</span>
                <span class="bio-item"><strong>Mestrado:</strong> Constituição, Regulação e Desenvolvimento Econômico, Universidade Federal do Rio Grande do Norte (UFRN), 2022</span>
                <span class="bio-item"><strong>Idiomas:</strong> Espanhol, Inglês</span>
                <span class="bio-item"><strong>Atuação:</strong> Administrativo, Bancário e Financeiro, Regulatório</span>
            </div>
            <div class="modal-social-links">
                <a href="https://www.instagram.com/weuderm.adv/" target="_blank"><i class="bi bi-instagram"></i></a>
                <a href="https://www.linkedin.com/in/weuderm/" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalNataliaLinhares" tabindex="-1" aria-labelledby="modalNataliaLinharesLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-md-4 text-center">
            <img src="assets/img/socios/natalia-perfil.jpg" class="modal-profile-image" alt="Natália Ribeiro Linhares">
          </div>
          <div class="col-md-8">
            <h2 class="modal-profile-title">Natália Ribeiro Linhares</h2>
            <h5 class="modal-profile-role">Sócia</h5>
            <div class="modal-profile-bio">
                <span class="bio-item"><strong>Graduação:</strong> Ciências Jurídicas e Sociais, Universidade Federal de Campina Grande (UFCG), 2010</span>
                <span class="bio-item"><strong>Pós-graduação:</strong> Direito Administrativo e Gestão Pública, Faculdades Integradas de Patos (FIP), 2016</span>
                <span class="bio-item"><strong>Outro:</strong> Mestranda em Direito Ambiental e Sociedade, Universidade de Caxias do Sul (UCS), 2024</span>
                <span class="bio-item"><strong>Idiomas:</strong> Espanhol, Inglês</span>
                <span class="bio-item"><strong>Atuação:</strong> Cível, Direito Público, Trabalhista</span>
            </div>
            <div class="modal-social-links">
                <a href="https://www.instagram.com/nataliarlinhares/" target="_blank" ><i class="bi bi-instagram"></i></a>
                <a href="https://www.linkedin.com/in/nat%C3%A1lia-linhares-a482b1267/" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>