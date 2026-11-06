#!/usr/bin/env python3
"""Convert approved public reference pages to editable WordPress blocks.

Inputs are local snapshots; this never executes legacy PHP or imports scripts,
forms, trackers or testimonials as current reviews. Downloaded public assets
are pinned by SHA-256 and bundled for a controlled, one-time import.
"""
import argparse
import concurrent.futures
import hashlib
import html
import json
from pathlib import Path
import re
import urllib.parse
import urllib.request

from bs4 import BeautifulSoup, Tag

ORIGIN = 'https://mdradvocacia.com'
ASSETS = {}


def esc(value):
    return html.escape(str(value), quote=True)


def asset(src):
    url = urllib.parse.urljoin(ORIGIN + '/', src)
    parsed = urllib.parse.urlsplit(url)
    if parsed.netloc != 'mdradvocacia.com' or not parsed.path.startswith('/assets/'):
        raise ValueError('Unexpected asset origin: ' + url)
    suffix = Path(parsed.path).suffix.lower()
    if suffix not in ('.pdf', '.txt', '.jpg', '.jpeg', '.png', '.webp'):
        raise ValueError('Unsupported asset type: ' + suffix)
    key = hashlib.sha256(url.encode()).hexdigest()[:20]
    ASSETS.setdefault(key, {'source': url, 'file': key + suffix})
    return '{{asset:' + key + '}}'


def link(url):
    parsed = urllib.parse.urlsplit(urllib.parse.urljoin(ORIGIN + '/', url))
    if parsed.netloc == 'mdradvocacia.com':
        if parsed.path.startswith('/assets/'):
            return asset(url)
        route = parsed.path.rstrip('/') or '/'
        route = {'/premios': '/reconhecimentos', '/compliance': '/compliance-e-privacidade'}.get(route, route)
        return '{{site}}' + route + ('/' if route != '/' else '') + ('#' + parsed.fragment if parsed.fragment else '')
    if parsed.scheme in ('mailto', 'tel'):
        return url
    return url if parsed.scheme == 'https' else '#'


def inline(node):
    if not isinstance(node, Tag):
        return esc(str(node))
    body = ''.join(inline(child) for child in node.children)
    if node.name in ('strong', 'b'):
        return '<strong>' + body + '</strong>'
    if node.name in ('em', 'i'):
        return '<em>' + body + '</em>' if body.strip() else ''
    if node.name == 'br':
        return '<br>'
    if node.name == 'a':
        href = link(node.get('href', '#'))
        extra = ' target="_blank" rel="noopener noreferrer"' if href.startswith('https://') else ''
        return '<a href="' + esc(href) + '"' + extra + '>' + body + '</a>'
    return body


def paragraph(text, raw=False):
    return '<!-- wp:paragraph --><p>' + (text if raw else esc(text)) + '</p><!-- /wp:paragraph -->'


def heading(text, level=2):
    return '<!-- wp:heading ' + json.dumps({'level': level}) + ' --><h' + str(level) + ' class="wp-block-heading">' + esc(text) + '</h' + str(level) + '><!-- /wp:heading -->'


def group(name, content):
    return '<!-- wp:group ' + json.dumps({'className': name}) + ' --><div class="wp-block-group ' + name + '">' + content + '</div><!-- /wp:group -->'


def image(src, alt, full=None):
    thumb = asset(src)
    if full:
        content = '<a href="' + esc(asset(full)) + '" class="certificate-zoom" target="_blank" rel="noopener"><img src="' + thumb + '" alt="' + esc(alt) + '" loading="lazy"></a>'
    else:
        content = '<img src="' + thumb + '" alt="' + esc(alt) + '" loading="lazy">'
    return '<!-- wp:image {"sizeSlug":"large"} --><figure class="wp-block-image size-large">' + content + '</figure><!-- /wp:image -->'


