const validarEmail = (email) => {
  const re = /\S+@\S+\.\S+/;
  return re.test(email);
};

export default function cadastreSe() {
  const btn = document.querySelector('#btnCadastreSe');
  if (btn) {
    btn.addEventListener('click', () => {
      const email = document.querySelector('#emailIndex');
      if (validarEmail(email.value)) {
        sessionStorage.setItem('emailIndex', email.value);
        window.location = 'src/pages/cadastro.html';
      } else {
        const error = document.createElement('p')
        error.textContent = 'Por favor, insira um email válido.'
        error.style.color = 'red'
        error.style.display = 'absolute'
        error.style.top = '-110px'
        error.style.fontSize = '0.8rem'
        error.style.fontWeight = 'bold'
        error.style.textAlign = 'center'
        console.log(btn.previousElementSibling.appendChild(error))
        email.addEventListener('input', ()=>{
          error.remove()
        })
      }
    });
  }
}