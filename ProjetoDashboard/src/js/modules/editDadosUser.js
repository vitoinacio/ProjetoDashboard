export default function editDadosUser() {
  const form = document.querySelector('.formUser');
  if (form) {
    const editButtons = document.querySelectorAll('.editUser');

    // Função para cancelar a edição
    const cancelEdit = (input, btn, cancel, confirm) => {
      cancel.addEventListener('click', () => {
        const userKey = sessionStorage.getItem('logedUser');
        const userData = JSON.parse(localStorage.getItem(userKey));
        input.value = userData[input.id];
        resetInputState(input, btn, cancel, confirm);
        if(input.id === 'senha') {
          input.type = 'password'
        }
      });
    };

    // Função para confirmar a edição e salvar os dados
    const confirmEdit = (input, btn, cancel, confirm) => {
      confirm.addEventListener('click', () => {
        const userKey = sessionStorage.getItem('logedUser');
        const userData = JSON.parse(localStorage.getItem(userKey));
        if (input.id === 'dataNasc') {
          if (input.value.length < 10) {
            input.setCustomValidity('Insira uma data valida')
            confirm.disabled = true
            setTimeout(()=>{confirm.disabled = false},300)
            console.log(false)
          } else if(input.value.length >= 10) {
            input.setCustomValidity('')
            console.log(true)
            userData[input.id] = input.value;
            localStorage.setItem(userKey, JSON.stringify(userData));
            resetInputState(input, btn, cancel, confirm);
          }
        } else {
          userData[input.id] = input.value;
          localStorage.setItem(userKey, JSON.stringify(userData));
          resetInputState(input, btn, cancel, confirm);
          if(input.id === 'senha') {
            input.type = 'password'
          }
        }
      });
    };

    // Função para resetar o estado do input após cancelar ou confirmar a edição
    const resetInputState = (input, btn, cancel, confirm) => {
      input.disabled = true;
      input.style.background = 'var(--cor6)';
      input.style.outline = 'none';
      cancel.style.display = 'none';
      confirm.style.display = 'none';
      btn.style.display = 'block';
    };

    // Função para habilitar a edição do input
    const enableEdit = (input, btn, cancel, confirm) => {
      if(input.id === 'senha') {
        input.type = 'text'
      }
        input.disabled = false;
        input.style.background = '#fff';
        input.style.outline = '2px solid var(--cor2)';
        input.focus();
        btn.style.display = 'none';
        cancel.style.display = 'block';
        confirm.style.display = 'block';
        confirmEdit(input, btn, cancel, confirm);
        cancelEdit(input, btn, cancel, confirm);
    
    };

    // Adicionar evento de clique aos botões de edição
    editButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        const divPai = btn.parentElement;
        const input = divPai.querySelector('input')
        const cancel = divPai.querySelector('.cancelEdit')
        const confirm = divPai.querySelector('.confirmUser')
        enableEdit(input, btn, cancel, confirm);
      });
    });
  }
}