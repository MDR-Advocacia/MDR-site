<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MDR Advocacia - Trabalhe Conosco</title>
  <meta name="description" content="Escritório full service especialista em atendimentos de instituições bancárias">
  <meta name="keywords" content="MDR,MARCOS DELLI RODRIGUES, ADVOCACIA, DELLI, NATAL, ADVOGADOS, ADVOGADA, CAPIM MACIO, TRABALHE CONOSCO, VAGAS">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="services-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="/assets/img/logo.png" alt="Logo MDR Advocacia">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">O escritório</a></li>
          <li><a href="services.html">Atuação</a></li>
          <li><a href="http://mdradvocacia.com/interno">Interno</a></li>
          <li><a href="trabalhe-conosco.html" class="active">Trabalhe conosco</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/services-page-title-bg.jpg);">
      <div class="container">
        <h1>Trabalhe conosco</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Trabalhe conosco</li>
          </ol>
        </nav>
      </div>
    </div><section class="contact-form-section section-bg">
      <div class="container" data-aos="fade-up">

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="diversity-section-box p-4 mb-5" style="background-color: #f8f9fa; border-left: 5px solid var(--accent-color, #007bff);">
                    <h2 class="h4" style="color: var(--accent-color, #007bff);">Venha somar sua trajetória à nossa!</h2>
                    <p>Acreditamos que um time com trajetórias diversas enriquece nossa cultura, impulsiona a inovação e fortalece o crescimento coletivo. Valorizamos a empatia e a colaboração que nascem de diferentes perspectivas.</p>
                    <p>Por isso, estamos com <strong>vagas afirmativas abertas para pessoas negras, indígenas, LGBTQIAPN+, pessoas com deficiência e de outros grupos historicamente minorizados.</strong></p>
                    <p class="mb-0">Se você se identifica com esses valores e quer construir um ambiente de trabalho mais justo e inovador, venha fazer parte do nosso time!</p>
                </div>
            </div>
        </div>
        <form class="php-email-form" method="POST" action="envia.php" enctype="multipart/form-data">
          <fieldset>
            <?php
            if (isset($_GET['status'])) {
              if ($_GET['status'] == 'success') {
                echo '<div class="alert alert-success text-center" role="alert">Mensagem enviada com sucesso!</div>';
              } elseif ($_GET['status'] == 'invalid_file') {
                echo '<div class="alert alert-danger text-center" role="alert">Ocorreu um erro ao enviar a mensagem. Verifique se foi enviado um arquivo em PDF e tente novamente.</div>';
              }
            }
            ?>
            

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input id="nome" name="nome" type="text" class="form-control" placeholder="Informe seu nome" required>
              </div>
              <div class="col-md-6">
                <label for="replyto" class="form-label">Email</label>
                <input id="replyto" name="replyto" type="email" class="form-control" placeholder="Informe seu email" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                <label for="assunto" class="form-label">Vaga desejada</label>
                <input id="assunto" name="assunto" type="text" class="form-control" placeholder="Informe a vaga desejada" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                <label for="arquivo" class="form-label">Anexe seu currículo</label>
                <input id="arquivo" name="arquivo" type="file" class="form-control" accept="application/pdf" maxlength="2097152">
                <small class="form-text text-muted">Apenas arquivos PDF com até 2MB.</small>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea id="mensagem" name="mensagem" class="form-control" rows="5" placeholder="Digite sua mensagem"></textarea>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="concordo" name="concordo" required style="margin-right: 10px;">
                  <label class="form-check-label text-start" for="concordo">
                    De acordo com a lei 12.965/2014 e 13.709/2018, autorizo este site a enviar comunicações por e-mail ou qualquer outro meio e concordo com a sua política de privacidade.
                  </label>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
          </fieldset>
        </form>
      </div>
    </section>

  </main>

  <footer id="footer" class="footer light-background">
    <div class="footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6 footer-about">
            <a href="index.html" class="logo d-flex align-items-center">
              <span class="sitename">MDR</span>
            </a>
            <p>OAB/RN 502</p>
            <div class="social-links d-flex mt-3">
              <a href="https://www.facebook.com/marcosdelliribeiro" target="_blank"><i class="bi bi-facebook"></i></a>
              <a href="https://www.instagram.com/mdradvocacia/" target="_blank"><i class="bi bi-instagram"></i></a>
              <a href="https://www.linkedin.com/company/mdradvocacia/" target="_blank"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Links úteis</h4>
            <ul>
              <li><a href="index.html">Home</a></li>
              <li><a href="about.html">O escritório</a></li>
              <li><a href="services.html">Nossa atuação</a></li>
              <li><a href="trabalhe-conosco.html">Trabalhe conosco</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Nossos serviços</h4>
            <ul>
              <li><a href="service1.html">Direito Bancário</a></li>
              <li><a href="service2.html">Direito Regulatório</a></li>
              <li><a href="service3.html">Direito Fiscal e Tributário</a></li>
              <li><a href="service4.html">Comércio Internacional</a></li>
              <li><a href="service5.html">Planejamento Sucessório</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contate-nos</h4>
            <p><strong>Matriz:</strong> R. Des. José Gomes da Costa, 1975, Capim Macio, Natal</p>
            <p><strong>Filial:</strong> Av. Campos Sales, 901, Petrópolis, Natal Sala 1707</p>
            <p><strong>Telefone:</strong> 84 2139-9916</p>
            <p><strong>Whatsapp:</strong> 84 99996-0201</p>
            <p><strong>Email:</strong> contato@mdradvocacia.com</p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Encarregado de Dados Pessoais</h4>
            <p><strong>Nome:</strong> Ingrid Quirino Ribeiro</p>
            <p><strong>Email:</strong> dpo@mdradvocacia.com</p>
          </div>

        </div>
      </div>
    </div>

    <div class="container copyright text-center">
      <p>© <span>Copyright</span> <span>Todos os direitos reservados</span> <strong class="px-1 sitename">MDR</strong> - <a href="privacyPolicies.html">Políticas de privacidade</a></p>
      <div class="credits">
        Designed by <a href="https://mdradvocacia.com/" target="_blank">MDR Advocacia</a>
      </div>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <script src="assets/js/main.js"></script>

</body>

</html>