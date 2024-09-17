import outsideClick from "./outsideClick.js";

export default function menuMobile(){

  const menuMobile = document.querySelector('.contentMenuMobile');
  const menuMobileIndex = document.querySelector(".contentMenuMobile-index")

  const activeClass = 'active';
  const events = ["click"]

  if (menuMobile) {
    const sidebar = document.querySelector('.sidebar')

    function openMenuMobile(){
      sidebar.classList.add(activeClass);
      outsideClick(sidebar, events, () =>{
        sidebar.classList.remove(activeClass);
      })
    }
  
    events.forEach((userEvents) =>{
      menuMobile.addEventListener(userEvents, openMenuMobile);
    })
  } if (menuMobileIndex) {
    const menuIndex = document.querySelector(".menuMobile-index")

    function openMenuMobile(){
      menuIndex.classList.add(activeClass);
      outsideClick(menuIndex, events, () =>{
        menuIndex.classList.remove(activeClass);
      })
    }

    events.forEach((userEvents) =>{
      menuMobileIndex.addEventListener(userEvents, openMenuMobile);
    })
  }

}
