<?php 
  include 'header.php'; 
?>

<style>
@keyframes riseUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
.page-title-video {
    position: relative;
    overflow: hidden;
    height: 60vh;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
.video-background {
    position: absolute; top: 50%; left: 50%;
    min-width: 100%; min-height: 100%;
    width: auto; height: auto;
    object-fit: cover;
    transform: translate(-50%, -50%);
    z-index: 1;
}
.video-overlay {
    position: absolute; top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 2;
}
.page-title-video .container {
    position: relative;
    z-index: 3;
}
.page-title-video h1 {
    font-size: 48px;
    font-weight: bold;
    color: #FFFFFF;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
    animation: riseUp 1s ease-out forwards;
}
.page-title-video .breadcrumbs ol {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    list-style: none;
    padding: 0;
    margin-top: 10px;
    color: rgba(255, 255, 255, 0.8);
    animation: riseUp 1s ease-out 0.2s forwards;
    opacity: 0;
}
.page-title-video .breadcrumbs ol li+li { padding-left: 10px; }
.page-title-video .breadcrumbs ol li+li::before { content: "/"; display: inline-block; padding-right: 10px; color: rgba(255, 255, 255, 0.8); }
.page-title-video .breadcrumbs a { color: rgba(255, 255, 255, 0.9); text-decoration: none; transition: 0.3s; }
.page-title-video .breadcrumbs a:hover { color: #fff; }
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        color: #333;
        margin: 0;
        background-color: #fff;
    }
    /* Estilos da Animação ao Rolar */
    .animar-ao-rolar { 
        opacity: 0; 
        transform: translateY(50px); 
        transition: opacity 0.8s ease-out, transform 0.8s ease-out; 
    }
    .animar-ao-rolar.is-visible { 
        opacity: 1; 
        transform: translateY(0); 
    }

    /* --- ESTILOS DO CABEÇALHO COM VÍDEO --- */
    .video-header-container {
      position: relative;
      overflow: hidden;
      padding: 120px 15px; /* Padding um pouco menor para um cabeçalho de página interna */
      color: white;
      text-align: center;
    }
    .video-background {
      position: absolute;
      top: 50%; left: 50%;
      min-width: 100%; min-height: 100%;
      width: auto; height: auto;
      object-fit: cover;
      transform: translate(-50%, -50%);
      z-index: 1;
    }
    .video-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Overlay um pouco mais escuro */
        z-index: 2;
    }
    .video-header-content {
      position: relative;
      z-index: 3;
    }
    .video-header-content h1 {
      font-size: 36px;
      margin-bottom: 10px;
      font-weight: bold;
      color: #fff;
      text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }
    .video-header-content p {
      font-size: 18px;
      color: rgba(255, 255, 255, 0.9);
      max-width: 800px;
      margin: 0 auto;
    }
    /* --- FIM DOS ESTILOS DO CABEÇALHO --- */

    .team-section { padding: 60px 15px; }
    .team-section h2 { text-align: center; font-size: 28px; margin-bottom: 40px; color: #333; border-bottom: 2px solid #b29d55; padding-bottom: 10px; display: inline-block; }
    .section-title-wrapper { text-align: center; margin-bottom: 50px; }

    .team-grid {
    display: flex; /* Mudar de 'grid' para 'flex' */
    flex-wrap: wrap; /* Permitir que os itens quebrem a linha */
    justify-content: center; /* Centralizar os itens na linha */
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
} 


    .collaborator-card {
    flex-basis: 250px; /* Define a largura base do card */
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    text-align: center;
    padding: 20px;
    transition: transform 0.3s, box-shadow 0.3s;
}
    .collaborator-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
    .collaborator-card img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid #eee; }
    .collaborator-card h5 { margin: 10px 0 5px 0; font-size: 17px; }
    .collaborator-card p { margin: 0; color: #b29d55; font-weight: bold; }
    /* --- Estilo do Botão Flutuante do WhatsApp --- */
.floating-whatsapp {
    position: fixed;
    bottom: 70px;
    right: 25px;
    background-color: #25D366;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
    z-index: 1000;
    transition: transform 0.3s;
}
.floating-whatsapp:hover {
    color: white;
    transform: scale(1.1);
}
/* --- Estilo da Seção Final de Contato --- */
.contact-section {
    background-color: #f8f9fa;
    padding: 60px 15px;
    text-align: center;
}
.contact-section h2 {
    font-size: 28px;
    margin-bottom: 40px;
}
.contact-options {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}
.contact-option {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    width: 300px;
    text-align: center;
}
.contact-option i {
    font-size: 40px;
    color: #b29d55;
    margin-bottom: 15px;
}
.contact-option h4 {
    font-size: 20px;
    margin-bottom: 10px;
}
.contact-option p {
    color: #6c757d;
    margin-bottom: 20px;
}
.contact-option a.btn {
    text-decoration: none;
    padding: 10px 20px;
    background-color: #b29d55;
    color: white;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s;
}
.contact-option a.btn:hover {
    background-color: #9c8a4a;
}
</style>

<main>
    <div class="video-header-container">
        <div class="video-overlay"></div>
        <video autoplay loop muted playsinline class="video-background">
          <source src="assets/video/recuperacaodecredito.mp4" type="video/mp4">
          Seu navegador não suporta vídeos em HTML5.
        </video>
        <div class="video-header-content animar-ao-rolar">
            <h1>Nossa Equipe de Recuperação de Crédito</h1>

        </div>
    </div>

<section class="team-section">
    <div class="section-title-wrapper animar-ao-rolar"><h2>Conheça Nosso Time:</h2></div>
    <div class="team-grid">

        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/aléxia.png" alt="Aléxia Marinne Maia Fernandes">
            <h5>Aléxia Marinne Maia Fernandes</h5>
            <p>Assistente Jurídica</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/alexandre.png" alt="Alexandre Victor da Silva Lima">
            <h5>Alexandre Victor da Silva Lima</h5>
            <p>Assistente Jurídico</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/állan.png" alt="Állan Daniel Torres Soares">
            <h5>Állan Daniel Torres Soares</h5>
            <p>Assistente Jurídico</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/andriely.png" alt="ANDRIELLY DUARTE DE FARIAS">
            <h5>Andrielly Duarte De Farias</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 22.864</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/arlisson.png" alt="Arlisson Pereira da Silva">
            <h5>Arlisson Pereira da Silva</h5>
            <p>Advogado</p>
            <p class="sector">OAB/RN 21.965</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/brigida.png" alt="Brígida Brenda Faustino de Oliveira">
            <h5>Brígida Brenda Faustino de Oliveira</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 22.086</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/debora.png" alt="Débora Regina Azevedo de Oliveira">
            <h5>Débora Regina Azevedo de Oliveira</h5>
            <p>Estagiária</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/negociador/eliezer.png" alt="Eliezer Nascimento de Souza">
            <h5>Eliezer Nascimento de Souza</h5>
            <p>Negociador</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/felipa.jpg" alt="Felipa Galvão da Mota Liz Saraiva">
            <h5>Felipa Galvão da Mota Liz Saraiva</h5>
            <p>Assistente Jurídica</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/gustavo.png" alt="Gustavo Silva Abdias">
            <h5>Gustavo Silva Abdias</h5>
            <p>Assistente Jurídico</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/jose leonardo.png" alt="José Leonardo de Araújo Jales">
            <h5>José Leonardo de Araújo Jales</h5>
            <p>Advogado</p>
            <p class="sector">OAB/RN 21.259</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/leticia.png" alt="Letícia Fortunato de Sousa">
            <h5>Letícia Fortunato de Sousa</h5>
            <p>Estagiária</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/luana.png" alt="Luana de Araujo">
            <h5>Luana de Araújo Alvez</h5>
            <p>Assistente Jurídica</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/luizeduardo.png" alt="Luiz Eduardo Oliveira da Silva">
            <h5>Luiz Eduardo Oliveira da Silva</h5>
            <p>Estagiário</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/marcelli.png" alt="Marcelli Gomes do Nascimento">
            <h5>Marcelli Gomes do Nascimento</h5>
            <p>Assistente Jurídica</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/marcos vinicius.png" alt="Marcos Vinícius Cruz Bezerra">
            <h5>Marcos Vinícius Cruz Bezerra</h5>
            <p>Advogado</p>
            <p class="sector">OAB/RN 23.235</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/marcus.png" alt="Marcus vinícius Fernandes Gomes">
            <h5>Marcus Vinícius Fernandes Gomes</h5>
            <p>Assistente Jurídico</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/mariaeduarda.png" alt="Maria Eduarda Guedes Cavalcante">
            <h5>Maria Eduarda Guedes Cavalcante</h5>
            <p>Estagiária</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/maria gabrielly.png" alt="Maria Gabrielly Silva Rodrigues Azevedo">
            <h5>Maria Gabrielly S. R. Azevedo</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 21.601</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/maria laiza.png" alt="Maria Laiza Barbosa de Farias">
            <h5>Maria Laiza Barbosa de Farias</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 22.986</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/maria victoria.png" alt="Maria Victoria Pereira Dantas">
            <h5>Maria Victoria Pereira Dantas</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 23.467</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/mariliagabriela.png" alt="Marília Gabriela Andrade Freitas">
            <h5>Marília Gabriela Andrade Freitas</h5>
            <p>Estagiária</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/mateusbrito.png" alt="Mateus Rodrigues de Brito">
            <h5>Mateus Rodrigues de Brito</h5>
            <p>Estagiário</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/nayara.png" alt="Nayara de Souza Xavier">
            <h5>Nayara de Souza Xavier</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 18.481</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/pauloreis.png" alt="Paulo Fernando Cisneiros Da Costa Reis Neto">
            <h5>Paulo Fernando C. C. Reis Neto</h5>
            <p>Estagiário</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/pauloalmeida.png" alt="PAULO GUILHERME MORAIS DE ALMEIDA">
            <h5>Paulo Guilherme Morais De Almeida</h5>
            <p>Estagiário</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/assistentes j/rafael.png" alt="Rafael Sampaio Bezerra">
            <h5>Rafael Sampaio Bezerra</h5>
            <p>Assistente Jurídico</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/suenia.png" alt="SUENIA BEATRIZ LIMA DE CARVALHO DA SILVA">
            <h5>Suenia Beatriz L. C. Da Silva</h5>
            <p>Estagiária</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/estagiários(as)/suemy.png" alt="Suemy Medeiros Ferreira">
            <h5>Suemy Medeiros Ferreira</h5>
            <p>Estagiária</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/tathianna.png" alt="Tathianna Ribeiro da Silva Lemos">
            <h5>Tathianna Ribeiro da Silva Lemos</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 20.475</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/thaise.png" alt="Thaise de Bessa da Silva">
            <h5>Thaise de Bessa da Silva</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 21.981</p>
        </div>
        <div class="collaborator-card animar-ao-rolar">
            <img src="assets/img/colaboradores/advogados/vitoria.png" alt="Vitória Machado Domingo">
            <h5>Vitória Machado Domingo</h5>
            <p>Advogada</p>
            <p class="sector">OAB/RN 22.021</p>
        </div>

    </div>
</section>
    <section class="contact-section animar-ao-rolar">
    <div class="container">
        <h2>Negocie Conosco!</h2>
        <div class="contact-options">
            
            <div class="contact-option">
                <i class="bi bi-star-fill"></i>
                <h4>Avalie nosso Serviço</h4>
                <p>Sua opinião é muito importante para nós. Deixe sua avaliação em nosso perfil.</p>
                <a href="https://www.google.com/search?sca_esv=32c31fc24eb89b34&rlz=1C1GCEA_enPT1135PT1135&sxsrf=AE3TifPR4lhxsfuvSnmozsHvQ_pDWh1j8Q:1756657942305&si=AMgyJEtREmoPL4P1I5IDCfuA8gybfVI2d5Uj7QMwYCZHKDZ-E-vnwCiwgI-u81x6nLn-Eyg9RHUslCRLo6HRkLKj9k5coeLE2jeVyNqibBV3RE1FzbGTMKEo9K0FyjNdIkjS3TaiHfIIscX_L8sWKXWIIusRYYe8Jw%3D%3D&q=MDR+ADVOCACIA+Coment%C3%A1rios&sa=X&ved=2ahUKEwiQkJLlvLWPAxV-r5UCHaINGs8Q0bkNegQIKhAE&biw=1280&bih=585&dpr=1.5#lrd=0x7b2ff467975d4b5:0x46d31a58d103d69a,3,,,," class="btn" target="_blank">Deixar Avaliação</a>
            </div>

            <div class="contact-option">
                <i class="bi bi-envelope-fill"></i>
                <h4>Contato por E-mail</h4>
                <p>Envie suas dúvidas ou solicitações para nosso e-mail de contato geral.</p>
                <a href="mailto:contato@mdradvocacia.com" class="btn">Enviar E-mail</a>
            </div>

            <div class="contact-option">
                <i class="bi bi-whatsapp"></i>
                <h4>WhatsApp Geral</h4>
                <p>Prefere um contato mais rápido? Fale com nossa equipe pelo WhatsApp.</p>
                <a href="https://wa.me/5584999960201" class="btn" target="_blank">Iniciar Conversa</a>
            </div>

        </div>
    </div>
</section>

</main>

<script>
    // Script para animação de scroll
    document.addEventListener('DOMContentLoaded', () => {
        const elementsToAnimate = document.querySelectorAll('.animar-ao-rolar');
        if (elementsToAnimate.length === 0) return;
        
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              // Para que a animação ocorra apenas uma vez, descomente a linha abaixo:
              // observer.unobserve(entry.target); 
            } else {
              // Opcional: Para a animação repetir toda vez que sair e entrar na tela
              // entry.target.classList.remove('is-visible');
            }
          });
        }, {
          threshold: 0.1 // Começa a animar quando 10% do elemento está visível
        });

        elementsToAnimate.forEach(element => {
          observer.observe(element);
        });
    });
</script>
<a href="https://wa.me/5584000000000" class="floating-whatsapp" target="_blank" aria-label="Fale conosco pelo WhatsApp">
    <i class="bi bi-whatsapp"></i>
</a>
<?php 
  include 'footer.php'; 

?>
