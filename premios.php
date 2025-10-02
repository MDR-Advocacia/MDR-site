<?php 
  include 'header.php'; 
?>
    <div class="page-title dark-background" data-aos="fade" >
      <div class="container">
        <h1>Prêmios e Certificados</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Prêmios e Certificados</li>
          </ol>
        </nav>
      </div>
    </div>

<style>
/* --- ESTILOS PARA PÁGINA DE PRÊMIOS --- */
.recognition-section { padding: 60px 0; }
.year-group { margin-bottom: 70px; }
.year-group h2 {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 40px;
    color: #333;
    padding-bottom: 15px;
    border-bottom: 2px solid #eee;
}
.year-group.latest h2 {
    color: #b29d55;
    border-bottom-color: #b29d55;
}
.recognition-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: start;
}

/* Grade de selos (esquerda) */
.seals-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
.seal-item a { /* Estilo aplicado ao link */
    background-color: #f7f7f7;
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    aspect-ratio: 1 / 1;
    transition: all 0.3s ease;
    cursor: pointer;
}
.seal-item img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
    transition: transform 0.3s ease;
}
.seal-item a:hover {
    transform: scale(1.05);
}
/* A classe de item ativo será adicionada via JS */
.seal-item a.thumb-active {
    border-color: #b29d55;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Carrossel de descrição (direita) */
.description-carousel {
    background-color: #f7f7f7;
    border-radius: 8px;
    padding: 40px;
    min-height: 100%;
    overflow: hidden; /* Importante para o Swiper */
}
.swiper-description .swiper-slide {
    /* O Swiper controla o display, não precisamos de 'display: none' */
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.swiper-description .description-logo { max-width: 150px; margin-bottom: 20px; }
.swiper-description h3 { font-family: 'Montserrat', sans-serif; font-size: 24px; font-weight: 700; margin-bottom: 15px; color: #333; }
.swiper-description p { color: #6c757d; line-height: 1.7; }

/* Seção de Destaque para Premiações (Separada) */
.featured-awards-section { padding: 80px 0; background-color: #f0f0f0; }
.featured-awards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }
.featured-award-card { background-color: #fff; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
.featured-award-card img { max-width: 120px; margin-bottom: 20px; }
.featured-award-card h4 { font-size: 20px; font-weight: 600; margin-bottom: 10px; }
.featured-award-card p { color: #6c757d; }

/* Responsividade */
@media (max-width: 992px) { .recognition-layout { grid-template-columns: 1fr; } }
@media (max-width: 576px) { .seals-grid { grid-template-columns: repeat(2, 1fr); } }
</style>

<main>
    <section class="recognition-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Reconhecimentos e Associações</h2>
            </div>
            
            <div id="year-2025" class="year-group latest" data-aos="fade-up">
                <h2>2025</h2>
                <div class="recognition-layout">
                    <div class="seals-grid">
                        <div class="seal-item"><a href="#" target="_blank"><img src="assets/img/premios/analiseadvocacia.png" alt="Análise Advocacia"></a></div>
                        <div class="seal-item"><a href="#" target="_blank"><img src="assets/img/premios/SELO__SELO_REG_ADVOGADO.png" alt="Análise Regional Advogado"></a></div>
                        <div class="seal-item"><a href="#" target="_blank"><img src="assets/img/premios/SELO__SELO_REG_ESCRITORIO.png" alt="Análise Regional Escritório"></a></div>
                        <div class="seal-item"><a href="#" target="_blank"><img src="assets/img/premios/selo-certificado-escritorio-vertical.png" alt="AB2L Infinite"></a></div>
                    </div>
                    <div class="description-carousel">
                        <div class="swiper swiper-description">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="assets/img/premios/analiseadvocacia.png" class="description-logo" alt="Análise Advocacia">
                                    <h3>Análise ADVOCACIA 2025</h3>
                                    <p>O MDR Advocacia foi reconhecido como um dos escritórios mais admirados do Rio Grande do Norte na 19ª edição do anuário @analise.editorial Advocacia 2025. Além disso, nosso sócio Marcos Délli Ribeiro Rodrigues foi destacado como um dos advogados mais admirados do estado e está entre os mais renomados do Brasil no setor bancário. A premiação, que reúne 1.150 escritórios e 2.814 advogados de todo o país, reforça o impacto crescente dos escritórios de advocacia na economia brasileira e sua relevância no cenário jurídico global. Esse reconhecimento é fruto do trabalho dedicado de toda a nossa equipe, que busca sempre a excelência no atendimento aos nossos clientes.</p>
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/img/premios/SELO__SELO_REG_ADVOGADO.png" class="description-logo" alt="Análise Regional Advogado">
                                    <h3>Análise ADVOCACIA REGIONAL 2025</h3>
                                    <p>Nosso sócio Marcos Delli conquistou o 3º lugar entre os advogados mais admirados da mesma região.</p>
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/img/premios/SELO__SELO_REG_ESCRITORIO.png" class="description-logo" alt="Análise Regional Escritório">
                                    <h3>Análise ADVOCACIA REGIONAL 2025</h3>
                                    <p>Mais uma vez, nosso escritório é reconhecido por seu trabalho de excelência! Desta vez, compartilhamos que fomos destaque na @analise.editorial como o 4º escritório mais admirado do Nordeste.</p>
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/img/premios/selo-certificado-escritorio-vertical.png" class="description-logo" alt="AB2L Infinite">
                                    <h3>AB2L Infinite De Inovação Jurídica 2025</h3>
                                    <p>Este ano, conquistamos nossa terceira Certificação AB2L Infinite de Inovação Jurídica! Na ocasião, o sócio Weuder Martins palestrou sobre o tema “Transformação digital jurídica: como a IA está revolucionando as áreas de Legal Ops e Controladoria Jurídica”.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="year-2024" class="year-group" data-aos="fade-up">
                <h2>2024</h2>
                <div class="recognition-layout">
                    <div class="seals-grid">
                        <div class="seal-item"><a href="#" target="_blank"><img src="assets/img/premios/fenalaw.png" alt="Fenalaw"></a></div>
                        <div class="seal-item"><a href="#" target="_blank"><img src="assets/img/premios/greatplacetowork.png" alt="Great Place to Work"></a></div>
                        <div class="seal-item"><a href="#" target="_blank"><img src="assets/img/premios/infinite.png" alt="AB2L Infinite 2024"></a></div>
                    </div>
                    <div class="description-carousel">
                        <div class="swiper swiper-description">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="assets/img/premios/fenalaw.png" class="description-logo" alt="Fenalaw">
                                    <h3>Análise DNA+FENALAW 2024</h3>
                                    <p>Pelo segundo ano consecutivo, o MDR Advocacia celebra mais uma conquista: fomos premiados em segundo lugar na categoria Tecnologia no Prêmio Análise DNA + Fenalaw 2024, com nosso projeto “Célula de Negociação Humanizada”! Este prêmio reconhece práticas de destaque em escritórios de advocacia, e estamos orgulhosos de ver nosso compromisso com inovação e qualidade no atendimento reconhecidos mais uma vez.</p>
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/img/premios/greatplacetowork.png" class="description-logo" alt="Great Place to Work">
                                    <h3>Great Place To Work</h3>
                                    <p>A MDR Advocacia conquistou, pelo segundo ano consecutivo, o selo de Great Place to Work (GPTW)! Esse selo é uma certificação global que reconhece empresas como ambientes de trabalho excepcionais, atestando a qualidade da gestão de pessoas e a cultura organizacional que promovemos. Ser reconhecidos como GPTW significa que nossos colaboradores avaliam positivamente o dia a dia da MDR.</p>
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/img/premios/infinite.png" class="description-logo" alt="AB2L Infinite 2024">
                                    <h3>AB2L Infinite De Inovação Jurídica 2024</h3>
                                    <p>No dia 30 de julho, a MDR Advocacia foi reconhecida pela Associação Brasileira de Lawtechs e Legaltechs (AB2L) com o Certificado de Inovação Jurídica 2024. Este prêmio reflete nosso compromisso contínuo com a inovação e a excelência na prática jurídica.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-awards-section">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Premiações em Destaque</h2>
            </div>
            <div class="featured-awards-grid" data-aos="fade-up">
                <div class="featured-award-card">
                    <img src="assets/img/premios/analise-mulher.png" alt="Análise Advocacia Mulher">
                    <h4>1º Lugar Melhor Performance</h4>
                    <p>Melhor Performance Geral Carteira entre 20 mil e 55 mil processos.</p>
                </div>
                <div class="featured-award-card">
                    <img src="assets/img/premios/analise-regional.png" alt="Análise Advocacia Regional">
                    <h4>1° Lugar em Improcedência</h4>
                </div>
                <div class="featured-award-card">
                    <img src="assets/img/premios/analise-regional.png" alt="Análise Advocacia Regional">
                    <h4>1° Lugar em Improcedência - Banco Réu</h4>
                </div>
                <div class="featured-award-card">
                    <img src="assets/img/premios/analise-regional.png" alt="Análise Advocacia Regional">
                    <h4>1° Lugar no Desafio Livelo</h4>
                </div>
                <div class="featured-award-card">
                    <img src="assets/img/premios/analise-regional.png" alt="Análise Advocacia Regional">
                    <h4>1° Lugar no Desafio Ourocap</h4>
                </div>
                <div class="featured-award-card">
                    <img src="assets/img/premios/analise-regional.png" alt="Análise Advocacia Regional">
                    <h4>1° Lugar em Acordos Cíveis</h4>
                </div>
                <div class="featured-award-card">
                    <img src="assets/img/premios/analise-regional.png" alt="Análise Advocacia Regional">
                    <h4>3° Lugar no Índice de Adequação do Risco Jurídico</h4>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function initCarousel(yearGroupId) {
        const yearGroup = document.getElementById(yearGroupId);
        if (!yearGroup) return;

        const descriptionSwiperEl = yearGroup.querySelector('.swiper-description');
        const sealLinks = yearGroup.querySelectorAll('.seals-grid .seal-item a');

        if (!descriptionSwiperEl || sealLinks.length === 0) return;

        const swiper = new Swiper(descriptionSwiperEl, {
            loop: true,
            autoplay: { delay: 15000, disableOnInteraction: false },
            observer: true,
            observeParents: true,
        });

        sealLinks.forEach((sealLink, index) => {
            sealLink.addEventListener('mouseenter', () => {
                swiper.slideToLoop(index);
            });
            sealLink.addEventListener('click', (e) => {
                if (sealLink.getAttribute('href') === '#') {
                    e.preventDefault(); 
                }
                swiper.slideToLoop(index);
            });
        });

        swiper.on('slideChange', function() {
            sealLinks.forEach(link => link.classList.remove('thumb-active'));
            if (sealLinks[swiper.realIndex]) {
                sealLinks[swiper.realIndex].classList.add('thumb-active');
            }
        });

        if (sealLinks.length > 0) {
            sealLinks[0].classList.add('thumb-active');
        }
    }

    initCarousel('year-2025');
    initCarousel('year-2024');
});
</script>

<?php include 'footer.php'; ?>