import outsideClick from "./outsideClick.js";

export default function buttonMenu(){

  const menu = document.querySelector('.menu-config');
  const dropdownMenu = document.querySelector('.dropdown-menu')
  
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