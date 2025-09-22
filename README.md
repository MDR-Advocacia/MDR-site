# MDR Advocacia - Site Oficial

Bem-vindo ao repositório do site oficial da MDR Advocacia. Este projeto foi desenvolvido para ser uma plataforma institucional moderna, funcional e responsiva, utilizando tecnologias web atuais e um ambiente de desenvolvimento containerizado com Docker.

## Tecnologias Utilizadas

-   **HTML5**: Utilizado para a estruturação do conteúdo do site.
-   **CSS3**: Utilizado para estilização e layout, com apoio da biblioteca **Bootstrap** para responsividade.
-   **JavaScript**: Utilizado para interatividade, animações e funcionamento de componentes como sliders e modais.
-   **PHP**: Utilizado para a lógica de back-end, como o processamento de formulários e a inclusão de componentes reutilizáveis (`header.php`, `footer.php`).
-   **Docker**: Utilizado para criar um ambiente de desenvolvimento consistente e isolado, garantindo que o site rode da mesma forma em qualquer máquina.

## Estrutura do Projeto

O projeto está organizado de forma modular para facilitar a manutenção:

-   `index.php`: Página principal (homepage) do site.
-   `header.php` / `footer.php`: Componentes reutilizáveis do cabeçalho e rodapé.
-   `services.php`: Página de "Atuação".
-   `recuperacao-credito.php`: Página de destaque da área de Recuperação de Crédito.
-   `equipe-recuperacao-credito.php`: Página com a lista completa dos colaboradores da equipe.
-   `diversidade.php`: Página dos comitês de diversidade.
-   `form.php`: Página "Trabalhe Conosco" com formulário de envio.
-   `video-header.php`: Componente reutilizável para os cabeçalhos com vídeo de fundo.
-   `/assets`: Contém todos os arquivos estáticos (CSS, imagens, vídeos, etc.).
-   `Dockerfile`: Define a imagem do contêiner, instalando o PHP e o servidor Apache.
-   `docker-compose.yml`: Orquestra a inicialização do ambiente Docker.

## Funcionalidades

-   **Página Inicial**: Apresentação com vídeo de fundo, seções sobre o escritório, missão/visão/valores e apresentação dos sócios.
-   **Páginas Internas**: Seções de "Atuação", "Diversidade" e "Recuperação de Crédito" com cabeçalhos de vídeo padronizados.
-   **Equipe**: Apresentação dos sócios com modais (pop-ups) de biografia e página dedicada à equipe completa de Recuperação de Crédito.
-   **Trabalhe Conosco**: Formulário funcional para envio de currículos em PDF, com processamento via PHP.
-   **Responsividade**: O site é totalmente adaptado para visualização em desktops, tablets e celulares.

## Como Executar o Projeto (com Docker)

Para rodar o projeto localmente, siga os passos abaixo.

1.  **Pré-requisitos:**
    * [Git](https://git-scm.com/) instalado.
    * [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado e em execução.

2.  **Clone o repositório** para sua máquina local:
    ```bash
    git clone [https://github.com/MDR-Advocacia/MDR-site.git](https://github.com/MDR-Advocacia/MDR-site.git)
    ```

3.  **Navegue até o diretório** do projeto:
    ```bash
    cd MDR-site
    ```

4.  **Inicie o ambiente Docker**:
    Este comando irá construir a imagem e iniciar o contêiner em segundo plano.
    ```bash
    docker-compose up -d
    ```

5.  **Visualize o site**:
    Abra o seu navegador e acesse **`http://localhost:8080`**.