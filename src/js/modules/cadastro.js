const validateCadastro = () => {
  const containerPessoais = document.querySelector(' div .pessoais');
  const containerAdicionais = document.querySelector('div .adicionais');
  const form = document.querySelector('form.formInfoPessoais');

  if (form.length) {
    // const timeElapsed = Date.now();
    // const today = new Date(timeElapsed);
    // const currentYear = +today.toLocaleDateString().split('/')[2];

    // const emailIndex = sessionStorage.getItem('emailIndex');

    // if (emailIndex !== null) {
    //   form.email.value = emailIndex;
    // }

    // const validityNasc = () => {
    //   const nasc = +form.dataNasc.value.split('-').reverse()[2];
    //   console.log(currentYear - nasc);
    //   if (currentYear - nasc < 16) {
    //     form.dataNasc.focus();
    //     form.dataNasc.style.borderBottom = '2px solid red';
    //     form.dataNasc.setCustomValidity('Precisa ser maior de 16 anos');
    //   } else {
    //     form.dataNasc.setCustomValidity('');
    //     form.dataNasc.style.borderBottom = '1px solid #e2dfdf';
    //   }
    // };

    // const validitySenha = () => {
    //   if (form.senha.value !== form.confirmSenha.value) {
    //     form.confirmSenha.setCustomValidity('As senhas não coincidem');
    //     form.confirmSenha.style.borderBottom = '2px solid red';
    //     return false;
    //   } else {
    //     form.confirmSenha.setCustomValidity('');
    //     form.confirmSenha.style.borderBottom = '1px solid #e2dfdf';
    //     return true;
    //   }
    //   return false;
    // };

    // const validityForm = (event) => {
    //   validityNasc();
    //   emailValidity();
    //   validitySenha();
    //   if (form[0][7].checked) {
    //     if (
    //       form.name.validity.valid &&
    //       form.email.validity.valid &&
    //       validitySenha() &&
    //       form.senha.value !== ''
    //     ) {
    //       event.preventDefault();
    //       setDados();
    //       containerAdicionais.style.display = 'flex';
    //       containerPessoais.style.display = 'none';
    //       sessionStorage.removeItem('emailIndex');
    //       setTimeout(() => {
    //         containerAdicionais.classList.add('active');
    //       }, 300);
    //     }
    //   }
    // };

    // const validityCpf = () => {
    //   let Soma = 0;
    //   let Resto;

    //   const strCPF = String(form.cpf.value).replace(/[^\d]/g, '');

    //   if (strCPF.length !== 11) {
    //     return false;
    //   }

    //   if (
    //     [
    //       '00000000000',
    //       '11111111111',
    //       '22222222222',
    //       '33333333333',
    //       '44444444444',
    //       '55555555555',
    //       '66666666666',
    //       '77777777777',
    //       '88888888888',
    //       '99999999999',
    //     ].indexOf(strCPF) !== -1
    //   ) {
    //     return false;
    //   }

    //   for (let i = 1; i <= 9; i++) {
    //     Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (11 - i);
    //   }

    //   Resto = (Soma * 10) % 11;

    //   if (Resto == 10 || Resto == 11) {
    //     Resto = 0;
    //   }

    //   if (Resto != parseInt(strCPF.substring(9, 10))) return false;

    //   Soma = 0;

    //   for (let i = 1; i <= 10; i++) {
    //     Soma = Soma + parseInt(strCPF.substring(i - 1, i)) * (12 - i);
    //   }

    //   Resto = (Soma * 10) % 11;

    //   if (Resto == 10 || Resto == 11) Resto = 0;

    //   if (Resto != parseInt(strCPF.substring(10, 11))) return false;

    //   return true;
    // };

    // const validityFormAd = () => {
    //   if (validityCpf()) {
    //     form.cpf.setCustomValidity('');
    //     form.cpf.style.borderBottom = '1px solid #e2dfdf';
    //   } else {
    //     form.cpf.setCustomValidity('cpf inválido');
    //     form.cpf.style.borderBottom = '2px solid red';
    //   }
    //   if (validityCpf() && cellMascara() && cepMascara()) {
    //     setDadosAdicionais();
    //   }
    // };

    // const setDados = () => {
    //   const nasc = form.dataNasc.value.split('-').reverse().join('/');
    //   const client = {
    //     nome: form.name.value,
    //     sexo: form.sexo.value,
    //     dataNasc: nasc,
    //     emailUser: form.email.value,
    //     senha: form.senha.value,
    //   };
    //   window.localStorage.setItem(
    //     `user=${localStorage.length + 1}`,
    //     JSON.stringify(client)
    //   );
    // };

    // const setDadosAdicionais = () => {
    //   for (let i = 0; i < localStorage.length; i++) {
    //     const key = localStorage.key(i);
    //     if (
    //       JSON.parse(localStorage.getItem(key)).emailUser === form.email.value
    //     ) {
    //       const dados = localStorage.key(i);
    //       const updateDados = JSON.parse(localStorage.getItem(key));
    //       updateDados.cpf = form.cpf.value;
    //       updateDados.telefone = form.celular.value;
    //       updateDados.cep = form.cep.value;
    //       updateDados.cidade = form.localidade.value;
    //       updateDados.bairro = form.bairro.value;
    //       updateDados.rua = form.logradouro.value;
    //       updateDados.endNum = form.numCasa.value;
    //       localStorage.setItem(dados, JSON.stringify(updateDados));
    //       sessionStorage.setItem('logedUser', key);
    //       containerPessoais.style.display = 'flex';
    //       containerAdicionais.style.display = 'none';
    //       sessionStorage.setItem('logado', true);
    //     }
    //   }
    // };

    // const emailValidity = () => {
    //   const re = /\S+@\S+\.\S+/;

    //   if (re.test(form.email.value) === false) {
    //     form.email.setCustomValidity('email inválido');
    //     form.email.style.borderBottom = '2px solid red';
    //   } else {
    //     form.email.setCustomValidity('');
    //     for (let i = 0; i < localStorage.length; i++) {
    //       const key = localStorage.key(i);
    //       if (
    //         JSON.parse(localStorage.getItem(key)).emailUser === form.email.value
    //       ) {
    //         form.email.setCustomValidity('Email ja cadastrado');
    //         form.email.style.borderBottom = '2px solid red';
    //         break;
    //       } else {
    //         form.email.setCustomValidity('');
    //         form.email.style.borderBottom = '1px solid #e2dfdf';
    //       }
    //     }
    //   }
    // };

    // const cpfMaascara = () => {
    //   let valor = form.cpf.value.replace(/\D/g, '');

    //   // Aplica a máscara
    //   valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
    //   valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
    //   valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

    //   form.cpf.value = valor;
    // };

    // const cellMascara = () => {
    //   let valor = form.celular.value;

    //   // Remover caracteres não numéricos
    //   valor = valor.replace(/\D/g, '');

    //   // Adicionar máscara
    //   valor = valor.replace(/^(\d{2})(\d)/g, '+$1 $2');
    //   valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
    //   valor = valor.replace(/(\d)(\d{4})$/, '$1-$2');

    //   form.celular.value = valor;
    //   if (form.celular.value.length < 19 && form.celular.value.length > 17) {
    //     form.celular.setCustomValidity(
    //       'Digite um numero no formato +55 (99) 99999-9999'
    //     );
    //     form.celular.style.borderBottom = '2px solid red';
    //     return false;
    //   } else {
    //     form.celular.setCustomValidity('');
    //     form.celular.style.borderBottom = '1px solid #e2dfdf';
    //     return true;
    //   }
    // };

    // const cepMascara = () => {
    //   form.cep.value = form.cep.value
    //     .replace(/\D/g, '')
    //     .replace(/^(\d{5})(\d)/, '$1-$2');

    //   if (form.cep.value.length === 9) {
    //     cepComplete();
    //     return true;
    //   } else if (form.cep.value.length < 9) {
    //     limpaCep();
    //     return false;
    //   }
    // };

    // const mascaraForm = () => {
    //   cpfMaascara();
    //   cellMascara();
    //   cepMascara();
    //   form.numCasa.value = form.numCasa.value.replace(/\D/g, '');
    // };

    // const limpaCep = () => {
    //   form.cep.value = '';
    //   form.cep.value = '';
    //   form.cep.value = '';

    //   form.cep.disabled = false;
    //   form.cep.disabled = false;
    //   form.cep.disabled = false;
    // };

    // const cepComplete = () => {
    //   fetch(
    //     `https://viacep.com.br/ws/${form.cep.value.replace(
    //       /\D/g,
    //       ''
    //     )}/json/`
    //   )
    //     .then((cep) => cep.json())
    //     .then((cep) => {
    //       cep.localidade !== ''
    //         ? (form.localidade.value = cep.localidade)
    //         : (form.localidade.value = form.localidade.value);
    //       cep.bairro !== ''
    //         ? (form.bairro.value = cep.bairro)
    //         : (form.bairro.value = form.bairro.value);
    //       cep.logradouro !== ''
    //         ? (form.logradouro.value = cep.logradouro)
    //         : (form.logradouro.value = form.logradouro.value);

    //       cep.localidade !== ''
    //         ? (form.localidade.disabled = true)
    //         : (form.localidade.disabled = false);
    //       cep.bairro !== ''
    //         ? (form.bairro.disabled = true)
    //         : (form.bairro.disabled = false);
    //       cep.logradouro !== ''
    //         ? (form.logradouro.disabled = true)
    //         : (form.logradouro.disabled = false);
    //     });
    // };

    // fetch(
    //   `https://viacep.com.br/ws/23097620/json/`
    // ).then((cep) => cep.json()).then((cep)=>console.log(cep))

    // console.log(form)

    // const formArray = new Array(form);

    // formArray.forEach((element) => {
    //   element.addEventListener('input', mascaraForm);
    // });

    // document.querySelector('#btnAvancarCad').addEventListener('click', validityForm);
    document.querySelector('#btnAvancarCad').addEventListener('click', ()=>{
      containerAdicionais.style.display = 'flex'
      containerPessoais.style.display = 'none'
    });
  }
};

export default validateCadastro;