def plain_blocks(root, images=True):
    result = []
    if root is None:
        return ''
    for node in root.find_all(['h2', 'h3', 'h4', 'p', 'ul', 'ol', 'img']):
        if node.find_parent(['p', 'ul', 'ol']):
            continue
        if any(x.get('class') and any(c in x.get('class', []) for c in ['breadcrumbs', 'modal-footer', 'digital-signature']) for x in [node] + list(node.parents)):
            continue
        text = node.get_text(' ', strip=True)
        if node.name.startswith('h'):
            result.append(heading(text, 2 if node.name == 'h2' else 3))
        elif node.name == 'p' and text and text not in ('Clique para saber mais', 'Clique no olho para visualizar o documento e no ícone de download para baixá-lo.'):
            result.append(paragraph(''.join(inline(c) for c in node.children), True))
        elif node.name in ('ul', 'ol'):
            items = ''.join('<!-- wp:list-item --><li>' + ''.join(inline(c) for c in li.children) + '</li><!-- /wp:list-item -->' for li in node.find_all('li', recursive=False))
            attrs = ' {"ordered":true}' if node.name == 'ol' else ''
            result.append('<!-- wp:list' + attrs + ' --><' + node.name + ' class="wp-block-list">' + items + '</' + node.name + '><!-- /wp:list -->')
        elif node.name == 'img' and images and node.get('src', '').lstrip('/').startswith('assets/'):
            result.append(image(node['src'], node.get('alt', '')))
    return '\n'.join(result)


def page(slug, title, content, summary='', status='publish', parent=None):
    return {'slug': slug, 'title': title, 'content': content, 'summary': summary, 'status': status, 'parent': parent}


