export default function todoList() {
  const form = document.querySelectorAll('form.formPLanejamento');
  const formMobile = document.querySelectorAll('form.formMobile');
  let value = 0;
  

  if (form.length || formMobile.length) {
    const gastosTotais = document.querySelector('#totaisGastos')

    const addTodo = (model) =>{
      const lista = document.querySelector('.listtodo')
      lista.innerHTML += model
    }

    const addEvents = () =>{
      const btnCheck = document.querySelectorAll('.btncheck')
      const btnTrash = document.querySelectorAll('.btntrash')
      btnCheck.forEach((btn) => {
        btn.addEventListener('click', ()=>{
              btn.parentElement.parentElement.style.textDecoration = 'line-through'
              btn.parentElement.parentElement.style.color = '#6e6d6d'
              btn.style.backgroundColor = '#504f4f'
              btn.disabled = true
        })
      });
      btnTrash.forEach((btn) =>{
        btn.addEventListener('click', ()=>{
              btn.parentElement.parentElement.remove()
              value = value - btn.parentElement.parentElement.childNodes[5].innerHTML.replace('R$ ','').split(',')[0]
              gastosTotais.value = value
        })
      })
    }

    const addCont = () => {
      const model = `<li class="todo">
                <h3 class="identif">${form[0][0].value}</h3>
                <p class="obstodo">${form[0][1].value}</p>
                <p class="precotodo">${form[0][2].value}</p>
                <p class="vencimentotodo">${form[0][3].value}</p>
                <p class="notftodo">${form[0][4].value}</p>
                <div class="btnstodo">
                  <button class= "btncheck"> pago <i class="fa-solid fa-check"></i> </button>
                  <button class= "btntrash"> excluir <i class="fa-solid fa-trash"></i> </button>
                </div>
              </li>`
      validyInputsDesktop(model);
      addEvents();
    }

    const validyInputsDesktop = (model) =>{
      const timeElapsed = Date.now();
      const today = new Date(timeElapsed);
      const currentYear = +today.toLocaleDateString().split('/')[2];
      if (form[0][0].value.length > 0 && form[0][2].value.length > 4 && form[0][3].value.length > 9 && form[0][4].value !== '') {
        form[0][0].style.borderBottom = '1px solid #e2dfdf'
        form[0][2].style.borderBottom = '1px solid #e2dfdf'
        form[0][3].style.borderBottom = '1px solid #e2dfdf'
        addTodo(model);
        addTotalGastosDesk();
      } else {
        if (form[0][0].value.length === 0) {
          form[0][0].style.borderBottom = '2px solid red'
          form[0][5].disabled = true
          setTimeout(()=>{form[0][5].disabled = false},200)
        } 
        if (form[0][2].value.length < 4) {
          form[0][2].style.borderBottom = '2px solid red'
          form[0][5].disabled = true
          setTimeout(()=>{form[0][5].disabled = false},200)
        }
        if (form[0][3].value.length < 10) {
          form[0][3].style.borderBottom = '2px solid red'
          form[0][5].disabled = true
          setTimeout(()=>{form[0][5].disabled = false},200)
          if (+form[0][3].value.split('/')[0] > 31) {
            form[0][3].style.borderBottom = '2px solid red'
            form[0][5].disabled = true
            setTimeout(()=>{form[0][5].disabled = false},200)
          } 
          if(+form[0][3].value.split('/')[1] > 12){
            form[0][3].style.borderBottom = '2px solid red'
            form[0][5].disabled = true
            setTimeout(()=>{form[0][5].disabled = false},200)
          } 
          if(+form[0][3].value.split('/')[2] < currentYear){
            form[0][3].style.borderBottom = '2px solid red'
            form[0][5].disabled = true
            setTimeout(()=>{form[0][5].disabled = false},200)
          }
        }
        if (form[0][4].value === '') {
          form[0][4].style.border = '2px solid red'
          form[0][5].disabled = true
          setTimeout(()=>{form[0][5].disabled = false},200)
        }
      }
    }

    const addTodoMobile = (model) =>{
      const lista = document.querySelector('.listtodoMobile')
      lista.innerHTML += model
    }

    const addTotalGastosDesk = () =>{
      const gastosTotais = document.querySelector('#totaisGastos')
      value = value + parseInt(form[0][2].value.replace('R$ ', '').replace(',', '.'))
      gastosTotais.value = value 
    }

    const addTotalGastos = () =>{
      const gastosTotais = document.querySelector('#totaisGastos')
      value = value + parseInt(formMobile[0][2].value.replace('R$ ', '').replace(',', '.'))
      gastosTotais.value = value 
    } 

    const addContMobile = () => {
      const model = `<li class="todo">
                <h3 class="identif">${formMobile[0][0].value}</h3>
                <p class="obstodo">${formMobile[0][1].value}</p>
                <p class="precotodo">${formMobile[0][2].value}</p>
                <p class="vencimentotodo">${formMobile[0][3].value}</p>
                <p class="notftodo">${formMobile[0][4].value}</p>
                <div class="btnstodo">
                  <button class= "btncheck"> pago <i class="fa-solid fa-check"></i> </button>
                  <button class= "btntrash"> excluir <i class="fa-solid fa-trash"></i> </button>
                </div>
              </li>`
      validyInputs(model);
      addEvents();
    }

    const validyInputs = (model) => {
      const timeElapsed = Date.now();
      const today = new Date(timeElapsed);
      const currentYear = +today.toLocaleDateString().split('/')[2];
      if (formMobile[0][0].value.length > 0 && formMobile[0][2].value.length > 4 && formMobile[0][3].value.length > 9 && formMobile[0][4].value !== '') {
        formMobile[0][0].style.borderBottom = '1px solid #e2dfdf'
        formMobile[0][2].style.borderBottom = '1px solid #e2dfdf'
        formMobile[0][3].style.borderBottom = '1px solid #e2dfdf'
        addTodoMobile(model);
        addTotalGastos();
      } else {
        if (formMobile[0][0].value.length === 0) {
          formMobile[0][0].style.borderBottom = '2px solid red'
          formMobile[0][5].disabled = true
          setTimeout(()=>{formMobile[0][5].disabled = false},200)
        } 
        if (formMobile[0][2].value.length < 4) {
          formMobile[0][2].style.borderBottom = '2px solid red'
          formMobile[0][5].disabled = true
          setTimeout(()=>{formMobile[0][5].disabled = false},200)
        }
        if (formMobile[0][3].value.length < 10) {
          formMobile[0][3].style.borderBottom = '2px solid red'
          formMobile[0][5].disabled = true
          setTimeout(()=>{formMobile[0][5].disabled = false},200)
          if (+formMobile[0][3].value.split('/')[0] > 31) {
            formMobile[0][3].style.borderBottom = '2px solid red'
            formMobile[0][5].disabled = true
            setTimeout(()=>{formMobile[0][5].disabled = false},200)
          } 
          if(+formMobile[0][3].value.split('/')[1] > 12){
            formMobile[0][3].style.borderBottom = '2px solid red'
            formMobile[0][5].disabled = true
            setTimeout(()=>{formMobile[0][5].disabled = false},200)
          } 
          if(+formMobile[0][3].value.split('/')[2] < currentYear){
            formMobile[0][3].style.borderBottom = '2px solid red'
            formMobile[0][5].disabled = true
            setTimeout(()=>{formMobile[0][5].disabled = false},200)
          }
        }
        if (formMobile[0][4].value === '') {
          formMobile[0][4].style.border = '2px solid red'
          formMobile[0][5].disabled = true
          setTimeout(()=>{formMobile[0][5].disabled = false},200)
        }
      }

    }

    const maskInput  = () =>{
      // mascara para o valor input no pc
      form[0][2].value = form[0][2].value.replace(/\D/g, '');
      form[0][2].value = form[0][2].value.replace(/(\d+)(\d{2})$/, "$1,$2");
      form[0][2].value = form[0][2].value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
      form[0][2].value = 'R$ ' + form[0][2].value

      form[0][3].value = form[0][3].value.replace(/\D/g, '');
      form[0][3].value = form[0][3].value.replace(/(\d{2})(\d{2})(\d{4})/g, '$1/$2/$3');

      event.target.style.border = '1px solid #e2dfdf'
      event.target.style.borderBottom = '1px solid #e2dfdf';
    }

    const maskInputMobile  = (event) =>{
      // mascara para o valor input no mobile
      formMobile[0][2].value = formMobile[0][2].value.replace(/\D/g, '');
      formMobile[0][2].value = formMobile[0][2].value.replace(/(\d+)(\d{2})$/, "$1,$2");
      formMobile[0][2].value = formMobile[0][2].value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
      formMobile[0][2].value = 'R$ ' + formMobile[0][2].value

      formMobile[0][3].value = formMobile[0][3].value.replace(/\D/g, '');
      formMobile[0][3].value = formMobile[0][3].value.replace(/(\d{2})(\d{2})(\d{4})/g, '$1/$2/$3');
      
      event.target.style.border = '1px solid #e2dfdf'
      event.target.style.borderBottom = '1px solid #e2dfdf';
    }

    form[0][5].addEventListener('click', addCont)
    formMobile[0][5].addEventListener('click', addContMobile)
    form[0].addEventListener('input', maskInput)
    formMobile[0].addEventListener('input', maskInputMobile)
  }

}
