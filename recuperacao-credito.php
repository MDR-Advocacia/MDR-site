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
    .animar-ao-rolar { opacity: 0; transform: translateY(50px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
    .animar-ao-rolar.is-visible { opacity: 1; transform: translateY(0); }

    /* Estilos do Cabeçalho de Vídeo */
    .video-background-container { position: relative; overflow: hidden; padding: 150px 15px; color: white; text-align: center; }
    .video-background { position: absolute; top: 50%; left: 50%; width: 100%; height: 100%; object-fit: cover; transform: translate(-50%, -50%); opacity: 0.5; z-index: 1; }
    .video-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 2; }
    .video-foreground-content { position: relative; z-index: 3; }
    .video-foreground-content h2 { font-size: 42px; font-weight: bold; margin: 0; color: #FFFFFF; text-shadow: 2px 2px 4px rgba(0,0,0,0.6); }

    /* Estilos do Conteúdo */
    .section-content { padding: 50px 15px; }
    .intro-section { display: flex; align-items: center; gap: 40px; max-width: 1100px; margin: 50px auto; flex-wrap: wrap; }
    .intro-section .image-container { flex: 1; min-width: 300px; }
    .intro-section .image-container img { width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .intro-section .text-container { flex: 1.5; min-width: 300px; text-align: left; font-size: 16px; line-height: 1.7; }
    
    .methodology-title { text-align: center; font-size: 26px; font-weight: bold; margin-top: 60px; margin-bottom: 40px; }
    .methodology-grid { display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; max-width: 1100px; margin: 0 auto; }
    .methodology-item { flex: 1; min-width: 320px; max-width: 45%; padding: 30px; background-color: #f7f7f7; border-radius: 8px; border-top: 3px solid #b29d55; }

    /* Estilos dos Cards de Profissionais */
    .related-professionals-title { font-size: 20px; font-weight: normal; color: #555; margin-top: 70px; margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px; max-width: 1100px; margin-left: auto; margin-right: auto; }
    .professionals-grid { max-width: 1100px; margin: 0 auto; }
    .professional-card { display: flex; align-items: flex-start; gap: 30px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #b29d55; }
    .professional-card .profile-pic-container { flex-shrink: 0; display: flex; flex-direction: column; align-items: center; }
    .profile-image { width: 150px; height: 150px; object-fit: cover; margin-bottom: 10px; border-radius: 50%; }
    .ana-carolina-img { object-position: 20% 10%; }
    .denize-medeiros-img { object-position: 20% 10%; }
    .social-icons { display:flex; gap: 15px; }
    .professional-card-details { flex: 1; min-width: 300px; }
    .professional-card-details h4 { font-size: 24px; margin: 0 0 5px 0; }
    .professional-card-details .title { margin: 0; font-size: 16px; color: #555; font-weight: bold; }
    .professional-card-details .sector { margin: 5px 0 20px; font-size: 14px; color: #777; }
    .professional-card-details hr { border: 0.5px solid #b29d55; margin: 10px 0; }
    .contact-list { list-style: none; padding: 0; margin: 0; font-size: 14px; color: #555; }
    .contact-list li { display: flex; align-items: center; margin-bottom: 10px; }
    .contact-list span { color: #b29d55; margin-right: 10px; display: inline-flex; align-items: center; }
    .contact-list .icon-svg { width: 16px; height: 16px; fill: currentColor; }

    /* Botão para ver equipe completa */
    .team-button-container { text-align: center; margin-top: 40px; }
    .team-button { display: inline-block; padding: 12px 25px; background-color: #b29d55; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background-color 0.3s; }
    .team-button:hover { background-color: #9c8a4a; }
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
    <div class="video-background-container">
        <div class="video-overlay"></div>
        <video autoplay loop muted playsinline class="video-background">
          <source src="assets/video/video.MOV" type="video/mp4">
          Seu navegador não suporta vídeos em HTML5.
        </video>
        <div class="video-foreground-content">
          <h2 class="animar-ao-rolar">Recuperação de Crédito</h2>
        </div>
    </div>

    <div class="section-content">
      <div class="intro-section animar-ao-rolar">
        <div class="image-container">
            <img src="assets/img/supervisores/equiperec.jpg" alt="Equipe de Recuperação de Crédito">
        </div>
        <div class="text-container">
            <p>
                O núcleo de Recuperação de Crédito da MDR Advocacia é especializado em reaver ativos financeiros, transformando dívidas em liquidez de forma estratégica e segura. Compreendemos que a inadimplência é um desafio crítico que impacta diretamente o fluxo de caixa e a estabilidade do seu negócio.
            </p>
            <p>
                 Aliamos a expertise jurídica à <strong>tecnologia e análise de dados</strong>. Por meio de plataformas de gestão e Business Intelligence (BI), oferecemos aos nossos clientes dashboards para acompanhamento em tempo real dos indicadores de sucesso e do status de cada caso, garantindo total transparência e controle sobre o processo.
            </p>
            <p>
                Mais do que uma simples empresa de cobrança, atuamos como parceiros estratégicos do seu negócio. Nosso compromisso é com o resultado, recuperando seus ativos de forma ética e eficiente, enquanto protegemos o valor mais importante: <strong>a sua marca</strong>.
            </p>
        </div>
      </div>

      <h3 class="methodology-title animar-ao-rolar">Nossa Metodologia de Atuação</h3>
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

      <h3 class="related-professionals-title animar-ao-rolar">PROFISSIONAIS RELACIONADOS(AS)</h3>
      <div class="professionals-grid">
        
        <div class="professional-card animar-ao-rolar">
            <div class="profile-pic-container">
                <img src="assets/img/socios/natalia-perfil.jpg" alt="Natália Ribeiro Linhares" class="profile-image">
                <div class="social-icons">
                    <a href="https://www.linkedin.com/in/nat%C3%A1lia-linhares-a482b1267/" target="_blank" aria-label="LinkedIn de Natália Ribeiro Linhares"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"/></svg></a>
                    <a href="https://www.instagram.com/nataliarlinhares" target="_blank" aria-label="Instagram de Natália Ribeiro Linhares"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/></svg></a>
                    <a href="https://wa.me/558421399916" target="_blank" aria-label="Whatsapp de Natália Ribeiro Linhares"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"/></svg></a>
                </div>
            </div>
            <div class="professional-card-details">
                <h4>Natália Ribeiro Linhares</h4><hr>
                <p class="title">Sócia/Diretora</p>
                <ul class="contact-list">
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span> Natal / RN</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></span> natalia.linhares@mdradvocacia.com</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span> (84) 2139-9916</li>
                    
                </ul>
            </div>
        </div>
        <div class="professional-card animar-ao-rolar">
             <div class="profile-pic-container">
                <img src="assets/img/supervisores/diegoalves.jpg" alt="Diego Alves do Nascimento" class="profile-image">
                <div class="social-icons">
                     <a href="#" target="_blank" aria-label="LinkedIn de Diego Alves do Nascimento"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"/></svg></a>
                     <a href="#" target="_blank" aria-label="Instagram de Diego Alves do Nascimento"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/></svg></a>
                     <a href="https://wa.me/5584999252170" target="_blank" aria-label="Whatsapp de Diego Alves do Nascimento"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"/></svg></a>
                </div>
            </div>
            <div class="professional-card-details">
                <h4>Diego Alves do Nascimento</h4><hr>
                <p class="title">Coordenador</p>
                <p class="sector"></p>
                <ul class="contact-list">
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span> Natal / RN</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></span> Diego.nascimento@mdradvocacia.com</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span> (84) 99925-2170</li>
                </ul>
            </div>
        </div>

        <div class="professional-card animar-ao-rolar">
            <div class="profile-pic-container">
                <img src="assets/img/supervisores/anacarolina.jpg" alt="Ana Carolina Viana Nascimento" class="profile-image ana-carolina-img">
                <div class="social-icons">
                     <a href="https://www.linkedin.com/in/ana-carolina-viana-nascimento-15845a372/" target="_blank" aria-label="LinkedIn de Ana Carolina"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"/></svg></a>
                     <a href="https://www.instagram.com/carolinaviaana" target="_blank" aria-label="Instagram de Ana Carolina"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/></svg></a>
                     <a href="https://wa.me/5584994278869" target="_blank" aria-label="Whatsapp de Ana Carolina"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"/></svg></a>
                </div>
            </div>
            <div class="professional-card-details">
                <h4>Ana Carolina Viana Nascimento</h4><hr>
                <p class="title">Supervisora </p>
                <p class="sector">OAB/RN 20.664</p>
                <ul class="contact-list">
                     <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span> Natal / RN</li>
                     <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></span> ana.nascimento@mdradvocacia.com</li>
                     <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span> (84) 99427-8869</li>
                </ul>
            </div>
        </div>
        
        <div class="professional-card animar-ao-rolar">
             <div class="profile-pic-container">
                <img src="assets/img/supervisores/denizemedeiros.jpg" alt="Denize de Medeiros Silva" class="profile-image denize-medeiros-img">
                <div class="social-icons">
                    <a href="https://www.linkedin.com/in/denize-medeiros-512970225?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" target="_blank" aria-label="LinkedIn de Denize de Medeiros Silva"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"/></svg></a>
                    <a href="https://www.instagram.com/denizemedeirosadv" target="_blank" aria-label="Instagram de Denize de Medeiros Silva"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/></svg></a>
                    <a href="https://wa.me/5584991922986" target="_blank" aria-label="Whatsapp de Denize de Medeiros Silva"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"/></svg></a>
                </div>
            </div>
            <div class="professional-card-details">
                <h4>Denize de Medeiros Silva</h4><hr>
                <p class="title">Supervisora</p>
                <p class="sector"></p>
                <ul class="contact-list">
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span> Natal / RN</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></span> denize.medeiros@mdradvocacia.com</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span> (84) 99192-2986</li>
                </ul>
            </div>
        </div>

        <div class="professional-card animar-ao-rolar">
            <div class="profile-pic-container">
                <img src="assets/img/supervisores/placeholder.jpg" alt="João Vinícius Lucena Lopes" class="profile-image">
                <div class="social-icons">
                    <a href="https://www.linkedin.com/in/jo%C3%A3o-vin%C3%ADcius-lucena-lopes?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" target="_blank" aria-label="LinkedIn de João Vinícius Lucena Lopes"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"/></svg></a>
                    <a href="https://www.instagram.com/adv.joaoviniciuslopes?igsh=Mnd4anl6cmRjM2ox&utm_source=qr" target="_blank" aria-label="Instagram de João Vinícius Lucena Lopes"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/></svg></a>
                    <a href="#" target="_blank" aria-label="Whatsapp de João Vinícius Lucena Lopes"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"/></svg></a>
                </div>
            </div>
            <div class="professional-card-details">
                <h4>João Vinícius Lucena Lopes</h4><hr>
                <p class="title">Supervisor</p>
                <p class="sector">OAB/RN 19.876</p>
                <ul class="contact-list">
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span> Natal / RN</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></span> joao.lopes@mdradvocacia.com</li>
                </ul>
            </div>
        </div>
                <div class="professional-card animar-ao-rolar">
            <div class="profile-pic-container">
                <img src="assets/img/supervisores/placeholder.jpg" alt="Melissa" class="profile-image">
                <div class="social-icons">
                    <a href="https://www.linkedin.com/in/melissa-oliveira-191440347/" target="_blank" aria-label="LinkedIn de Melissa"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"/></svg></a>
                    <a href="https://www.instagram.com/mel_oliveiraadv" target="_blank" aria-label="Instagram de Melissa"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/></svg></a>
                    <a href="https://wa.me/5584999283737" target="_blank" aria-label="Whatsapp de Melissa"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"/></svg></a>
                </div>
            </div>
            <div class="professional-card-details">
                <h4>Melissa Cristine de Oliveira e Santos</h4><hr>
                <p class="title">Supervisora</p>
                <p class="sector">OAB/RN 22.188 </p>
                <ul class="contact-list">
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span> Natal / RN</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></span>melissa.santos@mdradvocacia.com</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span>(84) 99928-3737</li>
                </ul>
            </div>
        </div>

        <div class="professional-card animar-ao-rolar">
            <div class="profile-pic-container">
                <img src="assets/img/supervisores/placeholder.jpg" alt="Sthéfanie de Melo Medeiros Queiroz" class="profile-image">
                <div class="social-icons">
                    <a href="https://www.linkedin.com/in/sthefaniequeiroz" target="_blank" aria-label="LinkedIn de Sthéfanie de Melo"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-3.06v8.37h3.06v-4.93c0-.83.06-1.66.57-2.12.51-.46 1.28-.48 1.76 0 .5.47.48 1.3.48 2.12v4.93h3.06zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69.75 1.68 1.68 0 0 0 0 1.88 1.68 1.68 0 0 0 1.69.74zm-1.44 9.94h3.06v-8.37H5.44v8.37z"/></svg></a>
                    <a href="https://www.instagram.com/sthefaniequeiroz/" target="_blank" aria-label="Instagram de Sthéfanie de Melo"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z"/></svg></a>
                    <a href="https://wa.me/5584996460533" target="_blank" aria-label="Whatsapp de Sthéfanie de Melo"><svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: #555;"><path d="M16.75,13.96C17.0,14.21 17.2,14.5 17.2,14.86C17.2,15.22 17.05,15.57 16.8,15.82C16.55,16.07 16.21,16.22 15.85,16.22C15.31,16.22 13.8,15.77 12.04,14.22C10,12.41 8.7,10.27 8.7,9.81C8.7,9.35 8.85,9 9.1,8.75C9.35,8.5 9.6,8.35 9.96,8.35C10.32,8.35 10.6,8.5 10.85,8.75C11.1,9 11.3,9.29 11.3,9.65C11.3,10.01 11.15,10.36 10.9,10.61L10.5,11.01C10.3,11.21 10.11,11.4 10.35,11.65C10.59,11.9 11.23,12.54 11.96,13.27C12.91,14.22 13.54,14.58 13.9,14.58C14.26,14.58 14.5,14.38 14.7,14.18L15.1,13.78C15.35,13.53 15.7,13.38 16.06,13.38C16.42,13.38 16.77,13.53 17.02,13.78L17.47,14.23C17.22,14.48 16.97,14.73 16.75,13.96M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4Z"/></svg></a>
                </div>
            </div>
            <div class="professional-card-details">
                <h4>Sthéfanie de Melo Medeiros Queiroz</h4><hr>
                <p class="title">Supervisora</p>
                <p class="sector">OAB/RN 20.347</p>
                <ul class="contact-list">
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg></span> Natal / RN</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></span> sthefanie.queiroz@mdradvocacia.com</li>
                    <li><span><svg class="icon-svg" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg></span>(84) 99646-0533</li>
                </ul>
            </div>
        </div>

      </div>

      <div class="team-button-container animar-ao-rolar">
        <a href="equipe-recuperacao-credito.php" class="team-button">Ver Equipe Completa</a>
      </div>

    </div>
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
    document.addEventListener('DOMContentLoaded', () => {
        const elementsToAnimate = document.querySelectorAll('.animar-ao-rolar');
        if (elementsToAnimate.length === 0) return;
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('is-visible');
              observer.unobserve(entry.target);
            }
          });
        }, { threshold: 0.1 });
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