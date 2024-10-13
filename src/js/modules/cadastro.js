export default function validateCadastro() {
  const form = document.querySelector('form.formInfoPessoais');
  
  if (form) {
    if (sessionStorage.getItem('logado') === 'true'){
      // Redireciona o usuário para a página de planejamento
      window.location = ' /src/pages/planejamento.html';
      console.log('teste')
    }
    
    const containerPessoais = document.querySelector('div .pessoais');
    const containerAdicionais = document.querySelector('div .adicionais');
    const progressBar = document.querySelector('.cadastro-progressBar');
    const timeElapsed = Date.now();
    const today = new Date(timeElapsed);
    const currentYear = +today.toLocaleDateString().split('/')[2];
    
    const emailIndex = sessionStorage.getItem('emailIndex');
    if (emailIndex !== null) {
      form.email.value = emailIndex;
    }
    
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
      error.style.top = `${reference.offsetTop + 40}px`;
      error.style.left = `${Math.trunc(posi.x)}px`;
    
      // Insere o elemento de erro após o elemento de referência
      reference.parentNode.insertBefore(error, reference.nextSibling);
    }
    
    const removeError = (reference) => {
      // Seleciona o elemento de erro
      const error = document.querySelector('.error');
    
      // Remove o elemento de erro se ele existir e for filho do elemento de referência
      if (error && error.classList.contains('error')) {
        error.parentNode.removeChild(error);
      }
    };

    const validadeNome = () => {
      if (form.name.value.length < 10) {
        form.name.focus();
        form.name.style.borderBottom = '2px solid red';
        setError(form.name,'Insira seu nome e sobrenome');
        return false
      } else {
        removeError(form.name);
        form.name.style.borderBottom = '1px solid #e2dfdf';
        return true;
      }
    }

    const validadeSexo = () => {
      if (form.sexo.value === "") {
        setError(form.sexo,'Selecione seu Sexo');
        form.sexo.focus();
        form.sexo.style.borderBottom = '2px solid red';
        return false
      } else {
        removeError(form.sexo)
        form.sexo.style.borderBottom = '1px solid #e2dfdf';
        return true;
      }
    }

  
    const validadeNasc = () => {
      const nasc = +form.dataNasc.value.split('-').reverse()[2];
      if (form.dataNasc.value === "") {
        form.dataNasc.focus();
        form.dataNasc.style.borderBottom = '2px solid red';
        setError(form.dataNasc, 'Insira sua data de nascimento',);
        return false
      } else {
        removeError(form.dataNasc);
        if (currentYear - nasc < 16) {
          form.dataNasc.focus();
          form.dataNasc.style.borderBottom = '2px solid red';
          setError(form.dataNasc, 'Precisa ser maior que 16 anos',)
          return false;
        } else {
          form.dataNasc.style.borderBottom = '1px solid #e2dfdf';
          removeError(form.dataNasc);
          return true;
        }
      }
    };

    const validadeEmail = () => {
      const re = /\S+@\S+\.\S+/;
      if (form.email.value === '') {
        removeError(form.email);
        setError(form.email,'Digite seu Email');
        form.email.focus();
        form.email.style.borderBottom = '2px solid red';
        return false;
      }else if (!re.test(form.email.value)) {
        removeError(form.email);
        setError(form.email,'Email inválido');
        form.email.focus();
        form.email.style.borderBottom = '2px solid red';
        return false;
      } else if(form.email.value.split('@')[1].includes(',')){
        removeError(form.email);
        setError(form.email,'Email inválido');
        form.email.focus();
        form.email.style.borderBottom = '2px solid red';
        return false;
      }else {
        removeError(form.email);
        form.email.style.borderBottom = '1px solid #e2dfdf';
        for (let i = 0; i < localStorage.length; i++) {
          const key = localStorage.key(i);
          if (JSON.parse(localStorage.getItem(key)).emailUser === form.email.value) {
            setError(form.email,'Email já cadastrado');
            form.email.style.borderBottom = '2px solid red';
            return false;
          }
        }
        form.email.style.borderBottom = '1px solid #e2dfdf';
        return true;
      }
    };

    const validadeSenha = () => {
      if (form.senha.value === '') {
        form.senha.focus()
        setError(form.senha, 'Digite uma senha')
        form.senha.style.borderBottom = '2px solid red';
        return false;
      } else {
        removeError(form.senha);
        form.senha.style.borderBottom = '1px solid #e2dfdf';
        if (form.confirmSenha.value === '') {
          form.confirmSenha.focus();
          setError(form.confirmSenha,'Confirme sua senha');
          form.confirmSenha.style.borderBottom = '2px solid red';
        } else {
          removeError(form.confirmSenha);
          form.confirmSenha.style.borderBottom = '1px solid #e2dfdf';
          if (form.senha.value !== form.confirmSenha.value) {
            form.confirmSenha.focus();
            setError(form.confirmSenha,'As senhas não coincidem');
            form.confirmSenha.style.borderBottom = '2px solid red';
            return false;
          } else {
            removeError(form.confirmSenha);
            form.confirmSenha.style.borderBottom = '1px solid #e2dfdf';
            return true;
          }
        }
      }
    };

    const validadeTermos = () => {
      if (!form.termos.checked) {
        setError(form.termos,'Aceite os termos para prosseguir');
        form.termos.style.borderBottom = '2px solid red';
        return false
      } else {
        removeError(form.termos);
        form.termos.style.borderBottom = '1px solid #e2dfdf';
        return true
      }
    }

    const validadeCpf = () => {
      let Soma = 0;
      let Resto;
      const strCPF = String(form.cpf.value).replace(/[^\d]/g, '');
  
      if (strCPF.length !== 11 || [
        '00000000000', '11111111111', '22222222222', '33333333333',
        '44444444444', '55555555555', '66666666666', '77777777777',
        '88888888888', '99999999999'
      ].indexOf(strCPF) !== -1) {
        removeError(form.cpf)
        form.cpf.focus()
        form.cpf.style.borderBottom = '2px solid red';
        setError(form.cpf, 'Digite um cpf válido')
        return false;
      }
  
      for (let i = 1; i <= 9; i++) {
        Soma += parseInt(strCPF.substring(i - 1, i)) * (11 - i);
      }
      Resto = (Soma * 10) % 11;
      if (Resto == 10 || Resto == 11) Resto = 0;
      if (Resto != parseInt(strCPF.substring(9, 10))){
        removeError(form.cpf)
        form.cpf.focus()
        form.cpf.style.borderBottom = '2px solid red';
        setError(form.cpf, 'Digite um cpf válido')
        setTimeout(()=>{removeError(form.cpf)},300)
        return false;
      }
  
      Soma = 0;
      for (let i = 1; i <= 10; i++) {
        Soma += parseInt(strCPF.substring(i - 1, i)) * (12 - i);
      }
      Resto = (Soma * 10) % 11;
      if (Resto == 10 || Resto == 11) Resto = 0;
      if (Resto != parseInt(strCPF.substring(10, 11))){ 
        removeError(form.cpf)
        form.cpf.focus()
        form.cpf.style.borderBottom = '2px solid red';
        setError(form.cpf, 'Digite um cpf válido')
        return false;
      }

      removeError(form.cpf)
      form.cpf.style.borderBottom = '1px solid #e2dfdf';
      return true;
    };
  
    const cpfMascara = () => {
      let valor = form.cpf.value.replace(/\D/g, '');
      valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
      valor = valor.replace(/(\d{3})(\d)/, '$1.$2');
      valor = valor.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      form.cpf.value = valor;
    };

    const validadeCell = () => {
      if (form.celular.value.length < 19 || form.celular.value.length > 19) {
        form.celular.focus()
        setError(form.celular,'Digite um número no formato +55 (99) 99999-9999');
        form.celular.style.borderBottom = '2px solid red';
        return false;
      } else {
        removeError(form.celular);
        form.celular.style.borderBottom = '1px solid #e2dfdf';
        return true;
      }
    }
  
    const cellMascara = () => {
      let valor = form.celular.value.replace(/\D/g, '');
      valor = valor.replace(/^(\d{2})(\d)/g, '+$1 $2');
      valor = valor.replace(/(\d{2})(\d)/, '($1) $2');
      valor = valor.replace(/(\d)(\d{4})$/, '$1-$2');
      form.celular.value = valor;
    };
  
    const cepMascara = () => {
      form.cep.value = form.cep.value.replace(/\D/g, '').replace(/^(\d{5})(\d)/, '$1-$2');
      if (form.cep.value.length === 9) {
        cepComplete();
        return true;
      } else {
        limpaCep();
        return false;
      }
    };
  
    const limpaCep = () => {
      form.localidade.value = '';
      form.bairro.value = '';
      form.logradouro.value = '';
      form.localidade.disabled = false;
      form.bairro.disabled = false;
      form.logradouro.disabled = false;
    };
  
    const cepComplete = () => {
      fetch(`https://viacep.com.br/ws/${form.cep.value.replace(/\D/g, '')}/json/`)
        .then((cep) => cep.json())
        .then((cep) => {
          console.log(cep)
          if (cep.localidade) form.localidade.value = cep.localidade;
          if (cep.bairro) form.bairro.value = cep.bairro;
          if (cep.logradouro) form.logradouro.value = cep.logradouro;
          form.localidade.disabled = !!cep.localidade;
          form.bairro.disabled = !!cep.bairro;
          form.logradouro.disabled = !!cep.logradouro;
        });
    };

    const validadecep = () => {
      if (form.cep.value === "") {
        form.cep.focus()
        setError(form.cep,'Digite seu cep');
        form.cep.style.borderBottom = '2px solid red';
        return false
      } else {
        removeError(form.cep);
        form.cep.style.borderBottom = '1px solid #e2dfdf';
        return true
      }
    }

    const validadeLocalidade = () =>{
      if (form.localidade.value === '') {
        form.localidade.focus()
        setError(form.localidade,'Digite sua cidade');
        form.localidade.style.borderBottom = '2px solid red';
        return false
      } else {
        removeError(form.localidade);
        form.localidade.style.borderBottom = '1px solid #e2dfdf';
        return true
      }
    }
    const validadeBairro = () =>{
      if (form.bairro.value === '') {
        form.bairro.focus()
        setError(form.bairro,'Digite sua cidade');
        form.cep.bairro.borderBottom = '2px solid red';
        return false
      } else {
        removeError(form.bairro);
        form.bairro.style.borderBottom = '1px solid #e2dfdf';
        return true
      }
    }
    const validadeLogradouro = () =>{
      if (form.logradouro.value === '') {
        form.logradouro.focus()
        setError(form.logradouro,'Digite sua cidade');
        form.cep.logradouro.borderBottom = '2px solid red';
        return false
      } else {
        removeError(form.logradouro);
        form.logradouro.style.borderBottom = '1px solid #e2dfdf';
        return true
      }
    }

    const validadeNumCasa = () => {
      if (form.numCasa.value === '') {
        form.numCasa.focus()
        setError(form.numCasa,'Digite sua cidade');
        form.cep.numCasa.borderBottom = '2px solid red';
        return false
      } else {
        removeError(form.numCasa);
        form.numCasa.style.borderBottom = '1px solid #e2dfdf';
        return true
      }
    }
  
    const mascaraForm = () => {
      cpfMascara();
      cellMascara();
      cepMascara();
      form.numCasa.value = form.numCasa.value.replace(/\D/g, '');
    };
  
    const setDados = () => {
      const nasc = form.dataNasc.value.split('-').reverse().join('/');
      const client = {
        nome: form.name.value,
        sexo: form.sexo.value,
        dataNasc: nasc,
        emailUser: form.email.value,
        senha: form.senha.value,
        cpf: form.cpf.value,
        telefone: form.celular.value,
        cep: form.cep.value,
        cidade: form.localidade.value,
        bairro: form.bairro.value,
        rua: form.logradouro.value,
        endNum: form.numCasa.value,
      };
      window.localStorage.setItem(`user=${localStorage.length + 1}`, JSON.stringify(client));
      sessionStorage.setItem('logedUser', `user=${localStorage.length}`);
      sessionStorage.setItem('logado', true);
      progressBar.classList.remove('active');
      progressBar.classList.remove('activePlus');
    };
    
    const validadeForm = (event) => {
      let isValid = false;
    
      if (event.target.id === 'btnAvancarCad') {
        isValid = validadeNome() && validadeSexo() && validadeNasc() && validadeEmail() && validadeSenha() && validadeTermos();
        if (isValid) {
          containerAdicionais.style.display = 'flex';
          containerPessoais.style.display = 'none';
          sessionStorage.removeItem('emailIndex');
          setTimeout(() => {
            progressBar.classList.add('active');
          }, 300);
        }
      } else if (event.target.id === 'btnCadastro') {
        isValid = validadeCpf() && validadeCell() && validadecep() && cepMascara() && validadeLocalidade() && validadeBairro() && validadeLogradouro() && validadeNumCasa();
        if (isValid) {
          setDados();
          containerAdicionais.style.display = 'none';
          containerPessoais.style.display = 'flex';
          setTimeout(() => {
            progressBar.classList.add('activePlus');
          }, 300);
        }
      }
    
      // Prevenir o comportamento padrão se a validação falhar
      if (!isValid) {
        event.preventDefault();
      }
    };
  
    form.addEventListener('input', mascaraForm);
    document.querySelector('#btnAvancarCad').addEventListener('click', validadeForm);
    document.querySelector('#btnCadastro').addEventListener('click', validadeForm);
  }
};
