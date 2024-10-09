export default function theme() {
  const btnTheme = document.querySelector('#theme');
  if (btnTheme) {

    // Função para alternar o tema
    const toggleTheme = () => {
      const isDarkMode = document.body.classList.contains('dark');
      if (isDarkMode) {
        document.body.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        document.querySelector('.themeContent').classList.remove('dark');
        setTimeout(()=>{btnTheme.innerHTML = '<i class="fa-solid fa-moon"></i>';},300)
        btnTheme.parentElement.style.background = '#121d77';
        
        // Alterar variáveis CSS para tema claro
        document.documentElement.style.setProperty('--cor1', '#ffffff');
        document.documentElement.style.setProperty('--cor5', '#6e6d6d');
        document.documentElement.style.setProperty('--cor7', '#f8f6f6');
      } else {
        document.body.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        document.querySelector('.themeContent').classList.add('dark');
        setTimeout(()=>{btnTheme.innerHTML = '<i class="fa-solid fa-sun"></i>';},300)
        btnTheme.parentElement.style.background = 'white';
        
        // Alterar variáveis CSS para tema escuro
        document.documentElement.style.setProperty('--cor1', '#000000');
        document.documentElement.style.setProperty('--cor5', '#ffffff');
        document.documentElement.style.setProperty('--cor7', '#504f4f');
      }
    };
    
    // Aplicar tema com base na preferência armazenada
    const applyStoredTheme = () => {
      const storedTheme = localStorage.getItem('theme');
      if (storedTheme === 'dark') {
        document.body.classList.add('dark');
        document.querySelector('.themeContent').classList.add('dark');
        btnTheme.innerHTML = '<i class="fa-solid fa-sun"></i>';
        btnTheme.parentElement.style.background = 'white';
        
        // Aplicar variáveis CSS para tema escuro
        document.documentElement.style.setProperty('--cor1', '#000000');
        document.documentElement.style.setProperty('--cor5', '#ffffff');
        document.documentElement.style.setProperty('--cor7', '#504f4f');
      } else {
        document.body.classList.remove('dark');
        document.querySelector('.themeContent').classList.remove('dark');
        btnTheme.innerHTML = '<i class="fa-solid fa-moon"></i>';
        btnTheme.parentElement.style.background = '#121d77';
        
        // Aplicar variáveis CSS para tema claro
        document.documentElement.style.setProperty('--cor1', '#ffffff');
        document.documentElement.style.setProperty('--cor5', '#6e6d6d');
        document.documentElement.style.setProperty('--cor7', '#f8f6f6');
      }
    };

    // Adicionar evento de clique ao botão de tema
    btnTheme.addEventListener('click', toggleTheme);

    // Aplicar tema ao carregar a página
    applyStoredTheme();
  }
}