const validateCadastro = () => {

  const form = document.querySelectorAll("form.formInfoPessoais");

  if (form.length) {

    const timeElapsed = Date.now();
    const today = new Date(timeElapsed);
    const currentYear = +today.toLocaleDateString().split("/")[2]

    const validityNasc = (event) =>{
      const nasc = +form[0][2].value.split("-").reverse()[2]
      if ((currentYear - nasc) < 16) {
        event.preventDefault();
        form[0][2].focus()
        form[0][2].style.borderBottom = "1px solid red"
        // form[0][2].setCustomValidity("Precisa ser maior de 16 anos");
      }
    }

    const emailMascara = () => {
      form[0][3].value = form[0][3].value.replace(".", "/")
    }

    const validityForm = () =>{
      validityNasc();
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
