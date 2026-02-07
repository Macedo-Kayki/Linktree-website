<div align="center">

# 🌲 Linktree Website

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E)

<br />

<h3>
  <a href="#-english">🇺🇸 English</a>
  &nbsp;|&nbsp;
  <a href="#-português">🇧🇷 Português</a>
</h3>

<p>
  <em>A customizable, Dockerized solution to manage your social presence with real-time preview and public sharing.</em>
</p>

</div>

---

<div id="english"></div>

## 🇺🇸 English

### 📖 About the Project

**Linktree Website** is a robust application built with Laravel and Docker. It empowers users to create a personalized landing page housing unlimited links to their social media, portfolios, or content. The standout features are the **Live Preview** for instant feedback and **Public Link Sharing** for easy distribution.

### ✨ Key Features

* **🔗 Public Shareable Link:** Generate a unique public URL (e.g., `yourdomain.com/username`) that anyone can visit without logging in.
* **📱 Real-Time Live Preview:** Watch your page update instantly as you edit settings (WYSIWYG).
* **🎨 Full Visual Customization:**
    * **Background:** Choose a solid color or upload a custom background image.
    * **Buttons:** Customize button colors to match your brand.
    * **Typography:** Change text colors for better contrast and style.
* **🐳 Dockerized Environment:** Fully containerized for consistent development and deployment.
* **🔐 Secure Authentication:** Complete login and registration system.
* **♾️ Unlimited Links:** Create, edit, and manage as many links as needed with custom icons.

### 🛠️ Tech Stack

* **Backend:** PHP 8.x, Laravel Framework
* **Database:** MySQL
* **Frontend:** JavaScript (Live logic), Blade Templates, CSS3
* **DevOps:** Docker & Docker Compose

### 🚀 How to Run (with Docker)

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/Macedo-Kayki/Linktree-website.git](https://github.com/Macedo-Kayki/Linktree-website.git)
    cd Linktree-website
    ```

2.  **Setup Environment:**
    ```bash
    cp .env.example .env
    ```
    > **Note:** Open `.env` and ensure `DB_HOST` is set to your database service name (e.g., `mysql` or `db`) defined in your `docker-compose.yml`.

3.  **Start Containers:**
    ```bash
    docker-compose up -d --build
    ```

4.  **Install Dependencies:**
    *Run inside the container (assuming service name is 'app'):*
    ```bash
    # Install PHP dependencies
    docker-compose exec app composer install

    # Generate App Key
    docker-compose exec app php artisan key:generate

    # Run Database Migrations
    docker-compose exec app php artisan migrate

    # Install Frontend assets & Build
    docker-compose exec app npm install && npm run build
    ```

5.  **Access the App:**
    Visit `http://localhost:8000` (or the port specified in your configuration).

---

<div id="português"></div>

## 🇧🇷 Português

### 📖 Sobre o Projeto

**Linktree Website** é uma aplicação robusta desenvolvida com Laravel e Docker. Ela permite criar uma landing page personalizada com links ilimitados. Os grandes diferenciais são o **Live Preview** em tempo real e o **Compartilhamento de Link Público**, facilitando a divulgação do seu perfil.

### ✨ Funcionalidades

* **🔗 Link Público Compartilhável:** Gere uma URL única (ex: `seudominio.com/usuario`) que qualquer pessoa pode acessar para ver seus links, sem necessidade de login.
* **📱 Live Preview em Tempo Real:** Veja sua página sendo montada instantaneamente enquanto você edita (WYSIWYG).
* **🎨 Personalização Visual Completa:**
    * **Fundo (Background):** Escolha uma cor sólida ou faça upload de uma imagem de fundo.
    * **Botões:** Altere a cor dos botões para combinar com sua marca.
    * **Tipografia:** Ajuste a cor dos textos para melhor contraste e estilo.
* **🐳 Ambiente Docker:** Totalmente conteinerizado para facilitar o desenvolvimento e deploy.
* **🔐 Autenticação Segura:** Sistema completo de login e registro.
* **♾️ Links Ilimitados:** Crie e gerencie links ilimitados com ícones personalizados.

### 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8.x, Framework Laravel
* **Banco de Dados:** MySQL
* **Frontend:** JavaScript (Lógica de Preview), Blade Templates, CSS3
* **DevOps:** Docker & Docker Compose

### 🚀 Como Rodar (com Docker)

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/Macedo-Kayki/Linktree-website.git](https://github.com/Macedo-Kayki/Linktree-website.git)
    cd Linktree-website
    ```

2.  **Configure o Ambiente:**
    ```bash
    cp .env.example .env
    ```
    > **Nota:** Abra o arquivo `.env` e certifique-se de que `DB_HOST` está definido como o nome do serviço do banco (ex: `mysql` ou `db`) conforme seu `docker-compose.yml`.

3.  **Inicie os Containers:**
    ```bash
    docker-compose up -d --build
    ```

4.  **Instale as Dependências:**
    *Execute estes comandos para rodar dentro do container (assumindo que o serviço se chama 'app'):*
    ```bash
    # Instalar dependências do PHP
    docker-compose exec app composer install

    # Gerar a chave da aplicação
    docker-compose exec app php artisan key:generate

    # Rodar as migrações do banco
    docker-compose exec app php artisan migrate

    # Instalar assets do Frontend & Buildar
    docker-compose exec app npm install && npm run build
    ```

5.  **Acesse o App:**
    Acesse `http://localhost:8000` (ou a porta especificada na sua configuração).

---

<div align="center">
  <sub>Developed by <a href="https://github.com/Macedo-Kayki">Kayki Macedo</a></sub>
</div>
