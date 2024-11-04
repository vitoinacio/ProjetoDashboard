import outsideClick from "./outsideClick.js";

export default function buttonMenu(){

  const menu = document.querySelector('.menu-config');
  const dropdownMenu = document.querySelector('.dropdown-menu')

  const emailUser = document.querySelectorAll('#emailConfig')
  const NomeUser = document.querySelectorAll('#NomeUsuario')
  const key = sessionStorage.getItem('logedUser');

  if (key !== null) {
    const userDados = localStorage.getItem(key);
    if (userDados) {
      const user = JSON.parse(userDados);
      if (emailUser.length && NomeUser.length) {
        emailUser.forEach((email)=>{
          email.innerText = user.emailUser
        })
        NomeUser.forEach((nome)=>{
          nome.innerHTML = user.nome.split(' ')[0] + ' ' +user.nome.split(' ')[1]
        })
      }
    }
  }

  if (dropdownMenu) {
    const activeClass = 'active';
    const events = ["click"]

    function openMenu(){
      dropdownMenu.classList.add(activeClass);
      outsideClick(dropdownMenu, events, () =>{
        dropdownMenu.classList.remove(activeClass);
      })
    }
  
    events.forEach((userEvents) =>{
      menu.addEventListener(userEvents, openMenu);
    })
  }

}