def generate(sources):
    def soup(slug):
        return BeautifulSoup((sources / (slug + '.html')).read_text(), 'html.parser')
    pages = []
    s = soup('diversidade')
    intro = s.select_one('#diversidade')
    for card in intro.select('.card'):
        card.decompose()
    content = plain_blocks(intro, images=False)
    content += paragraph('<a href="https://youtu.be/Q-72lIY8QN8" target="_blank" rel="noopener noreferrer">Assistir ao manifesto de Diversidade e Inclusão no YouTube ↗</a>', True)
    photos = ['comite-generos.jpg', 'comite-pcd.jpg', 'comite-racial.jpg', 'comite-lgbt.jpg', 'comite-religiao.jpg']
    for modal, photo in zip(s.select('main .modal'), photos):
        title = modal.select_one('h2').get_text(' ', strip=True)
        body = ''.join(paragraph(''.join(inline(c) for c in p.children), True) for p in modal.select('.modal-body p'))
        content += '<!-- wp:details --><details class="wp-block-details"><summary>' + esc(title) + '</summary>' + image('/assets/img/diversidade/' + photo, title) + body + '</details><!-- /wp:details -->'
    pages.append(page('diversidade', 'Diversidade e Inclusão', content, 'Comitê, manifesto e frentes de diversidade da MDR.'))

    s = soup('compliance-e-privacidade')
    root = s.select_one('#privacy-content')
    docs = [(b.get('data-doc-title'), b['data-doc-download']) for b in root.select('[data-doc-download]')]
    content = plain_blocks(root, images=False)
    document_links = []
    for title, src in docs:
        document_links.append(paragraph('<strong>' + esc(title) + '</strong><br><a href="' + asset(src) + '" target="_blank" rel="noopener">Consultar PDF ↗</a> · <a href="' + asset(src) + '" download>Baixar documento</a>', True))
    content += heading('Consulta e download dos documentos') + ''.join(document_links)
    pages.append(page('compliance-e-privacidade', 'Compliance e Privacidade', content, 'Programa de integridade, privacidade, DPO e documentos institucionais.'))
    privacy = heading('Privacidade e proteção de dados') + ''.join(paragraph(''.join(inline(c) for c in p.children), True) for p in root.select('.privacy-overview-card p, .dpo-card p'))
    privacy += heading('Documentos de privacidade') + ''.join(document_links[:2]) + paragraph('Contato da Encarregada: <a href="mailto:dpo@mdradvocacia.com">dpo@mdradvocacia.com</a>.', True)
    pages.append(page('privacidade', 'Privacidade e Proteção de Dados', privacy, 'Informações de privacidade, contato da DPO e documentos para consulta.'))

    s = soup('pacto-global-gptw')
    pages.append(page('pacto-global-gptw', 'Pacto Global e GPTW', plain_blocks(s.select_one('#pacto-global-gptw')), 'Participação no Pacto Global e certificação GPTW, com seus diferentes significados.'))

    areas = [('direito-bancario', 'Direito Bancário'), ('direito-regulatorio', 'Direito Regulatório'), ('direito-fiscal', 'Direito Fiscal e Tributário'), ('comercio-internacional', 'Comércio Internacional'), ('planejamento-sucessorio', 'Planejamento Sucessório'), ('seguros', 'Seguros')]
    s = soup('atuacao')
    content = plain_blocks(s.select_one('#services'), images=False)
    if not content:
        main = s.find('main')
        for part in main.select('#testimonials, .page-title'):
            part.decompose()
        content = plain_blocks(main, images=False)
    content += heading('Conheça nossas áreas') + ''.join(paragraph('<a href="{{site}}/' + slug + '/">' + title + ' ↗</a>', True) for slug, title in areas + [('recuperacao-credito', 'Recuperação de Crédito')])
    pages.append(page('atuacao', 'Áreas de Atuação', content, 'Conheça as áreas de atuação e os serviços jurídicos da MDR.'))
    testimonials = None
    for index, (slug, title) in enumerate(areas):
        s = soup(slug)
        if testimonials is None and s.select_one('#testimonials'):
            testimonials = plain_blocks(s.select_one('#testimonials'))
        pages.append(page(slug, title, plain_blocks(s.select_one('#services'), images=False), 'Serviços e atuação da MDR em ' + title + '.', parent='atuacao'))

    s = soup('recuperacao-credito')
    main = s.find('main')
    related = main.select_one('.related-professionals-title')
    if related:
        for sib in list(related.next_siblings):
            if isinstance(sib, Tag) and sib.name == 'section':
                break
            if isinstance(sib, Tag):
                sib.decompose()
        related.decompose()
    for part in main.select('.page-title, .contact-section'):
        part.decompose()
    content = plain_blocks(main)
    content += heading('Conheça a liderança') + paragraph('<a href="{{site}}/socios/natalia-ribeiro-linhares/">Perfil de Natália Ribeiro Linhares ↗</a>', True)
    pages.append(page('recuperacao-credito', 'Recuperação de Crédito', content, 'Atuação extrajudicial e judicial, metodologia e tecnologia na recuperação de crédito.', parent='atuacao'))
    s = soup('equipe-recuperacao-credito')
    main = s.find('main')
    for part in main.select('.page-title, .contact-section'):
        part.decompose()
    # The legacy directory is explicitly known to be outdated. Preserve its full
    # content for editorial validation, but never publish it as a current roster.
    old_directory = str(main)
    for script in BeautifulSoup(old_directory, 'html.parser').select('script'):
        script.decompose()
    pages.append(page('equipe-recuperacao-credito', 'Equipe de Recuperação de Crédito — revisão', paragraph('Diretório histórico importado para revisão. Confirmar composição, funções, fotografias e contatos antes de publicar.') + plain_blocks(main), status='draft'))
    if testimonials:
        pages.append(page('depoimentos-revisao', 'Depoimentos — revisão editorial', paragraph('Conteúdo histórico do site original. Confirmar origem e autorização de divulgação; não representa integração atual com avaliações do Google.') + testimonials, status='draft'))

    s = soup('about')
    main = s.find('main')
    about = main.select_one('#about') or main.select_one('section')
    content = plain_blocks(about, images=False) + plain_blocks(main.select_one('#why-us'), images=False)
    content += paragraph('<a href="{{site}}/#socios">Conheça os sócios e seus perfis profissionais ↗</a>', True)
    pages.append(page('about', 'O Escritório', content, 'Apresentação, Missão, Visão e Valores da MDR Advocacia.'))
    pages.append(page('esg', 'Compromissos Institucionais', paragraph('Conheça os compromissos institucionais da MDR e os documentos disponíveis para consulta.') + ''.join(heading(title) + paragraph('<a href="{{site}}/' + slug + '/">' + label + ' ↗</a>', True) for slug, title, label in [('diversidade', 'Diversidade e Inclusão', 'Conhecer o comitê e as frentes de atuação'), ('compliance-e-privacidade', 'Ética, Integridade e Compliance', 'Consultar o programa e os documentos'), ('privacidade', 'Privacidade e Proteção de Dados', 'Consultar informações e canais da DPO'), ('pacto-global-gptw', 'Pacto Global e GPTW', 'Conhecer os compromissos e seus significados')]), 'Diversidade, integridade, privacidade e compromissos institucionais.'))

    s = soup('premios')
    content = ''
    recognition = s.select_one('.recognition-section')
    if recognition:
        history = {}; seen = set()
        for title in recognition.select('h3'):
            card = title.parent
            img = card.select_one('img')
            if not img:
                continue
            prior = title.find_previous('h2')
            year = prior.get_text(strip=True) if prior else 'Histórico'
            if not year.isdigit():
                year = 'Histórico'
            name = title.get_text(' ', strip=True)
            key = (year, name, img['src'].lstrip('/'))
            if key in seen:
                continue
            seen.add(key)
            body = image(img['src'], img.get('alt') or name) + heading(name, 3)
            body += ''.join(paragraph(''.join(inline(c) for c in p.children), True) for p in card.select('p'))
            history.setdefault(year, []).append(group('recognition-history-card', body))
        content += heading('Reconhecimentos e Associações')
        for year, cards in history.items():
            content += heading(year) + group('recognition-history-grid', ''.join(cards))
    content += heading('Galeria de certificados')
    certificates = []; certificate_cards = []
    for item in s.select('.certificates-section .certificate-item'):
        img = item.select_one('img')
        caption = item.select_one('.certificate-description')
        if not img:
            continue
        title = caption.get_text(' ', strip=True) if caption else img.get('alt', 'Certificado institucional')
        certificate_cards.append(group('certificate-card', image(img['src'], title, img.get('data-full') or img['src']) + paragraph(title)))
        certificates.append(title)
    content += group('certificate-grid', ''.join(certificate_cards))
    pages.append(page('certificados', 'Histórico e Certificados', content, 'Acervo histórico de reconhecimentos, associações e certificados.'))
    return {'version': 'institutional-2026-11-06-v1', 'source_origin': ORIGIN, 'pages': pages, 'assets': ASSETS, 'certificates': certificates}


