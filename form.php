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

/* Estilos para o menu 'Home / Diversidade' (Breadcrumbs) */
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
<main>
    <div class="page-title-video dark-background">
        <div class="video-overlay"></div>
        <video autoplay loop muted playsinline class="video-background">
          <source src="assets/video/trabalheconosco.mp4" type="video/mp4">
          Seu navegador não suporta vídeos em HTML5.
        </video>
        <div class="container">
            <h1>Trabalhe conosco</h1>
            <nav class="breadcrumbs">
              <ol>
                <li><a href="index.php">Home</a></li>
                <li class="current">Trabalhe conosco</li>
              </ol>
            </nav>
        </div>
    </div>

    <section class="contact-form-section section-bg">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="diversity-section-box p-4 mb-5" style="background-color: #f8f9fa; border-left: 5px solid var(--accent-color, #007bff);">
                        <h2 class="h4" style="color: var(--accent-color, #007bff);">Venha somar sua trajetória à nossa!</h2>
                        <p>Acreditamos que equipes formadas por pessoas com diferentes experiências, histórias e pontos de vista enriquecem nossa cultura, impulsionam a inovação e fortalecem o crescimento coletivo. Valorizamos a empatia, o respeito e a colaboração como pilares de um ambiente mais justo e inspirador.</p>
                        <p>Estamos com vagas abertas para todas as pessoas que compartilham desses valores — inclusive oportunidades afirmativas para pessoas negras, indígenas, LGBTQIAPN+, com deficiência e de outros grupos historicamente minorizados.</strong></p>
                        <p class="mb-0">Se você busca um lugar onde sua trajetória é valorizada e pode gerar impacto positivo, o nosso time é o seu lugar!</p>
                    </div>
                </div>
            </div>

            <form class="php-email-form" method="POST" action="envia.php" enctype="multipart/form-data">
                <fieldset>
                    <?php
                    if (isset($_GET['status'])) {
                      if ($_GET['status'] == 'success') {
                        echo '<div class="alert alert-success text-center" role="alert">Mensagem enviada com sucesso! Agradecemos o seu contato.</div>';
                      } elseif (isset($_GET['message'])) {
                        // Exibe uma mensagem de erro mais detalhada, se disponível
                        echo '<div class="alert alert-danger text-center" role="alert">Ocorreu um erro: ' . htmlspecialchars($_GET['message']) . '</div>';
                      } else {
                        echo '<div class="alert alert-danger text-center" role="alert">Ocorreu um erro ao enviar a mensagem. Verifique se o arquivo é um PDF de até 2MB e tente novamente.</div>';
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
                            <input id="arquivo" name="arquivo" type="file" class="form-control" accept="application/pdf">
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
                                    De acordo com a lei 12.965/2014 e 13.709/2018, autorizo este site a enviar comunicações por e-mail ou qualquer outro meio e concordo com a sua <a href="privacyPolicies.php" target="_blank">política de privacidade</a>.
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enviar Candidatura</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>