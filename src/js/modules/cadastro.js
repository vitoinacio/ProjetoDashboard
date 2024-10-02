const validateCadastro = () => {
  const containerPessoais = document.querySelector('.infoPessoais');
  const containerAdicionais = document.querySelector('.infoAdicionais');
  const form = document.querySelectorAll('form.formInfoPessoais');
  const formAd = document.querySelectorAll('form.forminfoAdicionais');

  if (form.length) {
    const timeElapsed = Date.now();
    const today = new Date(timeElapsed);
    const currentYear = +today.toLocaleDateString().split('/')[2];

    const validityNasc = (event) => {
      const nasc = +form[0][2].value.split('-').reverse()[2];
      if (currentYear - nasc < 16) {
        event.preventDefault();
        form[0][2].focus();
        form[0][2].style.borderBottom = '1px solid red';
        // form[0][2].setCustomValidity("Precisa ser maior de 16 anos");
      }
    };

    const validitySenha = () => {
      if (form[0][4].value !== form[0][5].value) {
        form[0][5].setCustomValidity('As senhas não coincidem');
        return false;
      } else {
        form[0][5].setCustomValidity('');
        return true;
      }
      return false;
    };

    const validityForm = (event) => {
      validityNasc();
      emailValidity();
      validitySenha();
      if (form[0][7].checked) {
        if (
          form[0][0].validity.valid &&
          form[0][3].validity.valid &&
          validitySenha()
        ) {
          event.preventDefault();
          setDados();
          containerAdicionais.style.display = 'flex';
          containerPessoais.style.display = 'none';
          setTimeout(() => {
            containerAdicionais.classList.add('active');
          }, 300);
        }
      }
    };

    const validityCpf = () => {
      let Soma = 0;
      let Resto;

      const strCPF = String(formAd[0][0].value).replace(/[^\d]/g, '');

      if (strCPF.length !== 11) {
        return false;
      }

      if (
        [
          '00000000000',
          '11111111111',
          '22222222222',
          '33333333333',
          '44444444444',
          '55555555555',
          '66666666666',
          '77777777777',
          '88888888888',
          '99999999999',
        ].indexOf(strCPF) !== -1
      ) {
        return false;
      }

      for (let i = 1; i <= 9; i++) {
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
      }

      Resto = (Soma * 10) % 11;

      if (Resto == 10 || Resto == 11) {
        Resto = 0;
      }

      if (Resto != parseInt(strCPF.substring(9, 10))) return false;

      Soma = 0;

      for (let i = 1; i <= 10; i++) {
        Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
      }

      Resto = (Soma * 10) % 11;

      if (Resto == 10 || Resto == 11) Resto = 0;

      if (Resto != parseInt(strCPF.substring(10, 11))) return false;

      return true;
    };

    const validityFormAd = () => {
      validityCpf()
    };

    const setDados = () => {
      const nasc = form[0][2].value.split('-').reverse().join('/');
      const client = {
        nome: form[0][0].value,
        sexo: form[0][1].value,
        dataNasc: nasc,
        email: form[0][3].value,
        senha: form[0][4].value,
      };
      window.localStorage.setItem(
        `clientId=${localStorage.length + 1}`,
        JSON.stringify(client)
      );
    };

    const setDadosAdicionais = () => {
      for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (JSON.parse(localStorage.getItem(key)).email === form[0][3].value) {
          console.log(localStorage.key(i));
        }
        const id = localStorage.key(key);
        const novoId = JSON.parse(localStorage.getItem(key));
        console.log((novoId.idade = '21'));
        console.log(novoId);
        localStorage.setItem(id, JSON.stringify(novoId));
        console.log(JSON.parse(localStorage.getItem(key)));
      }
    };

    for (let i = 0; i < localStorage.length; i++) {
      const key = localStorage.key(i);
      // if (JSON.parse(localStorage.getItem(key)).email === "ribeirokesia198@gmail.com") {
      //   console.log(localStorage.key(i))
      // }
      // const id = localStorage.key(key)
      // const novoId = JSON.parse(localStorage.getItem(key))
      // console.log(novoId.idade = "21")
      // console.log(novoId)
      // localStorage.setItem(id, JSON.stringify(novoId))
      // console.log(JSON.parse(localStorage.getItem(key)));
    }

    const emailValidity = () => {
      const re = /\S+@\S+\.\S+/;
      if (re.test(form[0][3].value) === false) {
        form[0][3].setCustomValidity('email errado');
      } else {
        form[0][3].setCustomValidity('');
      }
    };

    const cpfMaascara = () =>{
      let cpfFormat = formAd[0][0].value;

      if(isNaN(cpfFormat[cpfFormat.length-1])){ // impede entrar outro caractere que não seja número
        formAd[0][0].value = cpfFormat.substring(0, cpfFormat.length-1);
          return;
      }

      if (cpfFormat.length == 3 || cpfFormat.length == 7) formAd[0][0].value += ".";
      if (cpfFormat.length == 11) formAd[0][0].value += "-";
    }

    const cellMascara = () =>{
      let valor = formAd[0][1].value;

      // Remover caracteres não numéricos
      valor = valor.replace(/\D/g, '');

      // Adicionar máscara
      valor = valor.replace(/^(\d{2})(\d)/g, '+$1 $2');
      valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
      valor = valor.replace(/(\d)(\d{4})$/, '$1-$2');

      formAd[0][1].value = valor;
    }

    const mascaraForm = () => {
      cpfMaascara();
      cellMascara();
    };

    const formArray = new Array(form[0]).concat(new Array(formAd[0]));

    formArray.forEach((element) => {
      element.addEventListener('input', mascaraForm);
    });

    form[0][6].addEventListener('click', validityForm);
    formAd[0][7].addEventListener('click', validityFormAd);
  }
};

export default validateCadastro;
