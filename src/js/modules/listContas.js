export default function todoList() {
  const form = document.querySelectorAll('form.formPLanejamento');
  const formMobile = document.querySelectorAll('form.mobile');

  if (form.length || formMobile.length) {
    const gastosTotais = document.querySelector('#totaisGastos');

    const addTodo = (model, selector) => {
      const lista = document.querySelector(selector);
      lista.innerHTML += model;
    };

    const addEvents = () => {
      const btnCheck = document.querySelectorAll('.btncheck');
      const btnTrash = document.querySelectorAll('.btntrash');

      btnCheck.forEach((btn) => {
        btn.addEventListener('click', () => {
          const parentElement = btn.parentElement.parentElement;
          const id = btn.getAttribute('data-id');

          fetch('../php/update_debito.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&action=update`
          })
          .then(response => response.text())
          .then(data => {
            if (data === 'success') {
              parentElement.style.textDecoration = 'line-through';
              parentElement.setAttribute('title', 'Pago');
              parentElement.style.backgroundColor = '#e2dfdf';
              parentElement.style.color = '#6e6d6d';
              btn.style.backgroundColor = '#504f4f';
              btn.disabled = true;
            } else {
              console.error('Erro ao atualizar o débito: ' + data);
            }
          })
          .catch(error => {
            console.error('Erro:', error);
          });
        });
      });

      btnTrash.forEach((btn) => {
        btn.addEventListener('click', () => {
          const item = btn.parentElement.parentElement;
          const id = btn.getAttribute('name');

          fetch('../php/update_debito.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&action=delete`
          })
          .then(response => response.text())
          .then(data => {
            if (data === 'success') {
              item.remove();
            } else {
              console.error('Erro ao excluir o débito: ' + data);
            }
          })
          .catch(error => {
            console.error('Erro:', error);
          });
        });
      });
    };

    const checkDueDate = (item) => {
      const today = new Date();
      const dueDateText = item.querySelector('.vencimentotodo').innerText;
      const dueDate = new Date(dueDateText.split('/').reverse().join('-'));

      const diffTime = dueDate - today;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      if (diffDays <= 10) {
        item.style.backgroundColor = '#f7921f';
        item.setAttribute('title', 'Faltam menos de 10 dias para o vencimento');
      }
    };

    const addCont = () => {
      const model = createModel(form);
      if (validyInputs(form)) {
        addTodo(model, '.listtodo');
        const item = document.querySelector('.listtodo').lastElementChild;
        checkDueDate(item);
        addEvents();
      }
    };

    const addContMobile = () => {
      const model = createModel(formMobile);
      if (validyInputs(formMobile)) {
        addTodo(model, '.listtodo');
        const item = document.querySelector('.listtodo').lastElementChild;
        checkDueDate(item);
        addEvents();
      }
    };

    const createModel = (form) => {
      return `<li class="todo">
                <h3 class="identif" style="text-align: center; font-weight: bold;">${form[0][0].value}</h3>
                <h3 class="obstodo" style="flex:25%;">${form[0][1].value}</h3>
                <h3 class="precotodo" style="text-align: center; font-weight: bold;">${form[0][2].value}</h3>
                <h3 class="vencimentotodo" style="text-align: center; font-weight: bold;">${form[0][3].value.split('-').reverse().join('/')}</h3>
                <h3 class="notftodo" style="text-align: center; font-weight: bold;">${form[0][4].value === '1' ? 'Sim' : 'Não'}</h3>
                <div class="btnstodo">
                  <button class="btncheck" data-id="${form[0][5].value}"> Pago <i class="fa-solid fa-check"></i> </button>
                  <button class="btntrash" name="${form[0][5].value}"> Excluir <i class="fa-solid fa-trash"></i> </button>
                </div>
              </li>`;
    };

    const validyInputs = (form) => {
      let isValid = true;

      const setError = (element) => {
        element.style.borderBottom = '2px solid red';
        form[0][5].disabled = true;
        setTimeout(() => { form[0][5].disabled = false }, 200);
        isValid = false;
      };

      if (form[0][0].value.length === 0) setError(form[0][0]);
      if (form[0][2].value.length < 4) setError(form[0][2]);
      if (form[0][3].value.length < 10) {
        setError(form[0][3]);
      } else {
        const date = new Date(form[0][3].value);
        if (isNaN(date.getTime())) setError(form[0][3]);
      }
      if (form[0][4].value === '') setError(form[0][4]);

      return isValid;
    };

    const maskInput = (event, form) => {
      form[0][2].value = form[0][2].value.replace(/\D/g, '');
      form[0][2].value = form[0][2].value.replace(/(\d+)(\d{2})$/, "$1,$2");
      form[0][2].value = form[0][2].value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
      form[0][2].value = 'R$ ' + form[0][2].value;

      event.target.style.border = '1px solid #e2dfdf';
      event.target.style.borderBottom = '1px solid #e2dfdf';
    };

    form[0][5].addEventListener('click', addCont);
    formMobile[0][5].addEventListener('click', addContMobile);
    form[0].addEventListener('input', (event) => maskInput(event, form));
    formMobile[0].addEventListener('input', (event) => maskInput(event, formMobile));

    // Adiciona eventos após o carregamento da página
    document.addEventListener('DOMContentLoaded', addEvents);
  }
}