def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--sources', type=Path, required=True)
    parser.add_argument('--output', type=Path, required=True)
    args = parser.parse_args()
    data = generate(args.sources)
    directory = args.output.parent / 'institutional-assets'
    directory.mkdir(exist_ok=True)

    def download(item):
        key, spec = item
        dest = directory / spec['file']
        if not dest.exists():
            with urllib.request.urlopen(spec['source'], timeout=45) as response:
                body = response.read(20 * 1024 * 1024 + 1)
            if len(body) > 20 * 1024 * 1024:
                raise ValueError('Asset exceeds limit')
            if spec['file'].endswith('.pdf') and not body.startswith(b'%PDF-'):
                raise ValueError('Invalid PDF: ' + spec['source'])
            dest.write_bytes(body)
        body = dest.read_bytes()
        spec.update({'sha256': hashlib.sha256(body).hexdigest(), 'bytes': len(body)})

    with concurrent.futures.ThreadPoolExecutor(max_workers=5) as pool:
        list(pool.map(download, ASSETS.items()))
    args.output.write_text(json.dumps(data, ensure_ascii=False, indent=2) + '\n')
    print(json.dumps({'pages': len(data['pages']), 'published': sum(p['status'] == 'publish' for p in data['pages']), 'drafts': sum(p['status'] == 'draft' for p in data['pages']), 'assets': len(ASSETS), 'asset_bytes': sum(a['bytes'] for a in ASSETS.values()), 'certificates': len(data['certificates'])}))


if __name__ == '__main__':
    main()
