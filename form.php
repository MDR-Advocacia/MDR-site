<?php include 'header.php'; ?>

<main class="main">

    <div class="page-title dark-background" data-aos="fade" >
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
                    <div class="diversity-section-box p-4 mb-5" style="background-color: #f8f9fa; border-left: 5px solid #b29d55;">
                        <h2 class="h4" style="color: #b29d55;">Venha somar sua trajetória à nossa!</h2>
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
