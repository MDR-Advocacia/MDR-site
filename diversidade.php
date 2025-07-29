<?php include 'header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
  /* ====== INÍCIO DOS AJUSTES DE FONTE E COR ====== */
  #diversidade .section-title,
  #diversidade .subsection-title,
  #diversidade .pillar h3,
  #diversidade .member-card h4 {
      font-family: 'Montserrat', sans-serif; /* Fonte para títulos */
      font-weight: 700;
      color: #1b2f45;
  }

  #diversidade p {
      font-family: 'Roboto', sans-serif; /* Fonte para parágrafos */
      color: #555555;
  }
  
  .btn-brand {
    font-family: 'Montserrat', sans-serif; /* Fonte para o botão */
    background-color: #c5b358;
    color: #ffffff;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }
  /* ====== FIM DOS AJUSTES DE FONTE E COR ====== */

  .diversity-intro-image { text-align: center; margin: 2rem 0 4rem 0; }
  .diversity-intro-image img { max-width: 450px; width: 100%; }
  .pillar { display: flex; flex-direction: column; align-items: center; text-align: center; height: 100%; padding-bottom: 1.5rem; }
  .pillar p { flex-grow: 1; }
  .pillar-image { width: 100%; max-width: 250px; height: auto; border-radius: 8px; margin-top: 1.5rem; }
  .pillar i { font-size: 3rem; color: #c5b358; margin-bottom: 1rem; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; }
  .diversity-pillars { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; text-align: center; }
  .subsection-title { text-align: center; margin-top: 4rem; margin-bottom: 2rem; }
  .committee-members { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; justify-content: center; }
  .member-card { background: #fff; border: 1px solid #eee; border-radius: 8px; text-align: center; padding: 1.5rem; transition: transform 0.3s ease, box-shadow 0.3s ease; }
  .member-card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
  .member-card img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; border: 3px solid #c5b358; }
  .watch-video-container {text-align: center;margin: 2rem 0;}
  .btn-brand:hover {color: #ffffff;transform: translateY(-3px);box-shadow: 0 6px 20px rgba(197, 179, 88, 0.4);}
  .btn-brand i {font-size: 1.5rem;margin-right: 10px;}
</style>

<div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/diversidade/back-diversity.jpg);">
  <div class="container">
    <h1>Comitê de Diversidade</h1>
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
        <h2 class="section-title">Nossa Cultura de Diversidade e Inclusão</h2>
        <p style="max-width: 800px; margin: 0 auto 2rem auto;">
            Acreditamos que um ambiente plural enriquece nossas perspectivas e fortalece nossa capacidade de inovar e entregar soluções jurídicas de excelência.
        </p>
        <div class="watch-video-container">
          <a href="https://youtu.be/hqCj1MFdeBA" class="glightbox btn-brand"><i class="bi bi-play-circle-fill"></i><span>Assista ao vídeo</span></a>
        </div>
        <div class="diversity-intro-image">
            <img src="assets/img/diversidade/23.png" alt="Ilustração sobre igualdade racial" class="pillar-image">
        </div>
    </div>

    <div class="diversity-pillars" data-aos="fade-up" data-aos-delay="100">
      <div class="pillar">
          <i class="fas fa-venus-mars"></i>
          <h3>Equidade de Gênero</h3>
          <p>Promovemos a igualdade de oportunidades e o desenvolvimento de lideranças femininas.</p>
          <img src="assets/img/diversidade/21.png" alt="Ilustração sobre equidade de gênero" class="pillar-image">
      </div>
      <div class="pillar">
          <i class="fas fa-hands-helping"></i>
          <h3>Igualdade Racial</h3>
          <p>Combatemos o racismo estrutural com ações afirmativas e letramento contínuo.</p>
          <img src="assets/img/diversidade/25.png" alt="Ilustração sobre igualdade racial" class="pillar-image">
      </div>
      <div class="pillar">
          <i class="fas fa-heart"></i>
          <h3>Inclusão LGBTQIA+</h3>
          <p>Garantimos um ambiente de trabalho seguro, acolhedor e respeitoso para todos.</p>
          <img src="assets/img/diversidade/22-transparente.png" alt="Ilustração sobre inclusão LGBTQIA+" class="pillar-image">
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>