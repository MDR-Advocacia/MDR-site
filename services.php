<?php include 'header.php'; ?>

<style>
@keyframes riseUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Container Principal - AGORA CENTRALIZADO */
.page-title-video {
    position: relative;
    overflow: hidden;
    height: 60vh; /* Define uma altura, ex: 60% da tela */
    color: white;
    
    /* Alinhamento central */
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Vídeo de Fundo */
.video-background {
    position: absolute;
    top: 50%; left: 50%;
    min-width: 100%; min-height: 100%;
    width: auto; height: auto;
    object-fit: cover;
    transform: translate(-50%, -50%);
    z-index: 1;
}

/* Camada Escura (Overlay) */
.video-overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 2;
}

/* Conteúdo (Título e Breadcrumbs) */
.page-title-video .container {
    position: relative;
    z-index: 3;
}

.page-title-video h1 {
    font-size: 48px; /* Aumentei um pouco para mais destaque */
    font-weight: bold;
    color: #FFFFFF;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
    
    /* APLICA A ANIMAÇÃO DE SUBIDA */
    animation: riseUp 1s ease-out forwards;
}

/* Estilos para o menu 'Home / Atuação' (Breadcrumbs) */
.page-title-video .breadcrumbs ol {
    display: flex;
    justify-content: center; /* Centraliza os breadcrumbs também */
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin-top: 10px;
    color: rgba(255, 255, 255, 0.8);
    animation: riseUp 1s ease-out 0.2s forwards; /* Animação com um pequeno atraso */
    opacity: 0; /* Começa invisível para a animação funcionar */
}
.page-title-video .breadcrumbs ol li+li { padding-left: 10px; }
.page-title-video .breadcrumbs ol li+li::before { content: "/"; display: inline-block; padding-right: 10px; color: rgba(255, 255, 255, 0.8); }
.page-title-video .breadcrumbs a { color: rgba(255, 255, 255, 0.9); text-decoration: none; transition: 0.3s; }
.page-title-video .breadcrumbs a:hover { color: #fff; }

</style>

    <div class="page-title-video dark-background">
      <div class="video-overlay"></div>
      <video autoplay loop muted playsinline class="video-background">
        <source src="assets/video/atuacao.mp4" type="video/mp4">
        Seu navegador não suporta vídeos em HTML5.
      </video>
      <div class="container" data-aos="fade">
        <h1>Nossa atuação</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Atuação</li>
          </ol>
        </nav>
      </div>
    </div>
    <section id="services" class="services section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Nossa atuação</h2>
      </div><div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="icon flex-shrink-0"><i class="bi bi-briefcase" style="color: #f57813;"></i></div>
            <div>
              <h4 class="title">Direito Bancário</h4>
              <p class="description">Com uma equipe especializada em Direito Bancário, nós entendemos a importância dessa matéria na economia e estamos preparados para lidar com os desafios legais e regulatórios que envolvem essa área.</p>
              <a href="service1.php" class="readmore stretched-link"><span>Saiba mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="icon flex-shrink-0"><i class="bi bi-card-checklist" style="color: #15a04a;"></i></div>
            <div>
              <h4 class="title">Direito Regulatório</h4>
              <p class="description">Nosso escritório conta com uma equipe especializada em Direito Regulatório e focada em todas as complexidades que advém dessa esfera. Sempre atualizados, nossos serviços são voltados a compreender todas as leis e regulamentos que governam indústrias e setores específicos, entre outros</p>
              <a href="service2.php" class="readmore stretched-link"><span>Saiba mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div><div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="icon flex-shrink-0"><i class="bi bi-bar-chart" style="color: #d90769;"></i></div>
            <div>
              <h4 class="title">Direito Fiscal e Tributário</h4>
              <p class="description">Nossa equipe oferece uma gama abrangente de serviços em Direito Fiscal e Tributário. Somos focados em auxiliar empresas e indivíduos a entender suas obrigações fiscais, desenvolvendo estratégias de planejamento tributário personalizadas a fim de prevenir prejuízos e reduzir a carga tributária.</p>
              <a href="service3.php" class="readmore stretched-link"><span>Saiba mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div><div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="icon flex-shrink-0"><i class="bi bi-binoculars" style="color: #15bfbc;"></i></div>
            <div>
              <h4 class="title">Comércio Internacional</h4>
              <p class="description">Somos um escritório de advocacia especializado em assuntos relacionados ao Comércio Internacional, oferecendo suporte legal abrangente para empresas que atuam no mercado global.</p>
              <a href="service4.php" class="readmore stretched-link"><span>Saiba mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div><div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="500">
            <div class="icon flex-shrink-0"><i class="bi bi-brightness-high" style="color: #f5cf13;"></i></div>
            <div>
              <h4 class="title">Planejamento Sucessório</h4>
              <p class="description">No nosso escritório, entendemos a importância de planejar o futuro e proteger o patrimônio e o bem-estar da sua família. Nosso foco é oferecer serviços especializados em planejamento sucessório, com uma abordagem moderna e ética, para garantir uma transição tranquila e segura para as gerações futuras.</p>
              <a href="service5.php" class="readmore stretched-link"><span>Saiba mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div><div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="600">
            <div class="icon flex-shrink-0"><i class="bi bi-calendar4-week" style="color: #1335f5;"></i></div>
            <div>
              <h4 class="title">Seguros</h4>
              <p class="description">Nós reconhecemos a importância de proteger o patrimônio e garantir a segurança financeira dos nossos clientes. Também somos especialistas em oferecer serviços personalizados em seguros, com uma abordagem moderna para proporcionar tranquilidade e proteção para o presente e para o futuro.</p>
              <a href="service6.php" class="readmore stretched-link"><span>Saiba mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div><div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="600">
            <div class="icon flex-shrink-0"><i class="bi bi-cash-coin" style="color: #b29d55;"></i></div>
            <div>
              <h4 class="title">Recuperação de Crédito</h4>
              <p class="description">No nosso escritório, atuamos como parceiros estratégicos do seu negócio. Nosso compromisso é com o resultado, recuperando seus ativos de forma ética e eficiente, enquanto protegemos o valor mais importante: a sua marca.</p>
              <a href="recuperacao-credito.php" class="readmore stretched-link"><span>Saiba mais</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </div></div>

      </div>

    </section><section id="testimonials" class="testimonials section">

      <div class="container section-title" data-aos="fade-up">
        <h2>Depoimentos</h2>
        <p>Seu Feedback nos inspira!</p>
      </div><div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Escritório de excelência, com profissionais extremamente qualificados.
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-1.png" class="testimonial-img" alt="">
                  <h3>Gabriel Abner</h3>
                  
                </div>
              </div>
            </div><div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  O melhor e mais conceituado serviço de advocacia que conheço , Ótimos profissionais e um atendimento que não deixa a desejar em nada .
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-2.png" class="testimonial-img" alt="">
                  <h3>Plinio Neto</h3>
                </div>
              </div>
            </div><div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Atendimento com ótimos profissionais capacitados, ambiente aconchegante. Empresa organizada e ótima localização!
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-3.png" class="testimonial-img" alt="">
                  <h3>Ana Virgínia</h3>
                </div>
              </div>
            </div><div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Um local ótimo, tanto para atendimento quanto para trabalho. Incrível!
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-4.png" class="testimonial-img" alt="">
                  <h3>Gabriela Rodrigues</h3>
                </div>
              </div>
            </div><div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Atendimento maravilhoso,  desde o atendimento telefônico até o final. Todos atenciosos e prestativos.  Local de fácil localização,  com bom local para estacionar. Ambiente agradável de estar. Nota dez. Faz a gente sentir-se importante, acolhida e ouvida. Um exemplo a ser seguido. Parabéns!
                </p>
                <div class="profile mt-auto">
                  <img src="assets/img/testimonials/testimonials-5.png" class="testimonial-img" alt="">
                  <h3>Neuza Mendonça</h3>
                </div>
              </div>
            </div></div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><?php include 'footer.php'; ?>
