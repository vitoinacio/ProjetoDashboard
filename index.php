<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="src/css/style.css" />
    <script
      src="https://kit.fontawesome.com/7414161b6e.js"
      crossorigin="anonymous"
    ></script>
    <script type="module" src="src/js/script.js" defer></script>
    <script src="src/js/modules/navFixed.js" defer></script>
    <title>SmartWallet</title>
  </head>
  <body style="overflow-x: hidden;">
    <!-- INICIO HEADER -->
    <header class="header-nav">
      <div class="logo-nav">
        <h2>
          <a href="src/pages/cadastro.html"><i class="fa-solid fa-chart-line"></i>Smart<strong>Wallet</strong></a>
        </h2>
      </div>
      <div class="menu-nav">
        <a href="#oqueOferecemos">O que oferecemos</a>
        <a href="#gestao-de-gastos">Gestão de gastos</a>
        <a href="#quem-somos">Quem somos?</a>
      </div>
      <div class="buttons-nav">
        <a class="btn-criarConta" href="src/pages/cadastro.html">Criar conta</a>
        <button class="btn-entrar" id="loginBtn">Entrar</button>
        <div class="btnsConfigsIndex">
          <span class="themeContent"><button id="theme"><i class="fa-solid fa-moon"></i></button></span>
          <span class="FontSizeContent"><button id="increment">+</button><button id="decrement">-</button></span>
        </div>
      </div>
      <!-- MENU MOBILE -->
      <div class="btnsmenuMobile">
        <span class="contentMenuMobile-index">
          <span class="button-menuMobile"></span>
          <span class="button-menuMobile"></span>
          <span class="button-menuMobile"></span>
        </span>
        <div class="btnsConfigsIndex">
          <span class="themeContent themeContentMobile"><button id="theme"><i class="fa-solid fa-moon"></i></button></span>
          <span class="FontSizeContent FontSizeContentMobile"><button id="increment">+</button><button id="decrement">-</button></span>
        </div>
      </div>
      <div class="menuMobile-index">
        <a href="#oqueOferecemos">O que oferecemos</a>
        <a href="#gestao-de-gastos">Gestão de gastos</a>
        <a href="#quem-somos">Quem somos?</a>
        <div class="buttons">
          <a class="btn-menuMobileCRiaConta" href="src/pages/cadastro.html">Criar conta</a>
          <button class="btn-entrar" id="loginBtn">Entrar</button>
        </div>
      </div>
      <!-- MENU MOBILE -->
    </header>
    <hr />
    <!-- FIM HEADER -->
    <!--INICIO LOGIN-->
    <div id="loginModal" class="modal">
      <div class="modal-content">
        <span class="close" id="closeBtn"><i class="fa-solid fa-xmark"></i></span>
        <i class="fa-solid fa-chart-line"></i><p>Smart<strong>Wallet</strong></p>
        <form action="./src/php/testLogin.php" id="loginForm" class="loginForm" method="post">
          <input
            type="email"
            id="emailLogin"
            name="email"
            placeholder="Email"
          />
          <a href="src/pages/cadastro.html" class="criarConta" id="criarConta">Ainda não tenho conta</a>
          <input
            type="password"
            id="password"
            name="senha"
            placeholder="Senha"
          />
          <a  href="src/pages/codigoRecovery.php" class="recoverPassword" id="recoverPassword">Recuperar Senha</a>
          <input type="submit" name="submit" id="entrarLogin" class="entrar-btn-modal" value="Enviar"/>
          <button type="reset" class="limpar-btn-modal">Limpar</button>
        </form>
      </div>
    </div>
    <!--FIM LOGIN-->
    <!-- INICIO MAIN -->
    <section class="main">
    <?php
        if(isset($_GET['errorMessage']) && !empty($_GET['errorMessage'])){ ?>
          <div class="error" id="error-message">
            <div class="message"><?php echo $_GET['errorMessage']; ?></div>
            <div class="icon"><button class="close-button" onclick="fecharErro()"><i class="fa-solid fa-xmark"></i></button></div>
          </div>
       <?php }
      ?>
      <div class="container">
        <div class="section-chamada">
          <div class="text-chamada">
            <h1>Gestão e controle financeiro</h1>
            <p>Para você, completo e gratuito*</p>
          </div>
          <div class="input-chamada">
            <input
              type="email"
              name="email"
              id="emailIndex"
              placeholder="Seu email.."
            />
            <span class="invalidEmail"></span>
            <button id="btnCadastreSe" onsubmit="event.preventDefault()">Cadastre-se</button>
          </div>
        </div>
        <div class="section-image">
          <img src="src/img/dashboard.png" alt="Dasboard image" />
        </div>
      </div>
    </section>
    <!-- FIM MAIN -->
    <!-- SECTION SECUNDARIA -->
    <section class="info-secundaria" id="oqueOferecemos">
      <div class="titulo-secundaria">
        <h2>O controle total em suas mãos</h2>
        <p>Com o controle, você está a um passo de suas metas e objetivos</p>
      </div>
      <div class="container-card">
        <div class="card-info">
          <a href="src/pages/cadastro.html">
            <i class="fa-solid fa-chart-simple"></i>
            <h2>
              Análise <br />
              de Categorias
            </h2>
            <p>
              Divida suas despesas em categorias personalizáveis, como alimentação, transporte e lazer. Identifique facilmente quais áreas estão pesando mais no seu orçamento e onde pode economizar.
            </p>
          </a>
        </div>
        <div class="card-info">
          <a href="src/pages/cadastro.html">
            <i class="fa-solid fa-scale-balanced"></i>
            <h2>
              Controle <br />
              seus gastos
            </h2>
            <p>
              Mantenha suas finanças organizadas com facilidade. Nossa ferramenta
              permite acompanhar seus gastos, ajustar seu orçamento e alcançar
              suas metas financeiras. Simplifique a gestão do seu dinheiro e fique
              no controle.
            </p>
          </a>
        </div>
        <div class="card-info">
          <a href="src/pages/cadastro.html">
            <i class="fa-regular fa-clipboard"></i>
            <h2>
              Planejamento <br />
              Financeiro
            </h2>
            <p>
              Estabeleça metas de economia e planeje seus gastos com antecedência. Crie orçamentos mensais personalizados e receba sugestões automáticas de ajustes para atingir suas metas de forma eficiente.
            </p>
          </a>
        </div>
      </div>
    </section>
    <!-- FIM SECUNDARIA -->
    <!-- Seção Gestão de Gastos -->
    <section id="gestao-de-gastos" class="gestao-de-gastos">
      <div class="container-gastos">
        <h2>Gestão de Gastos</h2>
        <div class="gestao-de-gastos-content">
          <div class="gestao-de-gastos-texto">
            <p class="text-primary">
              Na Smart Wallet, sabemos que a gestão eficaz dos seus gastos é
              crucial para uma vida financeira saudável. Nossos dashboards de
              gastos foram projetados para ajudar você a controlar e otimizar
              suas despesas de maneira simples e eficiente.
            </p>
            <div>
              <p class="text">
                <strong>Análise Detalhada:</strong> Nossos dashboards fornecem
                uma visão abrangente das suas finanças, categorizando suas
                despesas e oferecendo insights detalhados sobre onde seu
                dinheiro está sendo gasto. Com gráficos e relatórios intuitivos,
                você pode facilmente identificar padrões e áreas onde é possível
                economizar.
              </p>
              <img src="src/img/telaDashboard.png" alt="imagem da dasboard" />
            </div>
            <div>
              <img src="src/img/telaPlanejamento.png" alt="imagem da dasboard" />
              <p class="text">
                <strong>Controle de Orçamento:</strong> Defina e acompanhe seu
                orçamento com facilidade. Nossos recursos de planejamento
                permitem que você estabeleça metas financeiras e monitore seu
                progresso ao longo do tempo. Ajuste seu orçamento com base em
                suas necessidades e veja como suas finanças estão se saindo em
                relação às suas metas.
              </p>
            </div>
            <div>
              <p class="text">
                <strong>Alertas e Notificações:</strong> Mantenha-se informado
                com alertas personalizados que o ajudam a evitar gastos
                excessivos. Receba notificações sobre despesas que estão se
                aproximando dos limites do seu orçamento e ajuste seus hábitos
                de gasto de acordo.
              </p>
              <img src="src/img/telaNotif.png" alt="imagem da dasboard" />
            </div>
            <p class="text-primary">
              Com a Smart Wallet, a gestão dos seus gastos se torna uma tarefa
              fácil e agradável. Nossa plataforma foi projetada para fornecer
              todas as ferramentas necessárias para que você tenha total
              controle sobre suas finanças e alcance seus objetivos financeiros
              com confiança.
            </p>
          </div>
          <div class="gestao-de-gastos-imagem"></div>
        </div>
      </div>
    </section>
    <!-- Seção Quem Somos -->
    <section id="quem-somos" class="quem-somos">
      <div class="container-quemSomos">
        <h2>Quem Somos ?</h2>
        <div class="quem-somos-content">
          <div class="quem-somos-texto">
            <p>
              <strong>Bem-vindo à Smart Wallet!</strong> Somos líderes em
              soluções inovadoras para gestão financeira pessoal. Nossa missão é
              capacitar você a tomar decisões financeiras mais inteligentes e
              informadas com a ajuda de nossos dashboards de gastos intuitivos e
              eficazes.
            </p>
            <p>
              Na Smart Wallet, entendemos que a gestão de despesas pode ser um
              desafio. Por isso, desenvolvemos ferramentas que tornam o
              acompanhamento dos seus gastos simples e direto. Nossos dashboards
              oferecem uma visão clara e detalhada de suas finanças, permitindo
              que você monitore seu orçamento e identifique áreas de economia
              com facilidade.
            </p>
            <p>
              Estamos comprometidos em fornecer soluções que não só atendem às
              suas necessidades atuais, mas também se adaptam ao seu estilo de
              vida em constante mudança. Nossa abordagem combina design elegante
              e funcionalidade avançada para criar produtos que você realmente
              usa e aprecia.
            </p>
            <p>
              Na Smart Wallet, acreditamos que a gestão financeira eficaz é a
              chave para uma vida financeira saudável. Junte-se a nós e descubra
              como nossos dashboards podem transformar a maneira como você
              gerencia seus gastos e alcança seus objetivos financeiros.
            </p>
          </div>
          <div class="quem-somos-imagem"></div>
        </div>
      </div>
    </section>
    <!-- FIM SECTION -->
    <!-- INICIO FOOTER -->
    <footer>
      <div class="info-footer">
        <a href="src/pages/termosDeUso.html">Termos de uso</a>
        <a href="src/pages/politicaEPrivacidade.html">Politica de privacidade</a>
        <a href="src/pages/contato.html">Fale conosco</a>
      </div>
      <div class="redes-sociais">
        <a href="https://github.com/vitoinacio/ProjetoDashboard"><i class="fa-brands fa-github"></i></a>
      </div>
      <div class="copy">
        <p>
          &copy; <span id="current-year"></span> Smart Wallet. Todos os direitos
          reservados.
        </p>
      </div>
    </footer>
    <!-- FIM FOOTER -->

    <script>
      function fecharErro() {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }
    </script>
  </body>
</html>
