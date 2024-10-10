export default function theme() {
  const btnThemes = document.querySelectorAll('#theme');
  if (btnThemes.length) {

    // Função para alternar o tema
    const toggleTheme = () => {
      const isDarkMode = document.body.classList.contains('dark');
      if (isDarkMode) {
        document.body.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        document.querySelector('.themeContent').classList.remove('dark');
        
        // Alterar variáveis CSS para tema claro
        document.documentElement.style.setProperty('--cor1', '#ffffff');
        document.documentElement.style.setProperty('--cor5', '#6e6d6d');
        document.documentElement.style.setProperty('--cor7', '#f8f6f6');
        
        // Atualizar estilo dos botões
        btnThemes.forEach(btn => {
          setTimeout(()=>{btn.innerHTML = '<i class="fa-solid fa-moon"></i>';},500)
          btn.parentElement.style.background = '#121d77';
        });
      } else {
        document.body.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        document.querySelector('.themeContent').classList.add('dark');
        
        // Alterar variáveis CSS para tema escuro
        document.documentElement.style.setProperty('--cor1', '#000000');
        document.documentElement.style.setProperty('--cor5', '#ffffff');
        document.documentElement.style.setProperty('--cor7', '#333333');
        
        // Atualizar estilo dos botões
        btnThemes.forEach(btn => {
          setTimeout(()=>{btn.innerHTML = '<i class="fa-solid fa-sun"></i>';},500)
          btn.parentElement.style.background = 'white';
        });
      }
    };

    // Aplicar tema com base na preferência armazenada
    const applyStoredTheme = () => {
      const storedTheme = localStorage.getItem('theme');
      if (storedTheme === 'dark') {
        document.body.classList.add('dark');
        document.querySelector('.themeContent').classList.add('dark');
        
        // Aplicar variáveis CSS para tema escuro
        document.documentElement.style.setProperty('--cor1', '#000000');
        document.documentElement.style.setProperty('--cor5', '#ffffff');
        document.documentElement.style.setProperty('--cor7', '#333333');
        
        // Atualizar estilo dos botões
        btnThemes.forEach(btn => {
          setTimeout(()=>{btn.innerHTML = '<i class="fa-solid fa-sun"></i>';},500)
          btn.parentElement.style.background = 'white';
        });
      } else {
        document.body.classList.remove('dark');
        document.querySelector('.themeContent').classList.remove('dark');
        
        // Aplicar variáveis CSS para tema claro
        document.documentElement.style.setProperty('--cor1', '#ffffff');
        document.documentElement.style.setProperty('--cor5', '#6e6d6d');
        document.documentElement.style.setProperty('--cor7', '#f8f6f6');
        
        // Atualizar estilo dos botões
        btnThemes.forEach(btn => {
          setTimeout(()=>{btn.innerHTML = '<i class="fa-solid fa-moon"></i>';},500)
          btn.parentElement.style.background = '#121d77';
        });
      }
    };

    // Adicionar evento de clique a cada botão de tema
    btnThemes.forEach(btn => {
      btn.addEventListener('click', toggleTheme);
    });

    // Aplicar tema ao carregar a página
    applyStoredTheme();
  }
}