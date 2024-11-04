const validarEmail = (email) => {
  const re = /\S+@\S+\.\S+/;
  return re.test(email);
};

function setError(reference, text) {
  // Obtém a posição do elemento de referência
  const posi = reference.getBoundingClientRect();

  // Cria o elemento de erro
  const error = document.createElement('p');
  error.classList.add('error');
  error.innerText = text;
  
  // Define o estilo do elemento de erro
  error.style.position = 'absolute';
  error.style.color = 'red';
  error.style.zIndex = '1';
  error.style.fontSize = '10px';
  error.style.top = `${reference.offsetTop + 60}px`;
  error.style.left = `${Math.trunc(posi.x) - posi.x + 20}px`;

  window.onresize = () => {
    const posi = reference.getBoundingClientRect();
    error.style.top = `${reference.offsetTop + 60}px`;
    error.style.left = `${Math.trunc(posi.x)- posi.x + 20}px`;
  }
  // Insere o elemento de erro após o elemento de referência
  reference.parentNode.insertBefore(error, reference.nextSibling);
}

const removeError = () => {
  // Seleciona o elemento de erro
  const error = document.querySelector('.error');

  // Remove o elemento de erro se ele existir e for filho do elemento de referência
  if (error && error.classList.contains('error')) {
    error.parentNode.removeChild(error);
  }
};

export default function cadastreSe() {
  const btn = document.querySelector('#btnCadastreSe');
  if (btn) {
    btn.addEventListener('click', () => {
      const email = document.querySelector('#emailIndex');
      if (email.value === '') {
        removeError()
        setError(email, 'Digite seu email');
        email.focus();
        email.style.border = '1px solid red'
        email.addEventListener('input', ()=>{
          removeError()
          email.style.border = '1px solid var(--cor2)'
        })
      } else if (validarEmail(email.value)) {
        sessionStorage.setItem('emailIndex', email.value);
        window.location = 'src/pages/cadastro.html';
      } else {
        removeError()
        setError(email, 'Digite um email válido');
        email.focus();
        email.style.border = '1px solid red'
        email.addEventListener('input', ()=>{
          removeError()
          email.style.border = '1px solid var(--cor2)'
        })
      }
    });
  }
}