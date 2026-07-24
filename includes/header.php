<?php
$pageTitle = $pageTitle ?? 'MDR Advocacia';
$pageDescription = $pageDescription ?? 'Escritório full service especialista em atendimentos de instituições bancárias';
$pageKeywords = $pageKeywords ?? 'MDR, MARCOS DELLI RODRIGUES, ADVOCACIA, DELLI, NATAL, ADVOGADOS, ADVOGADA, CAPIM MACIO';
$bodyClass = $bodyClass ?? 'index-page';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($pageKeywords, ENT_QUOTES, 'UTF-8'); ?>">

    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="/assets/css/main.css?v=1.1" rel="stylesheet">
</head>

<body class="<?php echo htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8'); ?>">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="/" class="logo d-flex align-items-center">
                <img src="/assets/img/logo.png" alt="Logo MDR Advocacia">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/atuacao">Atuação</a></li>
                    <li><a href="/premios">Prêmios e Certificados</a></li>
                    <li><a href="/diversidade">Diversidade</a></li>
                    <li><a href="/recuperacao-credito">Recuperação de Crédito</a></li>
                    <li><a href="https://mdradvocacia.vagas.solides.com.br/">Trabalhe conosco</a></li>
                    <li><a href="/privacidade">Compliance e Privacidade</a></li>
                    <li><a href="http://mdradvocacia.com/interno" target="_blank">Interno</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">
