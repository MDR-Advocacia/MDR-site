<?php 
  include 'header.php'; 
?>

<style>
    /* Estilos Gerais */
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        color: #333;
        margin: 0;
        background-color: #fff;
    }

    /* --- CSS PARA ANIMAÇÃO DE SCROLL --- */
    .animar-ao-rolar {
      opacity: 0;
      transform: translateY(50px);
      transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    .animar-ao-rolar.is-visible {
      opacity: 1;
      transform: translateY(0);
    }
    /* --- FIM DO CSS DE ANIMAÇÃO --- */

    /* Estilos para a Seção com Fundo de Vídeo */
    .video-background-container {
      position: relative;
      overflow: hidden;
      padding: 150px 15px;
      color: white;
      text-align: center;
    }
    .video-background {
      position: absolute;
      top: 50%; left: 50%;
      width: 100%; height: 100%;
      object-fit: cover;
      transform: translate(-50%, -50%);
      opacity: 0.5;
      z-index: 1;
    }
    .video-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2;
    }
    .video-foreground-content {
      position: relative;
      z-index: 3;
    }
    .video-foreground-content h2 {
      font-size: 42px;
      font-weight: bold;
      margin: 0;
      color: #FFFFFF;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.6);
    }

    /* Estilos para o restante da página */
    .section-content {
      padding: 50px 15px;
    }
    .intro-paragraph {
      text-align: center; 
      max-width: 800px; 
      margin: 50px auto; 
      font-size: 16px; 
      line-height: 1.7;
    }
    .methodology-title {
      text-align: center;
      font-size: 26px;
      font-weight: bold;
      margin-top: 60px;
      margin-bottom: 40px;
    }
    .methodology-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
      max-width: 1100px;
      margin: 0 auto;
    }
    .methodology-item {
      flex: 1;
      min-width: 320px;
      max-width: 45%;
      padding: 30px;
      background-color: #f7f7f7;
      border-radius: 8px;
      border-top: 3px solid #b29d55;
    }
    .related-professionals-title {
      font-size: 20px;
      font-weight: normal;
      color: #555;
      margin-top: 70px;
      margin-bottom: 40px;
      border-bottom: 1px solid #eee;
      padding-bottom: 20px;
      max-width: 1100px;
      margin-left: auto;
      margin-right: auto;
    }
    .professionals-grid {
      max-width: 1100px;
      margin: 0 auto;
    }
</style>

