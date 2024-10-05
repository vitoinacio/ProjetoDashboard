export default function fluxoLogin() {
  const form = document.querySelectorAll('form.loginForm');

  if (form.length) {
    const validaLogin = () => {
      for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (JSON.parse(localStorage.getItem(key)).email === form[0][0].value) {
          document.querySelector('.emailNaoCad').style.display = 'none';
          if (
            JSON.parse(localStorage.getItem(key)).senha === form[0][1].value
          ) {
            window.location = 'src/pages/dashboard.html';
            sessionStorage.setItem('logado', true)
          } else {
            document.querySelector('.senhaIncorreta').style.display = 'block';
            let senha = form[0][1].value.length;
            form[0][1].addEventListener('input', () => {
              if (form[0][1].value.length < senha - 2) {
                document.querySelector('.senhaIncorreta').style.display =
                  'none';
              }
            });
          }
          return;
        }
      }
      document.querySelector('.emailNaoCad').style.display = 'block';
    };

    form[0][2].addEventListener('click', validaLogin);
  }
}
