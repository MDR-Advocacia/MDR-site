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

<main class="main">

    <div class="page-title dark-background" data-aos="fade" >
      <div class="container">
        <h1>Políticas de Privacidade</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Políticas de Privacidade</li>
          </ol>
        </nav>
      </div>
    </div>
    <section id="privacy-policies" class="about section">
        <div class="container">
            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-8 text-center">
                    <div class="content">
                        <h3>Políticas de privacidade</h3>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span>O site do escritório MDR Advocacia adota práticas rigorosas para garantir a proteção de dados pessoais e sensíveis, em conformidade com a Lei Geral de Proteção de Dados (LGPD). Em cumprimento ao disposto em seu art. 6º, o tratamento das informações fornecidas, é realizado com base nos princípios da transparência, segurança e finalidade, assegurando que os dados sejam utilizados exclusivamente para os propósitos previamente informados.</span>
                            </li>
                            <li class="mb-3">
                                <span>Em conformidade com o art. 7º, os dados fornecidos são tratados com o consentimento do titular ou nas hipóteses autorizadas pela legislação, sendo o escritório responsável por garantir o uso adequado e proporcional das informações. Adicionalmente, são adotadas medidas técnicas e organizacionais, conforme previsto no art. 46, para proteger os dados contra acessos não autorizados, perdas ou vazamentos.</span>
                            </li>
                            <li class="mb-3">
                                <span>De acordo com o art. 15, as informações coletadas serão descartadas de forma segura e eficaz assim que atingirem a finalidade para a qual foram obtidas, ou em caso de revogação do consentimento por parte do titular, conforme garantido pelo art. 18.</span>
                            </li>
                            <li>
                                <span>O MDR Advocacia reforça seu compromisso com a privacidade e segurança dos dados e permanece à disposição para fornecer informações adicionais sobre as práticas adotadas.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>

<?php include 'footer.php'; ?>