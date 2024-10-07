export default function todoList() {
  const form = document.querySelectorAll('form.formPLanejamento');
  const formMobile = document.querySelectorAll('form.formMobile');
  let value = 0;

  if (form.length || formMobile.length) {
    const gastosTotais = document.querySelector('#totaisGastos');
    let value = 0;
  
    const addTodo = (model, selector) => {
      const lista = document.querySelector(selector);
      lista.innerHTML += model;
    };
  
    const addEvents = () => {
      const btnCheck = document.querySelectorAll('.btncheck');
      const btnTrash = document.querySelectorAll('.btntrash');

      btnCheck.forEach((btn) => {
        btn.addEventListener('click', () => {
          btn.parentElement.parentElement.style.textDecoration = 'line-through';
          btn.parentElement.parentElement.setAttribute('title', 'Pago');
          btn.parentElement.parentElement.style.backgroundColor = '#e2dfdf';
          btn.parentElement.parentElement.style.color = '#6e6d6d';
          btn.style.backgroundColor = '#504f4f';
          btn.disabled = true;
        });
      });
      btnTrash.forEach((btn) => {
        btn.addEventListener('click', () => {
          const item = btn.parentElement.parentElement;
          item.remove();
          value -= parseFloat(item.querySelector('.precotodo').innerText.replace('R$ ', '').replace(',', '.'));
          gastosTotais.value = value.toFixed(2);
        });
      });
    };

    const checkDueDate = (item) => {
      const timeElapsed = Date.now();
      const today = new Date(timeElapsed);
      
      const dueDateText = item.querySelector('.vencimentotodo').innerText;
      const [day, month, year] = dueDateText.split('/');
      const dueDate = new Date(`${year}-${month}-${day}`);
      
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
        addTotalGastos(form);
        const item = document.querySelector('.listtodo').lastElementChild;
        checkDueDate(item);
        addEvents();
      }
    };

    const addContMobile = () => {
      const model = createModel(formMobile);
      if (validyInputs(formMobile)) {
        addTodo(model, '.listtodo');
        addTotalGastos(formMobile);
        const item = document.querySelector('.listtodo').lastElementChild;
        checkDueDate(item);
        addEvents();
      }
    };
  
    const createModel = (form) => {
      return `<li class="todo">
                <h3 class="identif">${form[0][0].value}</h3>
                <p class="obstodo">${form[0][1].value}</p>
                <p class="precotodo">${form[0][2].value}</p>
                <p class="vencimentotodo">${form[0][3].value}</p>
                <p class="notftodo">${form[0][4].value}</p>
                <div class="btnstodo">
                  <button class="btncheck"> pago <i class="fa-solid fa-check"></i> </button>
                  <button class="btntrash"> excluir <i class="fa-solid fa-trash"></i> </button>
                </div>
              </li>`;
    };

    const validyInputs = (form) => {
      const timeElapsed = Date.now();
      const today = new Date(timeElapsed);
      const currentYear = today.getFullYear();
      const currentMonth = today.getMonth() + 1;
      const currentDay = today.getDate();
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
        const [day, month, year] = form[0][3].value.split('/');
        const date = new Date(`${year}-${month}-${day}`);
        if (
          +day > 31 || +month > 12 || 
          +year < currentYear || 
          (+year === currentYear && +month < currentMonth) || 
          (+year === currentYear && +month === currentMonth && +day < currentDay)
        ) {
          setError(form[0][3]);
        }
      }
      if (form[0][4].value === '') setError(form[0][4]);
    
      return isValid;
    };


    const addTotalGastos = (form) => {
      let valor = form[0][2].value.replace(/[^\d,.-]/g, '');
      valor = valor.replace(',', '.');
      const valorNumerico = parseFloat(valor);
      value += valorNumerico;
      gastosTotais.value = value.toFixed(2);
    };
  
    const maskInput = (event, form) => {
      form[0][2].value = form[0][2].value.replace(/\D/g, '');
      form[0][2].value = form[0][2].value.replace(/(\d+)(\d{2})$/, "$1,$2");
      form[0][2].value = form[0][2].value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
      form[0][2].value = 'R$ ' + form[0][2].value;
  
      form[0][3].value = form[0][3].value.replace(/\D/g, '');
      form[0][3].value = form[0][3].value.replace(/(\d{2})(\d{2})(\d{4})/g, '$1/$2/$3');
  
      event.target.style.border = '1px solid #e2dfdf';
      event.target.style.borderBottom = '1px solid #e2dfdf';
    };
  
    form[0][5].addEventListener('click', addCont);
    formMobile[0][5].addEventListener('click', addContMobile);
    form[0].addEventListener('input', (event) => maskInput(event, form));
    formMobile[0].addEventListener('input', (event) => maskInput(event, formMobile));
  }

  
}