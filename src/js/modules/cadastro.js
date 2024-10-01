const validateCadastro = () => {

  const containerPessoais = document.querySelector(".infoPessoais") 
  const containerAdicionais = document.querySelector(".infoAdicionais")
  const form = document.querySelectorAll("form.formInfoPessoais");
  const formAd = document.querySelectorAll("form.forminfoAdicionais");

  if (form.length) {

    const timeElapsed = Date.now();
    const today = new Date(timeElapsed);
    const currentYear = +today.toLocaleDateString().split("/")[2]

    const validityNasc = (event, avanco) =>{
      const nasc = +form[0][2].value.split("-").reverse()[2]
      if ((currentYear - nasc) < 16) {
        event.preventDefault();
        form[0][2].focus()
        form[0][2].style.borderBottom = "1px solid red"
        // form[0][2].setCustomValidity("Precisa ser maior de 16 anos");
      } else {
        avanco = true
      }
    }

    const emailMascara = () => {
      const re = /\S+@\S+\.\S+/;
      if(re.test(form[0][3].value) === false){
        form[0][3].setCustomValidity("email errado")
      } else {
        form[0][3].setCustomValidity("")
      }
    }

    const validitySenha = (avanco) =>{
      if (form[0][4].value !== form[0][5].value){
        form[0][5].setCustomValidity("As senhas não coincidem")
      } else {
        form[0][5].setCustomValidity("")
        return avanco = true
      }
    }

    const validityForm = () =>{
      const avanco = false;
      validityNasc(avanco);
      validitySenha(avanco);
      if (form[0][7].checked === true){
        if (avanco === true) {
          containerPessoais.display = "none"
          containerAdicionais.display = "flex"
        }
      }
    }

    const mascaraForm = () =>{
      emailMascara();
    }

    const formArray = new Array(form[0])
    console.log(formArray)
    
    formArray.forEach((element) => {
      element.addEventListener('input', mascaraForm);
    });

    form[0][6].addEventListener('click', validityForm);

  }
};

export default validateCadastro;
