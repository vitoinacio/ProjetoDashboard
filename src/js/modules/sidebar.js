export default function sidebar(){

  const sidebar = document.querySelectorAll('sidebar a');
  const activeClass = "active";

  function activeTab(index) {
    sidebar.forEach((item) => {
      item.classList.remove(activeClass);
    });
    sidebar[index].classList.add(activeClass);
  }

  function addTabNavEvent() {
    sidebar.forEach((itemMenu, index) => {
      itemMenu.addEventListener("click", () => activeTab(index));
    });
  }

  function init() {
    if (sidebar.length) {
      //ativar primeiro item
      activeTab(0);
      addTabNavEvent();
      console.log('iii')
    }
  }
  init();

}