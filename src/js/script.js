import graficoCircular from "./modules/graficoCircular.js";
import graficoDeBarra from "./modules/graficoDeBarra.js";
import menuMobile from "./modules/menuMobile.js";
import sidebar from "./modules/sidebar.js";
import buttonMenu from "./modules/buttonConfig.js";
import loginBtn from "./modules/login.js";
import validateCadastro from "./modules/cadastro.js";
import todoList from "./modules/listContas.js";
import cadastreSe from "./modules/cadastreSe.js";
import theme from "./modules/theme.js";
import handleTheme from "./modules/handleTheme.js";
import fontSize from "./modules/fontSize.js";


// muda a color dos graficos ao verificar o thema atual
document.addEventListener('DOMContentLoaded', function() {
  if (sessionStorage.getItem('theme') === 'dark') {
    const canvasBarra = document.getElementById('graficoDeBarra');
    if (canvasBarra) {
      graficoDeBarra('#504f4f');
    }
    const canvasCircular = document.getElementById('graficoCircular');
    if (canvasCircular) {
      graficoCircular('#504f4f');
    }
  } else {
    const canvasBarra = document.getElementById('graficoDeBarra');
    if (canvasBarra) {
      graficoDeBarra('#fff');
    }
    const canvasCircular = document.getElementById('graficoCircular');
    if (canvasCircular) {
      graficoCircular('#fff');
    }
  }
});

//Altera se o usuario quer tela de 2fa ou não
document.addEventListener('DOMContentLoaded', function() {
  const checkbox2FA = document.getElementById('2fa');

  checkbox2FA.addEventListener('change', function() {
    const isChecked = checkbox2FA.checked;

    fetch('../php/update_adm.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ adm: isChecked ? 1 : 0 })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        console.log('Atualização bem-sucedida');
      } else {
        console.error('Erro na atualização');
      }
    })
    .catch(error => console.error('Erro:', error));
  });
});


handleTheme();

menuMobile();
sidebar();
buttonMenu();
loginBtn();
validateCadastro();
todoList();
cadastreSe();
theme();
fontSize();