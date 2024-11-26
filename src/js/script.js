import graficoCircular from "./modules/graficoCircular.js";
import graficoDeBarra from "./modules/graficoDeBarra.js";
import menuMobile from "./modules/menuMobile.js";
import sidebar from "./modules/sidebar.js";
import buttonMenu from "./modules/buttonConfig.js";
import loginBtn from "./modules/login.js";
import validateCadastro from "./modules/cadastro.js";
import logout from "./modules/logout.js";
import todoList from "./modules/listContas.js";
import cadastreSe from "./modules/cadastreSe.js";
import theme from "./modules/theme.js";
import handleTheme from "./modules/handleTheme.js";
import fontSize from "./modules/fontSize.js";

// muda a color dos graficos ao verificar o thema atual
if (sessionStorage.getItem('theme') === 'dark') {
  graficoDeBarra('#fff');
  graficoCircular('#fff');
} else {
  graficoDeBarra('#504f4f');
  graficoCircular('#504f4f');
}

handleTheme();

menuMobile();
sidebar();
buttonMenu();
loginBtn();
validateCadastro();
logout();
todoList();
cadastreSe();
theme();
fontSize();