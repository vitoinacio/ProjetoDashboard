const validateCadastro = () => {
  const containerPessoais = document.querySelector('.infoPessoais');
  const containerAdicionais = document.querySelector('.infoAdicionais');
  const form = document.querySelectorAll('form.formInfoPessoais');
  const formAd = document.querySelectorAll('form.forminfoAdicionais');

  if (form.length) {
    const timeElapsed = Date.now();
    const today = new Date(timeElapsed);
    const currentYear = +today.toLocaleDateString().split('/')[2];

    const validityNasc = () => {
      const nasc = +form[0][2].value.split('-').reverse()[2];
      console.log(currentYear - nasc)
      if ((currentYear - nasc) < 16) {
        form[0][2].focus();
        form[0][2].style.borderBottom = '2px solid red';
        form[0][2].setCustomValidity("Precisa ser maior de 16 anos");
      } else {
        form[0][2].setCustomValidity("");
        form[0][2].style.borderBottom = '1px solid #e2dfdf';
      }
    };

    const validitySenha = () => {
      if (form[0][4].value !== form[0][5].value) {
        form[0][5].setCustomValidity('As senhas não coincidem');
        form[0][5].style.borderBottom = '2px solid red';
        return false;
      } else {
        form[0][5].setCustomValidity('');
        form[0][5].style.borderBottom = '1px solid #e2dfdf';
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
          validitySenha() && (form[0][4].value !== "")
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
    if  (validityCpf()){
      formAd[0][0].setCustomValidity("")
      formAd[0][0].style.borderBottom = '1px solid #e2dfdf';
    } else {
      formAd[0][0].setCustomValidity("cpf inválido")
      formAd[0][0].style.borderBottom = '2px solid red';
    }
    if (validityCpf() && cellMascara() && cepMascara()) {
      setDadosAdicionais();
    }

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
          const dados = localStorage.key(i);
          const updateDados = JSON.parse(localStorage.getItem(key));
          updateDados.cpf = formAd[0][0].value
          updateDados.telefone = formAd[0][1].value
          updateDados.cep = formAd[0][2].value
          updateDados.cidade = formAd[0][3].value
          updateDados.bairro = formAd[0][4].value
          updateDados.rua = formAd[0][5].value
          updateDados.endNum = formAd[0][6].value
          localStorage.setItem(dados, JSON.stringify(updateDados));
          containerPessoais.style.display = 'flex';
          containerAdicionais.style.display = 'none';
        }
      }
    };

    const emailValidity = () => {
      const re = /\S+@\S+\.\S+/;
      
      
      if (re.test(form[0][3].value) === false) {
        form[0][3].setCustomValidity('email inválido');
        form[0][3].style.borderBottom = '2px solid red';
      } else {
        form[0][3].setCustomValidity('');
        for (let i = 0; i < localStorage.length; i++) {
          const key = localStorage.key(i);
          if (JSON.parse(localStorage.getItem(key)).email === form[0][3].value){
            form[0][3].setCustomValidity("Email ja cadastrado")
            form[0][3].style.borderBottom = '2px solid red';
            break
          } else{
            form[0][3].setCustomValidity('');
            form[0][3].style.borderBottom = '1px solid #e2dfdf';
          }
        }
      }
    }

    const cpfMaascara = () =>{
        let valor = formAd[0][0].value.replace(/\D/g, '');

        // Aplica a máscara
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
        valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

        formAd[0][0].value = valor;
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
      if (formAd[0][1].value.length < 19) {
        formAd[0][1].setCustomValidity('Digite um numero no formato +55 (99) 99999-9999')
        formAd[0][1].style.borderBottom = '2px solid red';
        return false
      } else {
        formAd[0][1].setCustomValidity("")
        formAd[0][1].style.borderBottom = '1px solid #e2dfdf';
        return true
      }
    }

    const cepMascara = () =>{
      formAd[0][2].value = formAd[0][2].value
      .replace(/\D/g, '')
      .replace(/^(\d{5})(\d)/, '$1-$2'); 
      
      if (formAd[0][2].value.length === 9) {
        cepComplete();
        return true
      } else if (formAd[0][2].value.length < 9) {
        limpaCep();
        return false
      }
    }

    const mascaraForm = () => {
      cpfMaascara();
      cellMascara()
      cepMascara();
      formAd[0][6].value = formAd[0][6].value.replace(/\D/g, '')
    };

    const limpaCep = () => {
      formAd[0][3].value = "";
      formAd[0][4].value = "";
      formAd[0][5].value = "";

      formAd[0][3].disabled = false;
      formAd[0][4].disabled = false;
      formAd[0][5].disabled = false;

    }

    const cepComplete = () => {
      fetch(`https://viacep.com.br/ws/${formAd[0][2].value.replace(/\D/g, '')}/json/`)
        .then((cep)=> cep.json())
        .then((cep) => {
        cep.localidade !== "" ? formAd[0][3].value = cep.localidade: formAd[0][3].value = formAd[0][3].value;
        cep.bairro     !== "" ? formAd[0][4].value = cep.bairro    : formAd[0][4].value = formAd[0][4].value;
        cep.logradouro !== "" ? formAd[0][5].value = cep.logradouro: formAd[0][5].value = formAd[0][5].value;

        cep.localidade !== "" ? formAd[0][3].disabled = true: formAd[0][3].disabled = false;
        cep.bairro     !== "" ? formAd[0][4].disabled = true: formAd[0][4].disabled = false;
        cep.logradouro !== "" ? formAd[0][5].disabled = true: formAd[0][5].disabled = false;

      })
    }

    const formArray = new Array(form[0]).concat(new Array(formAd[0]));

    formArray.forEach((element) => {
      element.addEventListener('input', mascaraForm);
    });

    form[0][6].addEventListener('click', validityForm);
    form[0][6].addEventListener('submit', event =>{
      event.preventDefault();
    });
    formAd[0][7].addEventListener('click', validityFormAd);
    formAd[0][7].addEventListener('submit', event => {
      event.preventDefault();
    });
  }
};

export default validateCadastro;
