import outsideClick from "./outsideClick.js";

export default function menuMobile() {
  const menuMobile = document.querySelector(".contentMenuMobile");
  const menuMobileIndex = document.querySelector(".contentMenuMobile-index");

  const activeClass = "active";
  const events = ["click"];

  if (menuMobile) {
    const sidebar = document.querySelector(".sidebar");

    function openMenuMobile() {
      sidebar.classList.add(activeClass);
      outsideClick(sidebar, events, () => {
        sidebar.classList.remove(activeClass);
      });
    }

    events.forEach((userEvents) => {
      menuMobile.addEventListener(userEvents, openMenuMobile);
    });
  } else if (menuMobileIndex) {
    const menuIndex = document.querySelector(".menuMobile-index");
    let positionScroll = 0;

    function openMenuMobile() {
      positionScroll = window.scrollY;
      window.addEventListener("scroll", scrollMenu);
      menuIndex.classList.add(activeClass);
      outsideClick(menuIndex, events, () => {
        menuIndex.classList.remove(activeClass);
      });
    }

    function scrollMenu() {
      if (!menuIndex.classList.contains(activeClass)) {
        window.removeEventListener("scroll", scrollMenu);
      } else if (positionScroll != window.scrollY) {
        menuIndex.classList.remove(activeClass);
        console.log(positionScroll);
      }
    }

    events.forEach((userEvents) => {
      menuMobileIndex.addEventListener(userEvents, openMenuMobile);
    });
  }
}