<main>
    <div class="video-background-container">
        <div class="video-overlay"></div>
        <video autoplay loop muted class="video-background">
          <source src="assets/video/video.MOV" type="video/mp4">
          Seu navegador não suporta vídeos em HTML5.
        </video>
        <div class="video-foreground-content">
          <h2 class="animar-ao-rolar">Recuperação de Crédito</h2>
        </div>
    </div>

    <div class="section-content">
      <p class="intro-paragraph animar-ao-rolar">
        Nosso núcleo de Recuperação de Crédito é focado em restaurar a saúde financeira de nossos clientes com segurança, ética e máxima eficiência. Desenvolvemos estratégias personalizadas que vão além da simples cobrança, preservando o relacionamento entre sua empresa e seus clientes.
      </p>

      <h3 class="methodology-title animar-ao-rolar">
        Nossa Metodologia de Atuação
      </h3>

      <div class="methodology-grid">
        <div class="methodology-item animar-ao-rolar">
          <h4 style="font-size: 20px; margin-top: 0; margin-bottom: 15px; color: #333;">Atuação Extrajudicial</h4>
          <p style="font-size: 15px; line-height: 1.6;">Priorizamos a resolução de conflitos de forma amigável. Utilizamos ferramentas de comunicação e negociação para alcançar acordos vantajosos, evitando o desgaste e os custos de um processo judicial.</p>
        </div>
        <div class="methodology-item animar-ao-rolar">
          <h4 style="font-size: 20px; margin-top: 0; margin-bottom: 15px; color: #333;">Atuação Judicial</h4>
          <p style="font-size: 15px; line-height: 1.6;">Quando a via amigável se esgota, nossa equipe jurídica atua com as medidas judiciais cabíveis, incluindo a busca proativa por patrimônio para garantir o recebimento do crédito.</p>
        </div>
      </div>

      <h3 class="related-professionals-title animar-ao-rolar">
        PROFISSIONAIS RELACIONADOS(AS)
      </h3>

      <div class="professionals-grid">
        
        <div class="animar-ao-rolar" style="display: flex; align-items: flex-start; gap: 30px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #b29d55;">
            <div style="flex-shrink: 0; display: flex; flex-direction: column; align-items: center;">
                <img src="assets/img/socios/natalia-perfil.jpg" alt="Natália Ribeiro Linhares" style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 10px;">
                <div style="display:flex; gap: 10px;">
                    <a href="https://www.linkedin.com/in/nat%C3%A1lia-linhares-a482b1267/" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"></path></svg></a>
                    <a href="https://www.instagram.com/nataliarlinhares" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"></path></svg></a>
                    <a href="https://wa.me/558421399916" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"></path></svg></a>
                </div>
            </div>
            <div style="flex: 1; min-width: 300px;">
                <h4 style="font-size: 24px; margin: 0 0 10px 0;">Natália Ribeiro Linhares</h4>
                <hr style="border: 0.5px solid #b29d55; margin: 0 0 10px 0;">
                <p style="margin: 0; font-size: 16px; color: #555;">Sócia</p>
                <p style="margin: 5px 0 20px; font-size: 14px; color: #777;">Recuperação de Crédito</p>
                <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: #555;">
                    <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg></span> Natal / RN</li>
                    <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path></svg></span> (84) 2139-9916</li>
                    <li style="display: flex; align-items: center;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg></span> natalia.linhares@mdradvocacia.com</li>
                </ul>
            </div>
      </div>
      
      <div class="animar-ao-rolar" style="display: flex; align-items: flex-start; gap: 30px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #b29d55;">
          <div style="flex-shrink: 0; display: flex; flex-direction: column; align-items: center;">
              <img src="assets/img/supervisores/anacarolina.jpg" alt="Ana Carolina Viana Nascimento" style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 10px;">
              <div style="display:flex; gap: 10px;">
                  <a href="https://www.linkedin.com/in/ana-carolina-viana-nascimento-15845a372/" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"></path></svg></a>
                  <a href="https://www.instagram.com/carolinaviaana" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"></path></svg></a>
                  <a href="https://wa.me/5584991922986" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"></path></svg></a>
              </div>
          </div>
          <div style="flex: 1; min-width: 300px;">
              <h4 style="font-size: 24px; margin: 0 0 10px 0;">Ana Carolina Viana Nascimento</h4>
              <hr style="border: 0.5px solid #b29d55; margin: 0 0 10px 0;">
              <p style="margin: 0; font-size: 16px; color: #555;">Supervisora</p>
              <p style="margin: 5px 0 20px; font-size: 14px; color: #777;">Recuperação de Crédito - Recursal</p>
              <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: #555;">
                  <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg></span> Natal / RN</li>
                  <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path></svg></span> (84) 99192-2986</li>
                  <li style="display: flex; align-items: center;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg></span> ana.nascimento@mdradvocacia.com</li>
              </ul>
          </div>
      </div>

      <div class="animar-ao-rolar" style="display: flex; align-items: flex-start; gap: 30px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #b29d55;">
          <div style="flex-shrink: 0; display: flex; flex-direction: column; align-items: center;">
              <img src="assets/img/supervisores/denizemedeiros.jpg" alt="Denize de Medeiros Silva" style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 10px;">
              <div style="display:flex; gap: 10px;">
                  <a href="https://www.linkedin.com/in/denize-medeiros-512970225/" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"></path></svg></a>
                  <a href="https://www.instagram.com/denizemedeirosadv" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"></path></svg></a>
                  <a href="https://wa.me/5584991922986" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"></path></svg></a>
              </div>
          </div>
          <div style="flex: 1; min-width: 300px;">
              <h4 style="font-size: 24px; margin: 0 0 10px 0;">Denize de Medeiros Silva</h4>
              <hr style="border: 0.5px solid #b29d55; margin: 0 0 10px 0;">
              <p style="margin: 0; font-size: 16px; color: #555;">Supervisora</p>
              <p style="margin: 5px 0 20px; font-size: 14px; color: #777;">NEGOCIAL BANCO DO BRASIL</p>
              <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: #555;">
                  <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg></span> Natal / RN</li>
                  <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path></svg></span> (84) 99192-2986</li>
                  <li style="display: flex; align-items: center;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg></span> denize.medeiros@mdradvocacia.com</li>
              </ul>
          </div>
      </div>
      
      <div class="animar-ao-rolar" style="display: flex; align-items: flex-start; gap: 30px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #b29d55;">
          <div style="flex-shrink: 0; display: flex; flex-direction: column; align-items: center;">
              <img src="assets/img/supervisores/diegoalves.jpg" alt="Diego Alves Nascimento" style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 10px;">
              <div style="display:flex; gap: 10px;">
                  <a href="#" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"></path></svg></a>
                  <a href="#" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"></path></svg></a>
                  <a href="https://wa.me/5584999990003" target="_blank" style="text-decoration: none; display: inline-block;"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"></path></svg></a>
              </div>
          </div>
          <div style="flex: 1; min-width: 300px;">
              <h4 style="font-size: 24px; margin: 0 0 10px 0;">Diego Alves Nascimento</h4>
              <hr style="border: 0.5px solid #b29d55; margin: 0 0 10px 0;">
              <p style="margin: 0; font-size: 16px; color: #555;">Coordenador</p>
              <p style="margin: 5px 0 20px; font-size: 14px; color: #777;">Gestão de Risco</p>
              <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; color: #555;">
                  <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg></span> Natal / RN</li>
                  <li style="display: flex; align-items: center; margin-bottom: 10px;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"></path></svg></span> (84) 99999-0003</li>
                  <li style="display: flex; align-items: center;"><span style="color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center;"><svg viewBox="0 0 24 24" style="width: 16px; height: 16px; flex-shrink: 0; fill: currentColor;"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg></span> diego.nascimento@mdradvocacia.com</li>
              </ul>
          </div>
      </div>
      
    </div>
  </div>

</main>

<script>
    // Script para animação de scroll
    document.addEventListener('DOMContentLoaded', () => {
        // Removemos a chamada para typewriterEffect()
        
        const elementsToAnimate = document.querySelectorAll('.animar-ao-rolar');
        if (elementsToAnimate.length === 0) return;
        
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              observer.unobserve(entry.target);
            }
          });
        }, {
          threshold: 0.1
        });

        elementsToAnimate.forEach(element => {
          observer.observe(element);
        });
    });
</script>

<?php 
  include 'footer.php'; 
?>