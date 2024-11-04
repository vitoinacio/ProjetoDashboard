// function getLoginForm() {
//   return document.querySelector('form.loginForm');
// }

// function getStoredUser(key) {
//   return JSON.parse(localStorage.getItem(key));
// }

function setError(reference, text) {
  //obtem o item content do form
  const content = document.querySelector('.modal-content');
  let styleContent = getComputedStyle(content);
  let padding = +styleContent.padding.split(' ')[1].replace('px', '');

  // Obtém a posição do elemento de referência
  let posi = reference.getBoundingClientRect();

  // Cria o elemento de erro
  const error = document.createElement('p');
  error.classList.add('errorLogin');
  error.innerText = text;

  // Define o estilo do elemento de erro
  error.style.position = 'absolute';
  error.style.color = 'red';
  error.style.zIndex = '1';
  error.style.fontSize = '10px';
  error.style.top = `${reference.offsetTop + 55}px`;
  error.style.left = `${Math.trunc(posi.x) - posi.x + padding}px`;
  window.onresize = () =>{
    styleContent = getComputedStyle(content);
    padding = +styleContent.padding.split(' ')[1].replace('px', '');
    posi = reference.getBoundingClientRect();
    error.style.left = `${Math.trunc(posi.x) - posi.x + padding}px`;
  }

  // Insere o elemento de erro após o elemento de referência
  reference.parentNode.insertBefore(error, reference.nextSibling);
}

const removeError = () => {
  // Seleciona o elemento de erro
  const error = document.querySelector('.errorLogin');

  // Remove o elemento de erro se ele existir e for filho do elemento de referência
  if (error && error.classList.contains('errorLogin')) {
    error.parentNode.removeChild(error);
  }
};

// function redirectToDashboard() {
//   window.location = 'src/pages/dashboard.html';
// }

function handleInput(form) {
  form[0].addEventListener('input', () => {
    removeError(form[0]);
  });
  form[1].addEventListener('input', () => {
    removeError(form[1]);
  });
}

function validateLogin(form) {
  for (let i = 0; i < localStorage.length; i++) {
    const key = localStorage.key(i);
    const storedUser = getStoredUser(key);
    if (form[0].value === '') {
      removeError(form[0]);
      setError(form[0], 'Digite seu email');
      form[0].focus();
      handleInput(form);
    } else if(form[0].value !== storedUser.emailUser) {
      removeError(form[0]);
      setError(form[0], 'Email não cadastrado');
      form[0].focus()
      handleInput(form);
    }else {
      if (storedUser.emailUser === form[0].value) {
        removeError(form[0]);
        if(form[1].value === '') {
          setError(form[1], 'Digite sua senha');
          form[1].focus();
          handleInput(form);
        } else {
          if (storedUser.senha === form[1].value) {
            sessionStorage.setItem('logado', 'true');
            sessionStorage.setItem('logedUser', key);
            redirectToDashboard();
          } else {
            setError(form[1], 'Senha incorreta');
            handleInput(form);
          }
        }
      }
    }
  }
}

export default function fluxoLogin() {
  const form = getLoginForm();

  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      validateLogin(form);
    });
  } else {
    console.error('Formulário de login não encontrado.');
  }
}