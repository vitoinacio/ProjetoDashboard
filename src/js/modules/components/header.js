function header() {

  const element = document.createElement("header");

    element.innerHTML = `
      <header>
        <div class="info-header">
          <div class="logo">
            <div class="contentMenuMobile">
              <span class="menuMobile"></span>
              <span class="menuMobile"></span>
              <span class="menuMobile"></span>
            </div>
            <h3>SmartWallet</h3>
          </div>
        </div>
        <div class="info-header">
          <i class="fa-solid fa-bell"></i>
          <i class="fa-solid fa-gear"></i>
          <img src="src/img/perfil.png" alt="foto-perfil" />
        </div>
      </header>
      <!-- FIM HEADER --> 
    `;

    document.body.appendChild(element);
    console.log(document.body.children.('<h1>oi</h1>'))
    console.log(document.body)
}

header();

/*<!-- INICIO MAIN -->
    <section class="main">
      <!-- SIDEBAR -->
      <div class="sidebar">
        <h3>Home</h3>
        <a href="src/pages/dashboard.html" class="active"
          ><i class="fa-solid fa-chart-line"></i> Dashboard</a
        >
        <a href="#"><i class="fa-solid fa-sliders"></i> Analise</a>
        <a href="#"><i class="fa-solid fa-wallet"></i> Carteira</a>
        <a href="#"><i class="fa-regular fa-circle-user"></i> User</a>
        <a href="#" class="mobile"
          ><i class="fa-solid fa-gear"></i> Configurações</a
        >
        <a href="#" class="mobile"
          ><i class="fa-solid fa-bell"></i> Notficações</a
        >
        <hr />
      </div>
      <!-- CONTENT -->
      <div class="content">

      </div>
      <!-- FIM CONTENT -->
    </section>
    <!-- FIM MAIN -->*/
