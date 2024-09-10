import outsideClick from "./outsideClick.js";
export default function menuMobile(){

  const menuMobile = document.querySelector('.contentMenuMobile');
  const sidebar = document.querySelector('.sidebar')
  const activeClass = 'active';
  const events = ["touchstart", "click"]

  function openMenuMobile(){
    sidebar.classList.add(activeClass);
    outsideClick(sidebar, events, () =>{
      sidebar.classList.remove(activeClass);
    })
  }
  
  events.forEach(userEvents () =>{
    menuMobile.addEventListener(userEvents, openMenuMobile);
  })

}
